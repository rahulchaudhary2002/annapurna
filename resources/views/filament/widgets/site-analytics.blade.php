@pushOnce('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@endPushOnce

@php
    // GA chart data
    $gaTrendLabels   = $gaConnected ? json_encode(collect($gaData['trend'])->pluck('date'))    : '[]';
    $gaTrendSessions = $gaConnected ? json_encode(collect($gaData['trend'])->pluck('sessions')) : '[]';
    $gaTrendUsers    = $gaConnected ? json_encode(collect($gaData['trend'])->pluck('users'))    : '[]';
    $gaTrendViews    = $gaConnected ? json_encode(collect($gaData['trend'])->pluck('views'))    : '[]';

    $srcLabels  = $gaConnected ? json_encode(collect($gaData['sources'])->pluck('channel'))  : '[]';
    $srcValues  = $gaConnected ? json_encode(collect($gaData['sources'])->pluck('sessions')) : '[]';
    $srcColors  = json_encode(['#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6','#06b6d4','#ec4899','#84cc16']);

    // Internal chart data
    $feedLabels  = json_encode($feedViewsTrend->pluck('label'));
    $feedViews   = json_encode($feedViewsTrend->pluck('views'));
    $feedLikes   = json_encode($feedViewsTrend->pluck('likes'));
    $feedShares  = json_encode($feedViewsTrend->pluck('shares'));

    $bizLabels  = json_encode($bizViewsTrend->pluck('label'));
    $bizViews   = json_encode($bizViewsTrend->pluck('views'));
    $bizClicks  = json_encode($bizViewsTrend->pluck('clicks'));

    $growthLabels    = json_encode($growthMonths->pluck('label'));
    $growthUsers     = json_encode($growthMonths->pluck('users'));
    $growthBiz       = json_encode($growthMonths->pluck('businesses'));
    $growthBookings  = json_encode($growthMonths->pluck('bookings'));
    $growthInquiries = json_encode($growthMonths->pluck('inquiries'));

    $srcColorMap = ['#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6','#06b6d4','#ec4899'];
    $funnelTotal = max(1, collect($funnel)->first()['count']);
@endphp

<div style="display:flex; flex-direction:column; gap:14px; font-family:inherit;">

{{-- ── Top bar: Day filter + refresh ─────────────────────────────────────── --}}
<div style="display:flex; align-items:center; justify-content:space-between;">
    <div style="display:flex; align-items:center; gap:6px;">
        @foreach([7=>'7 Days',30=>'30 Days',90=>'90 Days'] as $d => $label)
        <a href="?days={{ $d }}"
           style="padding:5px 14px; border-radius:6px; font-size:12px; font-weight:600; text-decoration:none;
                  {{ $days === $d ? 'background:#0f172a; color:#fff;' : 'background:#f1f5f9; color:#64748b; border:1px solid #e2e8f0;' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>
    @if($gaConnected)
    <div style="display:flex; align-items:center; gap:6px;">
        <span style="width:8px; height:8px; border-radius:50%; background:#10b981;"></span>
        <span style="font-size:11px; color:#64748b; font-weight:500;">Google Analytics Connected</span>
        <span style="font-size:11px; color:#94a3b8;">·</span>
        <span style="font-size:11px; color:#94a3b8;">Property: {{ config('services.google_analytics.property_id') }}</span>
    </div>
    @else
    <div style="display:flex; align-items:center; gap:6px;">
        <span style="width:8px; height:8px; border-radius:50%; background:#f59e0b;"></span>
        <span style="font-size:11px; color:#92400e; font-weight:500;">Google Analytics not connected</span>
    </div>
    @endif
</div>

{{-- ═══════════════════════════════════════════════════════════════════════════ --}}
{{-- ── GOOGLE ANALYTICS SECTION ─────────────────────────────────────────── --}}
{{-- ═══════════════════════════════════════════════════════════════════════════ --}}

@if($gaConnected)
{{-- GA Overview KPI cards ─────────────────────────────────────────────────── --}}
<div style="display:grid; grid-template-columns:repeat(6,1fr); gap:10px;">
    @php
        $gaKpis = [
            ['Real-time Users', $gaData['realtime'], '🟢', '#10b981', 'Active right now'],
            ['Sessions',        number_format($gaData['overview']['sessions']), '📊', '#3b82f6', "Last {$days} days"],
            ['Users',           number_format($gaData['overview']['users']),    '👤', '#8b5cf6', number_format($gaData['overview']['newUsers']).' new'],
            ['Pageviews',       number_format($gaData['overview']['pageviews']),'👁',  '#f59e0b', "Last {$days} days"],
            ['Bounce Rate',     $gaData['overview']['bounceRate'].'%',          '↩',  '#ef4444', 'Avg across sessions'],
            ['Avg Duration',    gmdate('i:s', $gaData['overview']['avgSessionDuration']), '⏱', '#06b6d4', 'Min:sec per session'],
        ];
    @endphp
    @foreach($gaKpis as [$title, $value, $icon, $color, $sub])
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; padding:14px 16px;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:6px;">
            <span style="font-size:16px;">{{ $icon }}</span>
            <span style="font-size:10px; color:#94a3b8; font-weight:500;">{{ $title }}</span>
        </div>
        <p style="font-size:20px; font-weight:800; color:#0f172a; margin:0 0 2px; line-height:1;">{{ $value }}</p>
        <p style="font-size:10px; color:#64748b; margin:0;">{{ $sub }}</p>
    </div>
    @endforeach
</div>

{{-- GA Charts Row 1: Trend + Traffic Sources ─────────────────────────────── --}}
<div style="display:grid; grid-template-columns:2fr 1fr; gap:12px;">

    {{-- Sessions / Users / Pageviews trend --}}
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; overflow:hidden;">
        <div style="padding:12px 18px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between;">
            <div>
                <p style="font-size:13px; font-weight:700; color:#0f172a; margin:0; line-height:1;">Sessions Trend</p>
                <p style="font-size:10px; color:#94a3b8; margin:2px 0 0;">{{ $days }}-day breakdown</p>
            </div>
            <div style="display:flex; gap:12px; font-size:10px; color:#64748b;">
                <span style="display:flex; align-items:center; gap:3px;"><span style="width:10px;height:3px;background:#3b82f6;border-radius:2px;display:inline-block;"></span> Sessions</span>
                <span style="display:flex; align-items:center; gap:3px;"><span style="width:10px;height:3px;background:#10b981;border-radius:2px;display:inline-block;"></span> Users</span>
                <span style="display:flex; align-items:center; gap:3px;"><span style="width:10px;height:3px;background:#f59e0b;border-radius:2px;display:inline-block;"></span> Pageviews</span>
            </div>
        </div>
        <div style="padding:14px 18px; height:180px;">
            <canvas id="ga-trend-chart" style="width:100%;height:100%;"></canvas>
        </div>
    </div>

    {{-- Traffic Sources donut --}}
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; overflow:hidden;">
        <div style="padding:12px 18px; border-bottom:1px solid #f1f5f9;">
            <p style="font-size:13px; font-weight:700; color:#0f172a; margin:0; line-height:1;">Traffic Sources</p>
            <p style="font-size:10px; color:#94a3b8; margin:2px 0 0;">by channel group</p>
        </div>
        <div style="padding:14px 18px; display:flex; gap:14px; align-items:center;">
            <div style="width:100px; height:100px; flex-shrink:0;">
                <canvas id="ga-source-donut"></canvas>
            </div>
            <div style="flex:1; display:flex; flex-direction:column; gap:4px;">
                @foreach(array_values($gaData['sources']) as $i => $src)
                <div style="display:flex; align-items:center; justify-content:space-between; gap:8px;">
                    <div style="display:flex; align-items:center; gap:5px; min-width:0;">
                        <span style="width:7px;height:7px;border-radius:50%;background:{{ $srcColorMap[$i % 7] }};flex-shrink:0;"></span>
                        <span style="font-size:10px; color:#475569; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $src['channel'] }}</span>
                    </div>
                    <div style="display:flex; align-items:center; gap:4px; flex-shrink:0;">
                        <span style="font-size:10px; color:#94a3b8;">{{ $src['pct'] }}%</span>
                        <span style="font-size:11px; font-weight:700; color:#0f172a;">{{ number_format($src['sessions']) }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- GA Charts Row 2: Top Pages + Devices + Countries ────────────────────── --}}
<div style="display:grid; grid-template-columns:2fr 1fr; gap:12px;">

    {{-- Top Pages table --}}
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; overflow:hidden;">
        <div style="padding:12px 18px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between;">
            <p style="font-size:13px; font-weight:700; color:#0f172a; margin:0;">Top Pages</p>
            <span style="font-size:10px; color:#94a3b8;">by pageviews</span>
        </div>
        <table style="width:100%; border-collapse:collapse; font-size:11px;">
            <thead>
                <tr style="background:#f8fafc;">
                    <th style="padding:8px 18px; text-align:left; color:#94a3b8; font-size:10px; font-weight:600; text-transform:uppercase; border-bottom:1px solid #f1f5f9;">Path</th>
                    <th style="padding:8px 8px; text-align:center; color:#94a3b8; font-size:10px; font-weight:600; text-transform:uppercase; border-bottom:1px solid #f1f5f9;">Views</th>
                    <th style="padding:8px 8px; text-align:center; color:#94a3b8; font-size:10px; font-weight:600; text-transform:uppercase; border-bottom:1px solid #f1f5f9;">Users</th>
                    <th style="padding:8px 18px; text-align:right; color:#94a3b8; font-size:10px; font-weight:600; text-transform:uppercase; border-bottom:1px solid #f1f5f9;">Avg Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($gaData['pages'] as $i => $page)
                <tr style="{{ $i % 2 ? 'background:#fafafa;' : '' }}">
                    <td style="padding:8px 18px; border-bottom:1px solid #f8fafc;">
                        <p style="font-size:11px; font-weight:600; color:#0f172a; margin:0; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; max-width:250px;">{{ $page['path'] }}</p>
                        <p style="font-size:10px; color:#94a3b8; margin:1px 0 0; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $page['title'] }}</p>
                    </td>
                    <td style="padding:8px; text-align:center; font-weight:700; color:#0f172a; border-bottom:1px solid #f8fafc;">{{ number_format($page['views']) }}</td>
                    <td style="padding:8px; text-align:center; color:#64748b; border-bottom:1px solid #f8fafc;">{{ number_format($page['users']) }}</td>
                    <td style="padding:8px 18px; text-align:right; color:#64748b; border-bottom:1px solid #f8fafc;">{{ gmdate('i:s', $page['duration']) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Devices + Countries stacked --}}
    <div style="display:flex; flex-direction:column; gap:12px;">

        {{-- Device breakdown --}}
        <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; overflow:hidden;">
            <div style="padding:12px 18px; border-bottom:1px solid #f1f5f9;">
                <p style="font-size:13px; font-weight:700; color:#0f172a; margin:0;">Devices</p>
            </div>
            <div style="padding:14px 18px; display:flex; flex-direction:column; gap:8px;">
                @foreach($gaData['devices'] as $dev)
                <div>
                    <div style="display:flex; justify-content:space-between; font-size:11px; margin-bottom:3px;">
                        <span style="font-weight:500; color:#374151;">{{ $dev['device'] }}</span>
                        <span style="font-weight:700; color:#0f172a;">{{ $dev['pct'] }}% <span style="color:#94a3b8; font-weight:400;">({{ number_format($dev['sessions']) }})</span></span>
                    </div>
                    <div style="height:5px; background:#f1f5f9; border-radius:3px; overflow:hidden;">
                        <div style="height:5px; width:{{ $dev['pct'] }}%; background:#3b82f6; border-radius:3px;"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Countries --}}
        <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; overflow:hidden; flex:1;">
            <div style="padding:12px 18px; border-bottom:1px solid #f1f5f9;">
                <p style="font-size:13px; font-weight:700; color:#0f172a; margin:0;">Top Countries</p>
            </div>
            <div style="padding:10px 18px; display:flex; flex-direction:column; gap:6px;">
                @foreach($gaData['countries'] as $co)
                <div style="display:flex; align-items:center; justify-content:space-between; gap:8px;">
                    <span style="font-size:11px; color:#374151; font-weight:500; min-width:80px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $co['country'] }}</span>
                    <div style="flex:1; height:4px; background:#f1f5f9; border-radius:2px; overflow:hidden;">
                        <div style="height:4px; width:{{ $co['pct'] }}%; background:#8b5cf6; border-radius:2px;"></div>
                    </div>
                    <span style="font-size:11px; font-weight:700; color:#0f172a; flex-shrink:0;">{{ number_format($co['users']) }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- GA Events --}}
