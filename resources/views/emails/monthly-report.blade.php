<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Monthly Performance Report</title>
    <style>
        body { margin:0; padding:0; background:#f5f5f5; font-family: 'Segoe UI', Arial, sans-serif; color:#333; }
        .wrapper { max-width:640px; margin:30px auto; background:#fff; border-radius:8px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,.08); }
        .header { background:#1a3c34; padding:32px 40px; text-align:center; }
        .header h1 { color:#c8a96e; margin:0; font-size:22px; font-weight:700; letter-spacing:.5px; }
        .header p { color:#a8c4bc; margin:6px 0 0; font-size:14px; }
        .section { padding:28px 40px; border-bottom:1px solid #f0f0f0; }
        .section:last-child { border-bottom:none; }
        .section-title { font-size:13px; font-weight:700; text-transform:uppercase; color:#c8a96e; letter-spacing:1px; margin:0 0 16px; }
        .stat-grid { display:flex; gap:12px; flex-wrap:wrap; }
        .stat-box { flex:1; min-width:120px; background:#f8f9fa; border-radius:6px; padding:14px; text-align:center; }
        .stat-box .val { font-size:26px; font-weight:700; color:#1a3c34; }
        .stat-box .lbl { font-size:11px; color:#888; margin-top:4px; }
        .stat-box .chg { font-size:12px; margin-top:4px; font-weight:600; }
        .chg-up { color:#198754; }
        .chg-down { color:#dc3545; }
        .chg-same { color:#6c757d; }
        table { width:100%; border-collapse:collapse; font-size:13px; }
        th { background:#f8f9fa; text-align:left; padding:8px 10px; font-weight:600; color:#555; border-bottom:2px solid #eee; }
        td { padding:8px 10px; border-bottom:1px solid #f5f5f5; color:#444; }
        tr:last-child td { border-bottom:none; }
        .ranking-box { background:#1a3c34; border-radius:8px; padding:20px; color:#fff; display:flex; gap:20px; align-items:center; flex-wrap:wrap; }
        .ranking-pos { font-size:42px; font-weight:800; color:#c8a96e; line-height:1; }
        .ranking-info .label { font-size:12px; color:#a8c4bc; text-transform:uppercase; letter-spacing:.5px; }
        .ranking-info .change { font-size:15px; font-weight:600; margin-top:4px; }
        .tip-box { background:#fffbf0; border-left:4px solid #c8a96e; padding:14px 16px; border-radius:0 6px 6px 0; font-size:13px; color:#555; margin-top:16px; }
        .footer { background:#f8f9fa; padding:20px 40px; text-align:center; font-size:12px; color:#aaa; }
        .footer a { color:#c8a96e; text-decoration:none; }
        .badge { display:inline-block; font-size:11px; font-weight:600; padding:2px 8px; border-radius:20px; }
        .badge-up   { background:#d1e7dd; color:#198754; }
        .badge-down { background:#f8d7da; color:#dc3545; }
        .badge-same { background:#e2e3e5; color:#6c757d; }
    </style>
</head>
<body>
<div class="wrapper">

    {{-- Header --}}
    <div class="header">
        <h1>Monthly Performance Report</h1>
        <p>{{ $report->business?->name }} &bull; {{ $report->period_label }}</p>
    </div>

    @php
        $data = $report->report_data;
        $viewsChange = $data['profile_views_change'] ?? 0;
        $totalInquiries = collect($data['packages'] ?? [])->sum('inquiries');
        $totalEngagement = collect($data['business_posts'] ?? [])->sum('engagement')
            + collect($data['feed_posts'] ?? [])->sum(fn($p) => ($p['likes'] ?? 0) + ($p['comments'] ?? 0) + ($p['shares'] ?? 0));
    @endphp

    {{-- Overview Stats --}}
    <div class="section">
        <div class="section-title">Overview</div>
        <div class="stat-grid">
            <div class="stat-box">
                <div class="val">{{ number_format($data['profile_views'] ?? 0) }}</div>
                <div class="lbl">Profile Views</div>
                <div class="chg {{ $viewsChange >= 0 ? 'chg-up' : 'chg-down' }}">
                    {{ $viewsChange >= 0 ? '▲' : '▼' }} {{ abs($viewsChange) }} vs last month
                </div>
            </div>
            <div class="stat-box">
                <div class="val">{{ number_format($data['followers_gained'] ?? 0) }}</div>
                <div class="lbl">New Followers</div>
                <div class="chg chg-same">{{ number_format($data['followers_total'] ?? 0) }} total</div>
            </div>
            <div class="stat-box">
                <div class="val">{{ number_format($totalInquiries) }}</div>
                <div class="lbl">Package Inquiries</div>
            </div>
            <div class="stat-box">
                <div class="val">{{ number_format($totalEngagement) }}</div>
                <div class="lbl">Total Engagement</div>
            </div>
        </div>
    </div>

    {{-- Ranking --}}
    @if($report->ranking_position)
    <div class="section">
        <div class="section-title">Business Ranking</div>
        <div class="ranking-box">
            <div>
                <div style="font-size:11px;color:#a8c4bc;text-transform:uppercase;letter-spacing:.5px;">Position</div>
                <div class="ranking-pos">#{{ $report->ranking_position }}</div>
            </div>
            <div class="ranking-info" style="flex:1;">
                <div class="label">Change from last month</div>
                <div class="change">
                    @if($report->ranking_change === null)
                        <span class="badge badge-same">No previous data</span>
                    @elseif($report->ranking_change > 0)
                        <span class="badge badge-up">▲ Up {{ $report->ranking_change }} position{{ $report->ranking_change > 1 ? 's' : '' }}</span>
                    @elseif($report->ranking_change < 0)
                        <span class="badge badge-down">▼ Down {{ abs($report->ranking_change) }} position{{ abs($report->ranking_change) > 1 ? 's' : '' }}</span>
                    @else
                        <span class="badge badge-same">No change</span>
                    @endif
                </div>
                @if($report->ranking_tip)
                <div class="tip-box" style="background:rgba(255,255,255,.1);border-left-color:#c8a96e;color:#d4edda;margin-top:10px;">
                    💡 {{ $report->ranking_tip }}
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    {{-- Packages --}}
    @if(!empty($data['packages']))
    <div class="section">
        <div class="section-title">Packages</div>
        <table>
            <thead>
                <tr>
                    <th>Package</th>
                    <th style="text-align:right;">Inquiries</th>
                    <th style="text-align:right;">vs Last Month</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['packages'] as $pkg)
                <tr>
                    <td>{{ $pkg['name'] }}</td>
                    <td style="text-align:right;font-weight:600;">{{ $pkg['inquiries'] }}</td>
                    <td style="text-align:right;">
                        @php $chg = $pkg['inquiries_change'] ?? 0; @endphp
                        <span class="{{ $chg > 0 ? 'chg-up' : ($chg < 0 ? 'chg-down' : 'chg-same') }}">
                            {{ $chg >= 0 ? '+' : '' }}{{ $chg }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    {{-- Business Posts --}}
    @if(!empty($data['business_posts']))
    <div class="section">
        <div class="section-title">Business Post Performance</div>
        <table>
            <thead>
                <tr>
                    <th>Post</th>
                    <th style="text-align:right;">Views</th>
                    <th style="text-align:right;">Likes</th>
                    <th style="text-align:right;">Comments</th>
                </tr>
            </thead>
            <tbody>
                @foreach(array_slice($data['business_posts'], 0, 5) as $post)
                <tr>
                    <td>{{ $post['title'] }}</td>
                    <td style="text-align:right;">{{ number_format($post['views'] ?? 0) }}</td>
                    <td style="text-align:right;">{{ $post['likes'] ?? 0 }}</td>
                    <td style="text-align:right;">{{ $post['comments'] ?? 0 }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    {{-- Feed / Social Posts --}}
    @if(!empty($data['feed_posts']))
    <div class="section">
        <div class="section-title">Social Feed Posts</div>
        <table>
            <thead>
                <tr>
                    <th>Post</th>
                    <th style="text-align:right;">Views</th>
                    <th style="text-align:right;">Likes</th>
                    <th style="text-align:right;">Shares</th>
                    <th style="text-align:right;">CTR</th>
                </tr>
            </thead>
            <tbody>
                @foreach(array_slice($data['feed_posts'], 0, 5) as $post)
                <tr>
                    <td>{{ $post['title'] }}</td>
                    <td style="text-align:right;">{{ number_format($post['views'] ?? 0) }}</td>
                    <td style="text-align:right;">{{ $post['likes'] ?? 0 }}</td>
                    <td style="text-align:right;">{{ $post['shares'] ?? 0 }}</td>
                    <td style="text-align:right;">{{ $post['ctr'] ?? 0 }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    {{-- Footer --}}
    <div class="footer">
        <p>You're receiving this because you manage a business listing on <a href="{{ config('app.url') }}">{{ config('app.name') }}</a>.</p>
        <p>This report was automatically generated for {{ $report->period_label }}.</p>
    </div>

</div>
</body>
</html>
