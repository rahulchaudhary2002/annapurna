@pushOnce('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@endPushOnce

@php
    $monthLabels    = json_encode($months->pluck('label'));
    $revenueData    = json_encode($months->pluck('revenue'));
    $bookingsData   = json_encode($months->pluck('bookings'));
    $usersData      = json_encode($months->pluck('users'));

    $statusLabels   = json_encode(['Pending', 'Confirmed', 'Completed', 'Cancelled']);
    $statusValues   = json_encode(array_values($statusCounts));
    $statusColors   = json_encode(['#f59e0b', '#10b981', '#3b82f6', '#ef4444']);

    $dailyLabels    = json_encode($dailyBookings->pluck('label'));
    $dailyCounts    = json_encode($dailyBookings->pluck('count'));

    $bizLabels      = json_encode(array_keys($businessTypes));
    $bizValues      = json_encode(array_values($businessTypes));
    $bizColors      = json_encode(['#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6','#06b6d4','#ec4899']);

    $inqLabels      = json_encode($inquiryMonths->pluck('label'));
    $inqCounts      = json_encode($inquiryMonths->pluck('count'));
@endphp

<div style="display:flex; flex-direction:column; gap:0; font-family:inherit;">

    {{-- ── Section 1: Revenue + Bookings Trend (full-width line chart) ──────── --}}
    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden; margin-bottom:16px;">
        <div style="padding:14px 20px; background:#f8fafc; border-bottom:1px solid #e2e8f0; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg style="width:15px;height:15px;color:#64748b;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                <span style="font-size:13px; font-weight:700; color:#1e293b;">Revenue & Bookings — 12 Month Trend</span>
            </div>
            <div style="display:flex; gap:16px; font-size:11px; color:#64748b;">
                <span style="display:flex; align-items:center; gap:4px;"><span style="width:10px; height:3px; background:#3b82f6; border-radius:2px; display:inline-block;"></span> Revenue</span>
                <span style="display:flex; align-items:center; gap:4px;"><span style="width:10px; height:3px; background:#10b981; border-radius:2px; display:inline-block;"></span> Bookings</span>
                <span style="display:flex; align-items:center; gap:4px;"><span style="width:10px; height:3px; background:#f59e0b; border-radius:2px; display:inline-block;"></span> New Users</span>
            </div>
        </div>
        <div style="padding:20px; height:220px;">
            <canvas id="dash-revenue-chart" style="width:100%; height:100%;"></canvas>
        </div>
    </div>

    {{-- ── Section 2: Three charts row ─────────────────────────────────────── --}}
    <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px; margin-bottom:16px;">

        {{-- Booking Status Donut --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden;">
            <div style="padding:12px 16px; background:#f8fafc; border-bottom:1px solid #e2e8f0;">
                <span style="font-size:12px; font-weight:700; color:#1e293b;">Booking Status Distribution</span>
            </div>
            <div style="padding:16px; display:flex; flex-direction:column; align-items:center;">
                <div style="height:160px; width:160px; position:relative;">
                    <canvas id="dash-status-donut"></canvas>
                    <div style="position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; pointer-events:none;">
                        <span style="font-size:22px; font-weight:800; color:#0f172a; line-height:1;">{{ $total }}</span>
                        <span style="font-size:10px; color:#94a3b8; font-weight:500;">total</span>
                    </div>
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:6px; width:100%; margin-top:12px;">
                    @foreach(['pending'=>['Pending','#f59e0b','#fffbeb'],'confirmed'=>['Confirmed','#10b981','#f0fdf4'],'completed'=>['Completed','#3b82f6','#eff6ff'],'cancelled'=>['Cancelled','#ef4444','#fef2f2']] as $key => [$label,$color,$bg])
                    <div style="background:{{ $bg }}; border-radius:6px; padding:6px 8px; display:flex; align-items:center; gap:6px;">
                        <span style="width:8px; height:8px; border-radius:50%; background:{{ $color }}; flex-shrink:0;"></span>
                        <div>
                            <p style="font-size:13px; font-weight:700; color:#0f172a; margin:0; line-height:1;">{{ $statusCounts[$key] }}</p>
                            <p style="font-size:10px; color:#64748b; margin:1px 0 0;">{{ $label }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Hotel vs Package + Confirmed Rate --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden;">
            <div style="padding:12px 16px; background:#f8fafc; border-bottom:1px solid #e2e8f0;">
                <span style="font-size:12px; font-weight:700; color:#1e293b;">Booking Type & Performance</span>
            </div>
            <div style="padding:16px;">
                {{-- Hotel vs Package bar --}}
                <div style="margin-bottom:14px;">
                    <p style="font-size:10px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.05em; margin:0 0 8px;">Type Split</p>
                    @php $typeTotal = max(1, $hotelBookings + $packageBookings); @endphp
                    <div style="margin-bottom:8px;">
                        <div style="display:flex; justify-content:space-between; font-size:11px; margin-bottom:3px;">
                            <span style="font-weight:600; color:#1d4ed8;">🏨 Hotels</span>
                            <span style="color:#0f172a; font-weight:700;">{{ $hotelBookings }} <span style="color:#94a3b8; font-weight:400;">({{ round($hotelBookings/$typeTotal*100) }}%)</span></span>
                        </div>
                        <div style="height:6px; background:#dbeafe; border-radius:3px; overflow:hidden;">
                            <div style="height:100%; width:{{ round($hotelBookings/$typeTotal*100) }}%; background:#3b82f6; border-radius:3px;"></div>
                        </div>
                    </div>
                    <div>
                        <div style="display:flex; justify-content:space-between; font-size:11px; margin-bottom:3px;">
                            <span style="font-weight:600; color:#047857;">🎒 Packages</span>
                            <span style="color:#0f172a; font-weight:700;">{{ $packageBookings }} <span style="color:#94a3b8; font-weight:400;">({{ round($packageBookings/$typeTotal*100) }}%)</span></span>
                        </div>
                        <div style="height:6px; background:#d1fae5; border-radius:3px; overflow:hidden;">
                            <div style="height:100%; width:{{ round($packageBookings/$typeTotal*100) }}%; background:#10b981; border-radius:3px;"></div>
                        </div>
                    </div>
                </div>

                {{-- KPI pills --}}
                <div style="border-top:1px solid #f1f5f9; padding-top:12px;">
                    <p style="font-size:10px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.05em; margin:0 0 8px;">Key Metrics</p>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:6px;">
                        <div style="background:#f8fafc; border-radius:8px; padding:8px 10px; text-align:center;">
                            <p style="font-size:18px; font-weight:800; color:#0f172a; margin:0; line-height:1;">{{ $confirmedRate }}%</p>
                            <p style="font-size:10px; color:#64748b; margin:2px 0 0;">Confirm Rate</p>
                        </div>
                        <div style="background:#f8fafc; border-radius:8px; padding:8px 10px; text-align:center;">
                            <p style="font-size:18px; font-weight:800; color:#0f172a; margin:0; line-height:1;">Rs.{{ number_format($avgValue/1000,0) }}k</p>
                            <p style="font-size:10px; color:#64748b; margin:2px 0 0;">Avg Value</p>
                        </div>
                        <div style="background:#eff6ff; border-radius:8px; padding:8px 10px; text-align:center;">
                            <p style="font-size:18px; font-weight:800; color:#1d4ed8; margin:0; line-height:1;">{{ $total }}</p>
                            <p style="font-size:10px; color:#64748b; margin:2px 0 0;">Total Bookings</p>
                        </div>
                        <div style="background:#f0fdf4; border-radius:8px; padding:8px 10px; text-align:center;">
                            <p style="font-size:18px; font-weight:800; color:#059669; margin:0; line-height:1;">{{ $statusCounts['confirmed'] + $statusCounts['completed'] }}</p>
                            <p style="font-size:10px; color:#64748b; margin:2px 0 0;">Successful</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Business Type Distribution (donut) --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden;">
            <div style="padding:12px 16px; background:#f8fafc; border-bottom:1px solid #e2e8f0;">
                <span style="font-size:12px; font-weight:700; color:#1e293b;">Business Type Distribution</span>
            </div>
            <div style="padding:16px; display:flex; flex-direction:column; align-items:center;">
                @if(!empty($businessTypes))
                <div style="height:160px; width:160px;">
                    <canvas id="dash-biz-donut"></canvas>
                </div>
                <div style="width:100%; margin-top:10px; display:flex; flex-direction:column; gap:4px;">
                    @php
                        $bizColorsMap = ['#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6','#06b6d4','#ec4899'];
                        $bizTotal = max(1, array_sum($businessTypes));
                        $i = 0;
                    @endphp
                    @foreach($businessTypes as $type => $count)
                    @php $col = $bizColorsMap[$i % count($bizColorsMap)]; $i++; @endphp
                    <div style="display:flex; align-items:center; gap:8px; justify-content:space-between;">
                        <div style="display:flex; align-items:center; gap:6px; min-width:0;">
                            <span style="width:8px; height:8px; border-radius:50%; background:{{ $col }}; flex-shrink:0;"></span>
                            <span style="font-size:11px; color:#475569; text-transform:capitalize; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ str_replace('_', ' ', $type) }}</span>
                        </div>
                        <div style="display:flex; align-items:center; gap:6px; flex-shrink:0;">
                            <span style="font-size:11px; color:#94a3b8;">{{ round($count/$bizTotal*100) }}%</span>
                            <span style="font-size:12px; font-weight:700; color:#0f172a;">{{ $count }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div style="height:160px; display:flex; align-items:center; justify-content:center; color:#cbd5e1; font-size:12px;">No business data</div>
                @endif
            </div>
        </div>
    </div>

    {{-- ── Section 3: Daily Activity + Package Inquiries + Top Packages ───── --}}
    <div style="display:grid; grid-template-columns:2fr 1fr; gap:16px; margin-bottom:16px;">

        {{-- Daily bookings bar chart --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden;">
            <div style="padding:12px 16px; background:#f8fafc; border-bottom:1px solid #e2e8f0; display:flex; align-items:center; justify-content:space-between;">
                <span style="font-size:12px; font-weight:700; color:#1e293b;">Daily Bookings — Last 30 Days</span>
                <span style="font-size:11px; color:#94a3b8; font-weight:500;">activity heatmap</span>
            </div>
            <div style="padding:16px; height:180px;">
                <canvas id="dash-daily-bar" style="width:100%; height:100%;"></canvas>
            </div>
        </div>

        {{-- Package Inquiries trend --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden;">
            <div style="padding:12px 16px; background:#f8fafc; border-bottom:1px solid #e2e8f0;">
                <span style="font-size:12px; font-weight:700; color:#1e293b;">Package Inquiries — 6 Months</span>
            </div>
            <div style="padding:16px; height:180px;">
                <canvas id="dash-inquiry-line" style="width:100%; height:100%;"></canvas>
            </div>
        </div>
    </div>

    {{-- ── Section 4: Top Packages ──────────────────────────────────────────── --}}
    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden;">
        <div style="padding:12px 16px; background:#f8fafc; border-bottom:1px solid #e2e8f0; display:flex; align-items:center; justify-content:space-between;">
            <span style="font-size:12px; font-weight:700; color:#1e293b;">Top Performing Packages</span>
            <span style="font-size:11px; color:#94a3b8;">by total bookings</span>
        </div>
        <div style="padding:0;">
            @if($topPackages->isEmpty())
            <div style="padding:24px; text-align:center; color:#94a3b8; font-size:12px;">No package data yet</div>
            @else
            <table style="width:100%; border-collapse:collapse; font-size:12px;">
                <thead>
                    <tr style="background:#f8fafc;">
                        <th style="text-align:left; padding:10px 16px; color:#64748b; font-weight:600; border-bottom:1px solid #e2e8f0; font-size:11px; text-transform:uppercase; letter-spacing:.04em;">#</th>
                        <th style="text-align:left; padding:10px 8px; color:#64748b; font-weight:600; border-bottom:1px solid #e2e8f0; font-size:11px; text-transform:uppercase; letter-spacing:.04em;">Package</th>
                        <th style="text-align:left; padding:10px 8px; color:#64748b; font-weight:600; border-bottom:1px solid #e2e8f0; font-size:11px; text-transform:uppercase; letter-spacing:.04em;">Business</th>
                        <th style="text-align:center; padding:10px 8px; color:#64748b; font-weight:600; border-bottom:1px solid #e2e8f0; font-size:11px; text-transform:uppercase; letter-spacing:.04em;">Total Bookings</th>
                        <th style="text-align:center; padding:10px 8px; color:#64748b; font-weight:600; border-bottom:1px solid #e2e8f0; font-size:11px; text-transform:uppercase; letter-spacing:.04em;">Confirmed</th>
                        <th style="text-align:center; padding:10px 8px; color:#64748b; font-weight:600; border-bottom:1px solid #e2e8f0; font-size:11px; text-transform:uppercase; letter-spacing:.04em;">Inquiries</th>
                        <th style="text-align:right; padding:10px 8px; color:#64748b; font-weight:600; border-bottom:1px solid #e2e8f0; font-size:11px; text-transform:uppercase; letter-spacing:.04em;">Listing</th>
                        <th style="text-align:right; padding:10px 16px; color:#64748b; font-weight:600; border-bottom:1px solid #e2e8f0; font-size:11px; text-transform:uppercase; letter-spacing:.04em;">Daily Rate</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topPackages as $i => $pkg)
                    <tr style="{{ $i % 2 === 0 ? '' : 'background:#f8fafc;' }}">
                        <td style="padding:10px 16px; border-bottom:1px solid #f1f5f9;">
                            <span style="width:22px; height:22px; border-radius:50%; background:{{ $i===0?'#fef3c7':($i===1?'#f1f5f9':($i===2?'#fce7f3':'#f8fafc')) }}; color:{{ $i===0?'#b45309':($i===1?'#64748b':($i===2?'#be185d':'#94a3b8')) }}; font-size:11px; font-weight:700; display:inline-flex; align-items:center; justify-content:center;">{{ $i+1 }}</span>
                        </td>
                        <td style="padding:10px 8px; border-bottom:1px solid #f1f5f9; font-weight:600; color:#1e293b; max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $pkg->name }}</td>
                        <td style="padding:10px 8px; border-bottom:1px solid #f1f5f9; color:#64748b;">{{ $pkg->business?->name ?? '—' }}</td>
                        <td style="padding:10px 8px; border-bottom:1px solid #f1f5f9; text-align:center; font-weight:700; color:#0f172a;">{{ $pkg->total_bookings }}</td>
                        <td style="padding:10px 8px; border-bottom:1px solid #f1f5f9; text-align:center;">
                            <span style="background:#f0fdf4; color:#059669; font-weight:700; padding:2px 8px; border-radius:10px; font-size:11px;">{{ $pkg->confirmed_bookings }}</span>
                        </td>
                        <td style="padding:10px 8px; border-bottom:1px solid #f1f5f9; text-align:center;">
                            <span style="background:#eff6ff; color:#1d4ed8; font-weight:700; padding:2px 8px; border-radius:10px; font-size:11px;">{{ $pkg->total_inquiries }}</span>
                        </td>
                        <td style="padding:10px 8px; border-bottom:1px solid #f1f5f9; text-align:right;">
                            @if($pkg->listing_type === 'paid')
                            <span style="background:#fef3c7; color:#b45309; font-weight:600; padding:2px 7px; border-radius:8px; font-size:10px;">Sponsored</span>
                            @else
                            <span style="background:#f1f5f9; color:#64748b; padding:2px 7px; border-radius:8px; font-size:10px;">Free</span>
                            @endif
                        </td>
                        <td style="padding:10px 16px; border-bottom:1px solid #f1f5f9; text-align:right; color:#64748b; font-size:11px;">{{ $pkg->daily_rate ? 'Rs. '.number_format($pkg->daily_rate).'/day' : '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>

</div>

<script>
(function () {
    function waitForChartJS(cb) {
        if (window.Chart) { cb(); }
        else { setTimeout(() => waitForChartJS(cb), 100); }
    }

    waitForChartJS(function () {
        Chart.defaults.font.family = 'inherit';
        Chart.defaults.font.size   = 11;

        // ── Revenue + Bookings + Users line chart ──
        var revCtx = document.getElementById('dash-revenue-chart');
        if (revCtx) {
            new Chart(revCtx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: {!! $monthLabels !!},
                    datasets: [
                        {
                            label: 'Revenue (Rs.)',
                            data: {!! $revenueData !!},
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59,130,246,0.08)',
                            borderWidth: 2.5,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 3,
                            pointBackgroundColor: '#3b82f6',
                            yAxisID: 'yRev',
                        },
                        {
                            label: 'Bookings',
                            data: {!! $bookingsData !!},
                            borderColor: '#10b981',
                            backgroundColor: 'transparent',
                            borderWidth: 2,
                            fill: false,
                            tension: 0.4,
                            pointRadius: 3,
                            pointBackgroundColor: '#10b981',
                            yAxisID: 'yCount',
                        },
                        {
                            label: 'New Users',
                            data: {!! $usersData !!},
                            borderColor: '#f59e0b',
                            backgroundColor: 'transparent',
                            borderWidth: 2,
                            borderDash: [5,3],
                            fill: false,
                            tension: 0.4,
                            pointRadius: 3,
                            pointBackgroundColor: '#f59e0b',
                            yAxisID: 'yCount',
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleColor: '#f8fafc',
                            bodyColor: '#cbd5e1',
                            padding: 10,
                            callbacks: {
                                label: function (ctx) {
                                    if (ctx.dataset.yAxisID === 'yRev') {
                                        return ' Rs. ' + ctx.parsed.y.toLocaleString();
                                    }
                                    return ' ' + ctx.parsed.y + ' ' + ctx.dataset.label.toLowerCase();
                                }
                            }
                        },
                    },
                    scales: {
                        x: { grid: { color: '#f1f5f9' }, ticks: { color: '#94a3b8' } },
                        yRev: {
                            position: 'left',
                            grid: { color: '#f1f5f9' },
                            ticks: {
                                color: '#94a3b8',
                                callback: v => 'Rs.' + (v >= 1000 ? (v/1000).toFixed(0)+'k' : v),
                            },
                        },
                        yCount: {
                            position: 'right',
                            grid: { drawOnChartArea: false },
                            ticks: { color: '#94a3b8' },
                        },
                    },
                },
            });
        }

        // ── Status donut ──
        var donutCtx = document.getElementById('dash-status-donut');
        if (donutCtx) {
            new Chart(donutCtx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: {!! $statusLabels !!},
                    datasets: [{
                        data: {!! $statusValues !!},
                        backgroundColor: {!! $statusColors !!},
                        borderWidth: 2,
                        borderColor: '#fff',
                        hoverOffset: 4,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleColor: '#f8fafc',
                            bodyColor: '#cbd5e1',
                            padding: 8,
                        },
                    },
                },
            });
        }

        // ── Business type donut ──
        var bizCtx = document.getElementById('dash-biz-donut');
        if (bizCtx) {
            new Chart(bizCtx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: {!! $bizLabels !!},
                    datasets: [{
                        data: {!! $bizValues !!},
                        backgroundColor: {!! $bizColors !!},
                        borderWidth: 2,
                        borderColor: '#fff',
                        hoverOffset: 4,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleColor: '#f8fafc',
                            bodyColor: '#cbd5e1',
                            padding: 8,
                        },
                    },
                },
            });
        }

        // ── Daily bookings bar chart ──
        var dailyCtx = document.getElementById('dash-daily-bar');
        if (dailyCtx) {
            var dailyCounts = {!! $dailyCounts !!};
            var maxCount = Math.max(...dailyCounts, 1);
            new Chart(dailyCtx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: {!! $dailyLabels !!},
                    datasets: [{
                        label: 'Bookings',
                        data: dailyCounts,
                        backgroundColor: dailyCounts.map(v =>
                            v === 0 ? '#f1f5f9' :
                            v < maxCount * 0.33 ? '#bfdbfe' :
                            v < maxCount * 0.66 ? '#60a5fa' : '#2563eb'
                        ),
                        borderRadius: 3,
                        borderSkipped: false,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleColor: '#f8fafc',
                            bodyColor: '#cbd5e1',
                            padding: 8,
                        },
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: {
                                color: '#94a3b8',
                                maxTicksLimit: 10,
                                maxRotation: 0,
                            },
                        },
                        y: {
                            grid: { color: '#f1f5f9' },
                            ticks: { color: '#94a3b8', stepSize: 1 },
                            beginAtZero: true,
                        },
                    },
                },
            });
        }

        // ── Package inquiry line chart ──
        var inqCtx = document.getElementById('dash-inquiry-line');
        if (inqCtx) {
            new Chart(inqCtx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: {!! $inqLabels !!},
                    datasets: [{
                        label: 'Inquiries',
                        data: {!! $inqCounts !!},
                        borderColor: '#8b5cf6',
                        backgroundColor: 'rgba(139,92,246,0.1)',
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#8b5cf6',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleColor: '#f8fafc',
                            bodyColor: '#cbd5e1',
                            padding: 8,
                        },
                    },
                    scales: {
                        x: { grid: { display: false }, ticks: { color: '#94a3b8' } },
                        y: {
                            grid: { color: '#f1f5f9' },
                            ticks: { color: '#94a3b8', stepSize: 1 },
                            beginAtZero: true,
                        },
                    },
                },
            });
        }
    });
})();
</script>