@if(!empty($gaData['events']))
<div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; overflow:hidden;">
    <div style="padding:12px 18px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between;">
        <p style="font-size:13px; font-weight:700; color:#0f172a; margin:0;">Top Events</p>
        <span style="font-size:10px; color:#94a3b8;">last {{ $days }} days</span>
    </div>
    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:0;">
        @foreach(array_slice($gaData['events'], 0, 8) as $i => $ev)
        <div style="padding:12px 18px; {{ $i < 4 ? 'border-bottom:1px solid #f1f5f9;' : '' }} {{ $i % 4 !== 3 ? 'border-right:1px solid #f1f5f9;' : '' }}">
            <p style="font-size:11px; font-weight:600; color:#0f172a; margin:0; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $ev['event'] }}</p>
            <p style="font-size:18px; font-weight:800; color:#3b82f6; margin:4px 0 1px; line-height:1;">{{ number_format($ev['count']) }}</p>
            <p style="font-size:10px; color:#94a3b8; margin:0;">{{ number_format($ev['users']) }} users</p>
        </div>
        @endforeach
    </div>
</div>
@endif

@else
{{-- GA Setup Instructions ────────────────────────────────────────────────── --}}
<div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; overflow:hidden;">
    <div style="padding:14px 20px; background:linear-gradient(135deg,#eff6ff,#f0fdf4); border-bottom:1px solid #e2e8f0; display:flex; align-items:center; gap:10px;">
        <div style="width:36px; height:36px; border-radius:8px; background:#fff; display:flex; align-items:center; justify-content:center; box-shadow:0 1px 3px rgba(0,0,0,.1);">
            <svg width="20" height="20" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
        </div>
        <div>
            <p style="font-size:14px; font-weight:700; color:#0f172a; margin:0; line-height:1;">Connect Google Analytics 4</p>
            <p style="font-size:11px; color:#64748b; margin:2px 0 0;">{{ $gaError ? 'Error: '.$gaError : 'Follow the steps below to start seeing your real-time GA4 data here.' }}</p>
        </div>
    </div>
    <div style="padding:20px; display:grid; grid-template-columns:1fr 1fr; gap:20px;">
        <div>
            <p style="font-size:12px; font-weight:700; color:#1e293b; margin:0 0 12px; text-transform:uppercase; letter-spacing:.05em;">Setup Steps</p>
            @foreach([
                ['1', 'Create a GA4 property', 'Go to analytics.google.com → Admin → Create Property.'],
                ['2', 'Create a Service Account', 'In Google Cloud Console → IAM & Admin → Service Accounts → Create.'],
                ['3', 'Download JSON credentials', 'Generate a key for the service account, download the JSON file.'],
                ['4', 'Grant GA4 access', 'In GA4 Admin → Property Access Management → Add your service account email as Viewer.'],
                ['5', 'Upload credentials file', 'Place the JSON file in your Laravel storage/app/ directory.'],
                ['6', 'Set environment variables', 'Add the variables shown on the right to your .env file.'],
            ] as [$num, $title, $desc])
            <div style="display:flex; gap:10px; margin-bottom:12px; align-items:flex-start;">
                <div style="width:22px; height:22px; border-radius:50%; background:#3b82f6; color:#fff; font-size:11px; font-weight:700; display:flex; align-items:center; justify-content:center; flex-shrink:0;">{{ $num }}</div>
                <div>
                    <p style="font-size:12px; font-weight:600; color:#0f172a; margin:0 0 1px;">{{ $title }}</p>
                    <p style="font-size:11px; color:#64748b; margin:0;">{{ $desc }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div>
            <p style="font-size:12px; font-weight:700; color:#1e293b; margin:0 0 12px; text-transform:uppercase; letter-spacing:.05em;">Add to .env</p>
            <div style="background:#0f172a; border-radius:8px; padding:16px; font-family:monospace; font-size:12px; line-height:1.8; color:#94a3b8;">
                <span style="color:#475569;"># Google Analytics 4</span><br>
                <span style="color:#f59e0b;">GA_PROPERTY_ID</span>=<span style="color:#10b981;">properties/123456789</span><br>
                <br>
                <span style="color:#475569;"># Option A — file path (relative to storage/app/)</span><br>
                <span style="color:#f59e0b;">GA_SERVICE_ACCOUNT_PATH</span>=<span style="color:#10b981;">google-credentials.json</span><br>
                <br>
                <span style="color:#475569;"># Option B — inline JSON string</span><br>
                <span style="color:#f59e0b;">GA_SERVICE_ACCOUNT_JSON</span>=<span style="color:#10b981;">{"type":"service_account",...}</span>
            </div>
            <div style="margin-top:12px; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:12px;">
                <p style="font-size:11px; font-weight:600; color:#166534; margin:0 0 4px;">Where to find your Property ID</p>
                <p style="font-size:11px; color:#14532d; margin:0;">GA4 Admin → Property Settings → Property ID. Prefix with "properties/" (e.g., properties/123456789).</p>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ═══════════════════════════════════════════════════════════════════════════ --}}
{{-- ── INTERNAL ANALYTICS SECTION ──────────────────────────────────────── --}}
{{-- ═══════════════════════════════════════════════════════════════════════════ --}}

