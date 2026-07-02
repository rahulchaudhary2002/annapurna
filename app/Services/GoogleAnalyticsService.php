<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GoogleAnalyticsService
{
    private ?string $propertyId;
    private ?array  $credentials;

    public function __construct()
    {
        $this->propertyId = config('services.google_analytics.property_id');

        $inline   = config('services.google_analytics.service_account_json');
        $filePath = config('services.google_analytics.service_account_path');

        if ($inline) {
            $this->credentials = json_decode($inline, true);
        } elseif ($filePath) {
            // Support absolute paths or paths relative to base_path()
            $abs = str_starts_with($filePath, '/')
                ? $filePath
                : base_path(ltrim($filePath, '/'));
            $this->credentials = file_exists($abs) ? json_decode(file_get_contents($abs), true) : null;
        } else {
            $this->credentials = null;
        }
    }

    public function isConfigured(): bool
    {
        return !empty($this->propertyId)
            && !empty($this->credentials['private_key'])
            && !empty($this->credentials['client_email']);
    }

    // ── JWT / Token helpers ──────────────────────────────────────────────────

    private function b64u(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function getAccessToken(): string
    {
        return Cache::remember('ga4_access_token', 3500, function () {
            $now     = time();
            $header  = $this->b64u(json_encode(['alg' => 'RS256', 'typ' => 'JWT']));
            $payload = $this->b64u(json_encode([
                'iss'   => $this->credentials['client_email'],
                'scope' => 'https://www.googleapis.com/auth/analytics.readonly',
                'aud'   => 'https://oauth2.googleapis.com/token',
                'iat'   => $now,
                'exp'   => $now + 3600,
            ]));

            $unsigned = "$header.$payload";
            openssl_sign($unsigned, $sig, $this->credentials['private_key'], 'sha256WithRSAEncryption');

            $jwt  = "$unsigned." . $this->b64u($sig);
            $resp = Http::asForm()->timeout(10)->post('https://oauth2.googleapis.com/token', [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion'  => $jwt,
            ]);

            return $resp->json('access_token', '');
        });
    }

    private function api(string $endpoint, array $body): array
    {
        try {
            $token = $this->getAccessToken();
            if (!$token) return ['error' => 'no_token'];

            $resp = Http::withToken($token)
                ->timeout(12)
                ->post("https://analyticsdata.googleapis.com/v1beta/properties/{$this->propertyId}:{$endpoint}", $body);

            return $resp->json() ?? [];
        } catch (\Throwable $e) {
            return ['error' => $e->getMessage()];
        }
    }

    // ── Public API methods ───────────────────────────────────────────────────

    public function getOverview(int $days = 30): array
    {
        return Cache::remember("ga4_overview_{$days}", 3600, function () use ($days) {
            $r   = $this->api('runReport', [
                'dateRanges' => [['startDate' => "{$days}daysAgo", 'endDate' => 'today']],
                'metrics'    => array_map(fn ($n) => ['name' => $n], [
                    'sessions', 'activeUsers', 'screenPageViews',
                    'bounceRate', 'averageSessionDuration', 'newUsers',
                ]),
            ]);
            $row = $r['rows'][0]['metricValues'] ?? [];
            return [
                'sessions'           => (int)   ($row[0]['value'] ?? 0),
                'users'              => (int)   ($row[1]['value'] ?? 0),
                'pageviews'          => (int)   ($row[2]['value'] ?? 0),
                'bounceRate'         => round((float)($row[3]['value'] ?? 0) * 100, 1),
                'avgSessionDuration' => (int)  round((float)($row[4]['value'] ?? 0)),
                'newUsers'           => (int)   ($row[5]['value'] ?? 0),
            ];
        });
    }

    public function getSessionsTrend(int $days = 30): array
    {
        return Cache::remember("ga4_trend_{$days}", 3600, function () use ($days) {
            $r = $this->api('runReport', [
                'dateRanges' => [['startDate' => "{$days}daysAgo", 'endDate' => 'today']],
                'dimensions' => [['name' => 'date']],
                'metrics'    => [['name' => 'sessions'], ['name' => 'activeUsers'], ['name' => 'screenPageViews']],
                'orderBys'   => [['dimension' => ['dimensionName' => 'date']]],
            ]);

            return collect($r['rows'] ?? [])->map(fn ($row) => [
                'date'     => Carbon::createFromFormat('Ymd', $row['dimensionValues'][0]['value'])->format('d M'),
                'sessions' => (int) $row['metricValues'][0]['value'],
                'users'    => (int) $row['metricValues'][1]['value'],
                'views'    => (int) $row['metricValues'][2]['value'],
            ])->values()->toArray();
        });
    }

    public function getTrafficSources(int $days = 30): array
    {
        return Cache::remember("ga4_sources_{$days}", 3600, function () use ($days) {
            $r = $this->api('runReport', [
                'dateRanges' => [['startDate' => "{$days}daysAgo", 'endDate' => 'today']],
                'dimensions' => [['name' => 'sessionDefaultChannelGroup']],
                'metrics'    => [['name' => 'sessions'], ['name' => 'activeUsers']],
                'orderBys'   => [['metric' => ['metricName' => 'sessions'], 'desc' => true]],
                'limit'      => 8,
            ]);

            $rows = collect($r['rows'] ?? [])->map(fn ($row) => [
                'channel'  => $row['dimensionValues'][0]['value'],
                'sessions' => (int) $row['metricValues'][0]['value'],
                'users'    => (int) $row['metricValues'][1]['value'],
            ]);

            $total = max(1, $rows->sum('sessions'));
            return $rows->map(fn ($r) => [...$r, 'pct' => round($r['sessions'] / $total * 100)])->toArray();
        });
    }

    public function getTopPages(int $limit = 10, int $days = 30): array
    {
        return Cache::remember("ga4_pages_{$limit}_{$days}", 3600, function () use ($limit, $days) {
            $r = $this->api('runReport', [
                'dateRanges' => [['startDate' => "{$days}daysAgo", 'endDate' => 'today']],
                'dimensions' => [['name' => 'pagePath'], ['name' => 'pageTitle']],
                'metrics'    => [['name' => 'screenPageViews'], ['name' => 'activeUsers'], ['name' => 'averageSessionDuration']],
                'orderBys'   => [['metric' => ['metricName' => 'screenPageViews'], 'desc' => true]],
                'limit'      => $limit,
            ]);

            return collect($r['rows'] ?? [])->map(fn ($row) => [
                'path'     => $row['dimensionValues'][0]['value'],
                'title'    => $row['dimensionValues'][1]['value'],
                'views'    => (int) $row['metricValues'][0]['value'],
                'users'    => (int) $row['metricValues'][1]['value'],
                'duration' => (int) round((float) $row['metricValues'][2]['value']),
            ])->toArray();
        });
    }

    public function getDeviceBreakdown(int $days = 30): array
    {
        return Cache::remember("ga4_devices_{$days}", 3600, function () use ($days) {
            $r = $this->api('runReport', [
                'dateRanges' => [['startDate' => "{$days}daysAgo", 'endDate' => 'today']],
                'dimensions' => [['name' => 'deviceCategory']],
                'metrics'    => [['name' => 'sessions']],
                'orderBys'   => [['metric' => ['metricName' => 'sessions'], 'desc' => true]],
            ]);

            $rows  = collect($r['rows'] ?? [])->map(fn ($row) => [
                'device'   => ucfirst($row['dimensionValues'][0]['value']),
                'sessions' => (int) $row['metricValues'][0]['value'],
            ]);
            $total = max(1, $rows->sum('sessions'));
            return $rows->map(fn ($r) => [...$r, 'pct' => round($r['sessions'] / $total * 100)])->toArray();
        });
    }

    public function getCountries(int $limit = 8, int $days = 30): array
    {
        return Cache::remember("ga4_countries_{$limit}_{$days}", 3600, function () use ($limit, $days) {
            $r = $this->api('runReport', [
                'dateRanges' => [['startDate' => "{$days}daysAgo", 'endDate' => 'today']],
                'dimensions' => [['name' => 'country']],
                'metrics'    => [['name' => 'activeUsers'], ['name' => 'sessions']],
                'orderBys'   => [['metric' => ['metricName' => 'activeUsers'], 'desc' => true]],
                'limit'      => $limit,
            ]);

            $rows  = collect($r['rows'] ?? [])->map(fn ($row) => [
                'country'  => $row['dimensionValues'][0]['value'],
                'users'    => (int) $row['metricValues'][0]['value'],
                'sessions' => (int) $row['metricValues'][1]['value'],
            ]);
            $max = max(1, $rows->max('users'));
            return $rows->map(fn ($r) => [...$r, 'pct' => round($r['users'] / $max * 100)])->toArray();
        });
    }

    public function getTopEvents(int $days = 30): array
    {
        return Cache::remember("ga4_events_{$days}", 3600, function () use ($days) {
            $r = $this->api('runReport', [
                'dateRanges' => [['startDate' => "{$days}daysAgo", 'endDate' => 'today']],
                'dimensions' => [['name' => 'eventName']],
                'metrics'    => [['name' => 'eventCount'], ['name' => 'activeUsers']],
                'orderBys'   => [['metric' => ['metricName' => 'eventCount'], 'desc' => true]],
                'limit'      => 8,
            ]);

            return collect($r['rows'] ?? [])->map(fn ($row) => [
                'event' => $row['dimensionValues'][0]['value'],
                'count' => (int) $row['metricValues'][0]['value'],
                'users' => (int) $row['metricValues'][1]['value'],
            ])->toArray();
        });
    }

    public function getRealtimeUsers(): int
    {
        try {
            $r = $this->api('runRealtimeReport', ['metrics' => [['name' => 'activeUsers']]]);
            return (int) ($r['rows'][0]['metricValues'][0]['value'] ?? 0);
        } catch (\Throwable) {
            return 0;
        }
    }

    public function clearCache(): void
    {
        foreach (['ga4_access_token', 'ga4_overview_30', 'ga4_trend_30', 'ga4_sources_30',
                  'ga4_pages_10_30', 'ga4_devices_30', 'ga4_countries_8_30', 'ga4_events_30'] as $key) {
            Cache::forget($key);
        }
    }
}