{{-- Section divider --}}
<div style="display:flex; align-items:center; gap:12px; margin-top:4px;">
    <span style="font-size:12px; font-weight:700; color:#0f172a; text-transform:uppercase; letter-spacing:.06em; white-space:nowrap;">Internal Analytics</span>
    <div style="flex:1; height:1px; background:#e2e8f0;"></div>
    <span style="font-size:11px; color:#94a3b8; white-space:nowrap;">Powered by your database</span>
</div>

{{-- ── Conversion Funnel ────────────────────────────────────────────────────── --}}
<div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; overflow:hidden;">
    <div style="padding:12px 20px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between;">
        <div>
            <p style="font-size:13px; font-weight:700; color:#0f172a; margin:0; line-height:1;">Conversion Funnel</p>
            <p style="font-size:10px; color:#94a3b8; margin:2px 0 0;">Last {{ $days }} days — Profile Views → Confirmed Bookings</p>
        </div>
    </div>
    <div style="padding:20px 24px; display:grid; grid-template-columns:repeat(4,1fr); gap:0; position:relative;">
        @foreach($funnel as $i => $stage)
        @php $isLast = $i === count($funnel) - 1; @endphp
        <div style="text-align:center; position:relative; {{ !$isLast ? 'padding-right:20px;' : '' }}">
            {{-- Bar --}}
            <div style="height:80px; background:#f8fafc; border-radius:8px; margin:0 8px 12px; position:relative; overflow:hidden; border:1px solid #e2e8f0;">
                <div style="position:absolute; bottom:0; left:0; right:0; background:{{ $stage['color'] }}22; border-radius:7px 7px 0 0;"></div>
                <div style="position:absolute; bottom:0; left:0; right:0; height:{{ max(4, $stage['pct']) }}%; background:{{ $stage['color'] }}; border-radius:4px 4px 0 0; transition:height .4s;"></div>
                <div style="position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center;">
                    <span style="font-size:20px; font-weight:800; color:{{ $stage['color'] }}; line-height:1;">{{ number_format($stage['count']) }}</span>
                    <span style="font-size:10px; color:#64748b; font-weight:600; margin-top:2px;">{{ $stage['pct'] }}%</span>
                </div>
            </div>
            <p style="font-size:11px; font-weight:700; color:#0f172a; margin:0 0 2px;">{{ $stage['label'] }}</p>
            {{-- Drop rate arrow --}}
            @if(!$isLast)
            @php $next = $funnel[$i + 1]; $drop = $stage['count'] > 0 ? round(($stage['count'] - $next['count']) / $stage['count'] * 100) : 0; @endphp
            <div style="position:absolute; right:-2px; top:28px; display:flex; flex-direction:column; align-items:center; z-index:1;">
                <span style="font-size:9px; color:#94a3b8; font-weight:600; white-space:nowrap;">{{ $drop }}% drop</span>
                <span style="font-size:16px; color:#e2e8f0; line-height:1;">›</span>
            </div>
            @endif
        </div>
        @endforeach
    </div>
</div>

{{-- ── Growth Metrics chart ─────────────────────────────────────────────────── --}}
<div style="display:grid; grid-template-columns:3fr 2fr; gap:12px;">
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; overflow:hidden;">
        <div style="padding:12px 18px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between;">
            <div>
                <p style="font-size:13px; font-weight:700; color:#0f172a; margin:0; line-height:1;">Growth Overview</p>
                <p style="font-size:10px; color:#94a3b8; margin:2px 0 0;">Users, businesses, bookings & inquiries — 6 months</p>
            </div>
            <div style="display:flex; gap:10px; font-size:10px;">
                <span style="display:flex;align-items:center;gap:3px;color:#64748b;"><span style="width:10px;height:3px;background:#3b82f6;border-radius:2px;display:inline-block;"></span> Users</span>
                <span style="display:flex;align-items:center;gap:3px;color:#64748b;"><span style="width:10px;height:3px;background:#10b981;border-radius:2px;display:inline-block;"></span> Bookings</span>
                <span style="display:flex;align-items:center;gap:3px;color:#64748b;"><span style="width:10px;height:3px;background:#f59e0b;border-radius:2px;display:inline-block;"></span> Inquiries</span>
                <span style="display:flex;align-items:center;gap:3px;color:#64748b;"><span style="width:10px;height:3px;background:#8b5cf6;border-radius:2px;display:inline-block;"></span> Businesses</span>
            </div>
        </div>
        <div style="padding:14px 18px; height:180px;">
            <canvas id="int-growth-chart" style="width:100%;height:100%;"></canvas>
        </div>
    </div>

    {{-- Inquiry & Message stats --}}
    <div style="display:flex; flex-direction:column; gap:12px;">
        <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; padding:16px 18px; flex:1;">
            <p style="font-size:12px; font-weight:700; color:#0f172a; margin:0 0 12px;">Package Inquiries</p>
            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:8px;">
                @foreach([['Total',$inquiryStats['total'],'#3b82f6'],['New',$inquiryStats['new'],'#f59e0b'],['This Period',$inquiryStats['period'],'#10b981']] as [$l,$v,$c])
                <div style="background:#f8fafc; border-radius:8px; padding:10px; text-align:center;">
                    <p style="font-size:18px; font-weight:800; color:{{ $c }}; margin:0; line-height:1;">{{ number_format($v) }}</p>
                    <p style="font-size:10px; color:#64748b; margin:3px 0 0;">{{ $l }}</p>
                </div>
                @endforeach
            </div>
        </div>
        <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; padding:16px 18px; flex:1;">
            <p style="font-size:12px; font-weight:700; color:#0f172a; margin:0 0 12px;">Contact Messages</p>
            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:8px;">
                @foreach([['Total',$messageStats['total'],'#3b82f6'],['New',$messageStats['new'],'#ef4444'],['This Period',$messageStats['period'],'#8b5cf6']] as [$l,$v,$c])
                <div style="background:#f8fafc; border-radius:8px; padding:10px; text-align:center;">
                    <p style="font-size:18px; font-weight:800; color:{{ $c }}; margin:0; line-height:1;">{{ number_format($v) }}</p>
                    <p style="font-size:10px; color:#64748b; margin:3px 0 0;">{{ $l }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- ── Business Profile Views + Click Sources ───────────────────────────────── --}}
<div style="display:grid; grid-template-columns:2fr 1fr; gap:12px;">
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; overflow:hidden;">
        <div style="padding:12px 18px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between;">
            <div>
                <p style="font-size:13px; font-weight:700; color:#0f172a; margin:0; line-height:1;">Business Profile Activity</p>
                <p style="font-size:10px; color:#94a3b8; margin:2px 0 0;">Profile views vs click-throughs — last {{ min($days,30) }} days</p>
            </div>
            <div style="display:flex; align-items:center; gap:8px;">
                <span style="font-size:12px; font-weight:700; color:#3b82f6;">{{ number_format($totalBizViews) }}</span>
                <span style="font-size:11px; color:#94a3b8;">views</span>
                @if($bizViewGrowth !== 0)
                <span style="font-size:11px; color:{{ $bizViewGrowth > 0 ? '#16a34a' : '#dc2626' }}; font-weight:600;">{{ $bizViewGrowth > 0 ? '▲' : '▼' }}{{ abs($bizViewGrowth) }}%</span>
                @endif
            </div>
        </div>
        <div style="padding:14px 18px; height:160px;">
            <canvas id="int-biz-chart" style="width:100%;height:100%;"></canvas>
        </div>
    </div>

    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; overflow:hidden;">
        <div style="padding:12px 18px; border-bottom:1px solid #f1f5f9;">
            <p style="font-size:13px; font-weight:700; color:#0f172a; margin:0;">Click Sources</p>
            <p style="font-size:10px; color:#94a3b8; margin:2px 0 0;">How visitors find businesses</p>
        </div>
        <div style="padding:14px 18px; display:flex; flex-direction:column; gap:8px;">
            @php $clickTotal = max(1, array_sum($clickSources)); $ci = 0; @endphp
            @forelse($clickSources as $src => $cnt)
            <div>
                <div style="display:flex; justify-content:space-between; font-size:11px; margin-bottom:3px;">
                    <span style="font-weight:500; color:#374151; text-transform:capitalize;">{{ $src ?: 'Direct' }}</span>
                    <span style="font-weight:700; color:#0f172a;">{{ number_format($cnt) }} <span style="color:#94a3b8; font-weight:400;">({{ round($cnt/$clickTotal*100) }}%)</span></span>
                </div>
                <div style="height:5px; background:#f1f5f9; border-radius:3px; overflow:hidden;">
                    <div style="height:5px; width:{{ round($cnt/$clickTotal*100) }}%; background:{{ $srcColorMap[$ci % 7] }}; border-radius:3px;"></div>
                </div>
            </div>
            @php $ci++; @endphp
            @empty
            <p style="font-size:12px; color:#94a3b8; text-align:center; padding:16px 0; margin:0;">No click data yet</p>
            @endforelse
        </div>
        @if(!empty($topBizByViews) && $topBizByViews->isNotEmpty())
        <div style="border-top:1px solid #f1f5f9; padding:12px 18px;">
            <p style="font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.05em; margin:0 0 8px;">Top Businesses by Views</p>
            @foreach($topBizByViews as $biz)
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:5px;">
                <span style="font-size:11px; color:#374151; font-weight:500; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $biz->name }}</span>
                <span style="font-size:11px; font-weight:700; color:#0f172a; flex-shrink:0; margin-left:8px;">{{ $biz->view_count }}</span>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

{{-- ── Feed Engagement + Top Blog Posts ────────────────────────────────────── --}}
<div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">

    {{-- Feed Engagement --}}
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; overflow:hidden;">
        <div style="padding:12px 18px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between;">
            <div>
                <p style="font-size:13px; font-weight:700; color:#0f172a; margin:0; line-height:1;">Social Feed Engagement</p>
                <p style="font-size:10px; color:#94a3b8; margin:2px 0 0;">Activity across all feed posts</p>
            </div>
        </div>
        {{-- Totals row --}}
        <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:0; border-bottom:1px solid #f1f5f9;">
            @foreach([['👁 Views',$totalFeedViews,'#3b82f6'],['❤️ Likes',$totalFeedLikes,'#ef4444'],['💬 Comments',$totalFeedComments,'#10b981'],['🔗 Shares',$totalFeedShares,'#8b5cf6']] as [$label,$val,$color])
            <div style="padding:12px; text-align:center; {{ !$loop->last ? 'border-right:1px solid #f1f5f9;' : '' }}">
                <p style="font-size:18px; font-weight:800; color:{{ $color }}; margin:0; line-height:1;">{{ number_format($val) }}</p>
                <p style="font-size:10px; color:#94a3b8; margin:3px 0 0;">{{ $label }}</p>
            </div>
            @endforeach
        </div>
        {{-- Feed trend chart --}}
        <div style="padding:14px 18px; height:140px;">
            <canvas id="int-feed-chart" style="width:100%;height:100%;"></canvas>
        </div>
        {{-- Top feed posts --}}
        <div style="border-top:1px solid #f1f5f9;">
            @foreach($topFeedPosts as $i => $fp)
            <div style="padding:9px 18px; border-bottom:1px solid #f8fafc; display:flex; align-items:center; gap:10px;">
                <span style="font-size:11px; font-weight:700; color:#94a3b8; flex-shrink:0; width:14px; text-align:center;">{{ $i+1 }}</span>
                <div style="flex:1; min-width:0;">
                    <p style="font-size:11px; font-weight:600; color:#0f172a; margin:0; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $fp->title ?: Str::limit(strip_tags($fp->content), 40) }}</p>
                </div>
                <div style="display:flex; align-items:center; gap:8px; flex-shrink:0; font-size:10px; color:#64748b;">
                    <span title="Views">👁 {{ number_format($fp->views_count) }}</span>
                    <span title="Likes">❤️ {{ $fp->likes_count }}</span>
                    <span title="Comments">💬 {{ $fp->comments_count }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Blog / Content Performance --}}
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; overflow:hidden;">
        <div style="padding:12px 18px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between;">
            <div>
                <p style="font-size:13px; font-weight:700; color:#0f172a; margin:0; line-height:1;">Blog Performance</p>
                <p style="font-size:10px; color:#94a3b8; margin:2px 0 0;">All-time views across published posts</p>
            </div>
            <div style="text-align:right;">
                <span style="font-size:20px; font-weight:800; color:#f59e0b;">{{ number_format($totalBlogViews) }}</span>
                <p style="font-size:10px; color:#94a3b8; margin:0;">total views</p>
            </div>
        </div>
        <table style="width:100%; border-collapse:collapse; font-size:11px;">
            <thead>
                <tr style="background:#f8fafc;">
                    <th style="padding:8px 18px; text-align:left; color:#94a3b8; font-size:10px; font-weight:600; text-transform:uppercase; border-bottom:1px solid #f1f5f9;">#</th>
                    <th style="padding:8px 6px; text-align:left; color:#94a3b8; font-size:10px; font-weight:600; text-transform:uppercase; border-bottom:1px solid #f1f5f9;">Post</th>
                    <th style="padding:8px 6px; text-align:center; color:#94a3b8; font-size:10px; font-weight:600; text-transform:uppercase; border-bottom:1px solid #f1f5f9;">Views</th>
                    <th style="padding:8px 18px; text-align:right; color:#94a3b8; font-size:10px; font-weight:600; text-transform:uppercase; border-bottom:1px solid #f1f5f9;">Read</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topBlogPosts as $i => $post)
                <tr style="{{ $i % 2 ? 'background:#fafafa;' : '' }}">
                    <td style="padding:9px 18px; border-bottom:1px solid #f8fafc;">
                        <span style="width:20px; height:20px; border-radius:50%; background:{{ $i===0?'#fef3c7':($i===1?'#f1f5f9':($i===2?'#fce7f3':'#f8fafc')) }}; color:{{ $i===0?'#b45309':($i===1?'#64748b':($i===2?'#be185d':'#94a3b8')) }}; font-size:10px; font-weight:700; display:inline-flex; align-items:center; justify-content:center;">{{ $i+1 }}</span>
                    </td>
                    <td style="padding:9px 6px; border-bottom:1px solid #f8fafc; max-width:200px;">
                        <p style="font-size:11px; font-weight:600; color:#0f172a; margin:0; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $post->title }}</p>
                        <p style="font-size:10px; color:#94a3b8; margin:1px 0 0;">{{ $post->published_at?->format('d M Y') }}</p>
                    </td>
                    <td style="padding:9px 6px; border-bottom:1px solid #f8fafc; text-align:center; font-weight:700; color:#0f172a;">{{ number_format($post->views) }}</td>
                    <td style="padding:9px 18px; border-bottom:1px solid #f8fafc; text-align:right; color:#64748b;">{{ $post->read_time ? $post->read_time.' min' : '—' }}</td>
                </tr>
                @endforeach
                @if($topBlogPosts->isEmpty())
                <tr><td colspan="4" style="padding:24px; text-align:center; color:#94a3b8; font-size:12px;">No blog posts yet</td></tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

</div>

<script>
(function () {
    function initAnalyticsCharts() {
        if (!window.Chart) return;

        Chart.defaults.font.family = 'inherit';
        Chart.defaults.font.size   = 11;

        const ids = ['ga-trend-chart','ga-source-donut','int-growth-chart','int-biz-chart','int-feed-chart'];
        ids.forEach(id => {
            const el = document.getElementById(id);
            if (el) { const c = Chart.getChart(el); if (c) c.destroy(); }
        });

        @if($gaConnected)
        // GA Sessions trend
        const gaTrendEl = document.getElementById('ga-trend-chart');
        if (gaTrendEl) {
            new Chart(gaTrendEl.getContext('2d'), {
                type: 'line',
                data: {
                    labels: {!! $gaTrendLabels !!},
                    datasets: [
                        { label:'Sessions', data:{!! $gaTrendSessions !!}, borderColor:'#3b82f6', backgroundColor:'rgba(59,130,246,0.07)', borderWidth:2.5, fill:true, tension:0.4, pointRadius:2, yAxisID:'y1' },
                        { label:'Users',    data:{!! $gaTrendUsers !!},    borderColor:'#10b981', backgroundColor:'transparent', borderWidth:2, fill:false, tension:0.4, pointRadius:2, yAxisID:'y1' },
                        { label:'Pageviews',data:{!! $gaTrendViews !!},    borderColor:'#f59e0b', backgroundColor:'transparent', borderWidth:1.5, borderDash:[5,3], fill:false, tension:0.4, pointRadius:0, yAxisID:'y1' },
                    ],
                },
                options: { responsive:true, maintainAspectRatio:false, interaction:{mode:'index',intersect:false},
                    plugins:{ legend:{display:false}, tooltip:{backgroundColor:'#1e293b',titleColor:'#f8fafc',bodyColor:'#94a3b8',padding:9} },
                    scales:{ x:{grid:{color:'#f1f5f9'},ticks:{color:'#94a3b8',maxTicksLimit:10}}, y1:{grid:{color:'#f1f5f9'},ticks:{color:'#94a3b8'}} } },
            });
        }

        // GA Traffic sources donut
        const gaSrcEl = document.getElementById('ga-source-donut');
        if (gaSrcEl) {
            new Chart(gaSrcEl.getContext('2d'), {
                type:'doughnut',
                data:{ labels:{!! $srcLabels !!}, datasets:[{ data:{!! $srcValues !!}, backgroundColor:{!! $srcColors !!}, borderWidth:2, borderColor:'#fff', hoverOffset:3 }] },
                options:{ responsive:true, maintainAspectRatio:false, cutout:'68%', plugins:{ legend:{display:false}, tooltip:{backgroundColor:'#1e293b',titleColor:'#f8fafc',bodyColor:'#94a3b8',padding:8} } },
            });
        }
        @endif

        // Internal: Growth chart
        const growthEl = document.getElementById('int-growth-chart');
        if (growthEl) {
            new Chart(growthEl.getContext('2d'), {
                type:'line',
                data:{
                    labels:{!! $growthLabels !!},
                    datasets:[
                        { label:'Users',     data:{!! $growthUsers !!},     borderColor:'#3b82f6', backgroundColor:'rgba(59,130,246,0.06)',fill:true,  tension:0.4, borderWidth:2.5, pointRadius:3, pointBackgroundColor:'#3b82f6' },
                        { label:'Bookings',  data:{!! $growthBookings !!},  borderColor:'#10b981', backgroundColor:'transparent', fill:false, tension:0.4, borderWidth:2,   pointRadius:3, pointBackgroundColor:'#10b981' },
                        { label:'Inquiries', data:{!! $growthInquiries !!}, borderColor:'#f59e0b', backgroundColor:'transparent', fill:false, tension:0.4, borderWidth:2,   pointRadius:3, pointBackgroundColor:'#f59e0b' },
                        { label:'Businesses',data:{!! $growthBiz !!},       borderColor:'#8b5cf6', backgroundColor:'transparent', fill:false, tension:0.4, borderWidth:1.5, borderDash:[4,3], pointRadius:2 },
                    ],
                },
                options:{ responsive:true, maintainAspectRatio:false, interaction:{mode:'index',intersect:false},
                    plugins:{ legend:{display:false}, tooltip:{backgroundColor:'#1e293b',titleColor:'#f8fafc',bodyColor:'#94a3b8',padding:9} },
                    scales:{ x:{grid:{color:'#f1f5f9'},ticks:{color:'#94a3b8'}}, y:{grid:{color:'#f1f5f9'},ticks:{color:'#94a3b8'},beginAtZero:true} } },
            });
        }

        // Internal: Biz profile views
        const bizEl = document.getElementById('int-biz-chart');
        if (bizEl) {
            new Chart(bizEl.getContext('2d'), {
                type:'line',
                data:{
                    labels:{!! $bizLabels !!},
                    datasets:[
                        { label:'Profile Views', data:{!! $bizViews !!},  borderColor:'#3b82f6', backgroundColor:'rgba(59,130,246,0.08)', fill:true,  tension:0.4, borderWidth:2, pointRadius:2 },
                        { label:'Clicks',        data:{!! $bizClicks !!}, borderColor:'#10b981', backgroundColor:'transparent',            fill:false, tension:0.4, borderWidth:1.5, borderDash:[5,3], pointRadius:0 },
                    ],
                },
                options:{ responsive:true, maintainAspectRatio:false, interaction:{mode:'index',intersect:false},
                    plugins:{ legend:{display:false}, tooltip:{backgroundColor:'#1e293b',titleColor:'#f8fafc',bodyColor:'#94a3b8',padding:8} },
                    scales:{ x:{grid:{display:false},ticks:{color:'#94a3b8',maxTicksLimit:8}}, y:{grid:{color:'#f1f5f9'},ticks:{color:'#94a3b8'},beginAtZero:true} } },
            });
        }

        // Internal: Feed engagement
        const feedEl = document.getElementById('int-feed-chart');
        if (feedEl) {
            new Chart(feedEl.getContext('2d'), {
                type:'bar',
                data:{
                    labels:{!! $feedLabels !!},
                    datasets:[
                        { label:'Views',  data:{!! $feedViews !!},  backgroundColor:'rgba(59,130,246,0.7)', borderRadius:2, stack:'a' },
                        { label:'Likes',  data:{!! $feedLikes !!},  backgroundColor:'rgba(239,68,68,0.6)',  borderRadius:2, stack:'a' },
                        { label:'Shares', data:{!! $feedShares !!}, backgroundColor:'rgba(139,92,246,0.6)', borderRadius:2, stack:'a' },
                    ],
                },
                options:{ responsive:true, maintainAspectRatio:false,
                    plugins:{ legend:{display:false}, tooltip:{backgroundColor:'#1e293b',titleColor:'#f8fafc',bodyColor:'#94a3b8',padding:8} },
                    scales:{ x:{grid:{display:false},ticks:{color:'#94a3b8',maxTicksLimit:8}}, y:{grid:{color:'#f1f5f9'},ticks:{color:'#94a3b8'},beginAtZero:true,stacked:true} } },
            });
        }
    }

    if (window.Chart) { initAnalyticsCharts(); }
    else {
        const iv = setInterval(() => { if (window.Chart) { clearInterval(iv); initAnalyticsCharts(); } }, 100);
    }
    document.addEventListener('livewire:navigated', initAnalyticsCharts);
})();
</script>
