@pushOnce('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@endPushOnce

@php
    $rl = json_encode($revenueMonths->pluck('label'));
    $rv = json_encode($revenueMonths->pluck('revenue'));
    $bv = json_encode($revenueMonths->pluck('bookings'));
    $uv = json_encode($revenueMonths->pluck('users'));

    $sl = json_encode(['Pending','Confirmed','Completed','Cancelled']);
    $sv = json_encode([$statusCounts['pending'],$statusCounts['confirmed'],$statusCounts['completed'],$statusCounts['cancelled']]);
    $sc = json_encode(['#f59e0b','#10b981','#3b82f6','#ef4444']);

    $bl = json_encode(array_keys($businessTypes));
    $bz = json_encode(array_values($businessTypes));
    $bc = json_encode(['#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6']);

    $il = json_encode($inquiryMonths->pluck('label'));
    $iv = json_encode($inquiryMonths->pluck('count'));

    $bizTotal = max(1, array_sum($businessTypes));
    $statusTotal = max(1, array_sum($statusCounts));
@endphp

<div style="display:flex; flex-direction:column; gap:14px; font-family:inherit;">

{{-- ── Period filter bar ───────────────────────────────────────────────────── --}}
<div style="display:flex; align-items:center; justify-content:flex-end; gap:6px;">
    @foreach(['month'=>'Month','quarter'=>'Quarter','year'=>'Year'] as $p => $label)
    <a href="?period={{ $p }}"
       style="padding:5px 14px; border-radius:6px; font-size:12px; font-weight:600; text-decoration:none;
              {{ $period === $p
                  ? 'background:#0f172a; color:#fff;'
                  : 'background:#f1f5f9; color:#64748b; border:1px solid #e2e8f0;' }}">
        {{ $label }}
    </a>
    @endforeach
</div>

{{-- ── KPI Row 1 ────────────────────────────────────────────────────────────── --}}
<div style="display:grid; grid-template-columns:1fr 1fr 1fr 1fr; gap:12px;">

    {{-- Total Revenue --}}
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; padding:16px 18px; position:relative; overflow:hidden;">
        <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:8px;">
            <div style="width:32px; height:32px; border-radius:8px; background:#dcfce7; display:flex; align-items:center; justify-content:center;">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#16a34a"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <span style="font-size:10px; color:#94a3b8; font-weight:500;">Total Revenue</span>
        </div>
        <p style="font-size:22px; font-weight:800; color:#0f172a; margin:0 0 4px; line-height:1.1;">Rs. {{ number_format($totalRevenue/100000, 1) }}L</p>
        <p style="font-size:11px; color:{{ $revGrowth >= 0 ? '#16a34a' : '#dc2626' }}; margin:0; font-weight:500;">
            {{ $revGrowth >= 0 ? '▲' : '▼' }} {{ abs($revGrowth) }}%
            <span style="color:#94a3b8; font-weight:400;"> Rs. {{ number_format($thisMonthRev/100000, 1) }}L this month</span>
        </p>
    </div>

    {{-- Total Bookings --}}
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; padding:16px 18px;">
        <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:8px;">
            <div style="width:32px; height:32px; border-radius:8px; background:#fff7ed; display:flex; align-items:center; justify-content:center;">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#ea580c"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <span style="font-size:10px; color:#94a3b8; font-weight:500;">Total Bookings</span>
        </div>
        <p style="font-size:22px; font-weight:800; color:#0f172a; margin:0 0 4px; line-height:1.1;">{{ number_format($totalBookings) }}</p>
        <p style="font-size:11px; color:#64748b; margin:0;">
            <span style="color:#ea580c; font-weight:600;">{{ $thisMonthBooks }}</span> this month
            · <span style="color:#f59e0b; font-weight:600;">{{ $pendingBooks }}</span> pending
        </p>
    </div>

    {{-- Registered Users --}}
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; padding:16px 18px;">
        <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:8px;">
            <div style="width:32px; height:32px; border-radius:8px; background:#eff6ff; display:flex; align-items:center; justify-content:center;">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#2563eb"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <span style="font-size:10px; color:#94a3b8; font-weight:500;">Registered Users</span>
        </div>
        <p style="font-size:22px; font-weight:800; color:#0f172a; margin:0 0 4px; line-height:1.1;">{{ number_format($totalUsers) }}</p>
        <p style="font-size:11px; color:#64748b; margin:0;">
            <span style="color:#2563eb; font-weight:600;">{{ $thisMonthUsers }}</span> new this month
        </p>
    </div>

    {{-- Avg Booking Value --}}
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; padding:16px 18px;">
        <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:8px;">
            <div style="width:32px; height:32px; border-radius:8px; background:#fef2f2; display:flex; align-items:center; justify-content:center;">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#dc2626"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
            <span style="font-size:10px; color:#94a3b8; font-weight:500;">Avg Booking Value</span>
        </div>
        <p style="font-size:22px; font-weight:800; color:#0f172a; margin:0 0 4px; line-height:1.1;">Rs. {{ number_format($avgValue) }}</p>
        <p style="font-size:11px; color:#64748b; margin:0;">
            Across <span style="color:#dc2626; font-weight:600;">{{ number_format($totalBookings) }}</span> bookings
        </p>
    </div>
</div>

{{-- ── KPI Row 2 ────────────────────────────────────────────────────────────── --}}
<div style="display:grid; grid-template-columns:1fr 1fr 1fr 1fr; gap:12px;">

    {{-- Active Businesses --}}
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; padding:16px 18px;">
        <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:8px;">
            <div style="width:32px; height:32px; border-radius:8px; background:#eff6ff; display:flex; align-items:center; justify-content:center;">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#2563eb"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <span style="font-size:10px; color:#94a3b8; font-weight:500;">Active Businesses</span>
        </div>
        <p style="font-size:22px; font-weight:800; color:#0f172a; margin:0 0 4px; line-height:1.1;">{{ number_format($totalBiz) }}</p>
        <p style="font-size:11px; color:#64748b; margin:0;">
            <span style="color:#16a34a; font-weight:600;">{{ $verifiedBiz }}</span> verified
            · <span style="color:#f59e0b; font-weight:600;">{{ $totalBiz - $verifiedBiz }}</span> pending
        </p>
    </div>

    {{-- Active Packages --}}
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; padding:16px 18px;">
        <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:8px;">
            <div style="width:32px; height:32px; border-radius:8px; background:#f0fdf4; display:flex; align-items:center; justify-content:center;">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#16a34a"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <span style="font-size:10px; color:#94a3b8; font-weight:500;">Active Packages</span>
        </div>
        <p style="font-size:22px; font-weight:800; color:#0f172a; margin:0 0 4px; line-height:1.1;">{{ number_format($activePackages) }}</p>
        <p style="font-size:11px; color:#64748b; margin:0;">
            <span style="color:#f59e0b; font-weight:600;">{{ $sponsoredPkgs }}</span> sponsored
            · <span style="color:#64748b;">{{ $activePackages - $sponsoredPkgs }}</span> standard
        </p>
    </div>

    {{-- Guides Available --}}
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; padding:16px 18px;">
        <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:8px;">
            <div style="width:32px; height:32px; border-radius:8px; background:#eff6ff; display:flex; align-items:center; justify-content:center;">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#2563eb"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
            </div>
            <span style="font-size:10px; color:#94a3b8; font-weight:500;">Guides Available</span>
        </div>
        <p style="font-size:22px; font-weight:800; color:#0f172a; margin:0 0 4px; line-height:1.1;">{{ number_format($totalGuides) }}</p>
        <p style="font-size:11px; color:#64748b; margin:0;">
            <span style="color:#f59e0b; font-weight:600;">{{ $avgRating }}</span> / 5.0 avg rating
        </p>
    </div>

    {{-- Pending Actions --}}
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; padding:16px 18px; {{ $totalPending > 0 ? 'border-color:#fef3c7;' : '' }}">
        <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:8px;">
            <div style="width:32px; height:32px; border-radius:8px; background:{{ $totalPending > 0 ? '#fef3c7' : '#f0fdf4' }}; display:flex; align-items:center; justify-content:center;">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="{{ $totalPending > 0 ? '#b45309' : '#16a34a' }}"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            </div>
            <span style="font-size:10px; color:#94a3b8; font-weight:500;">Pending Actions</span>
        </div>
        <p style="font-size:22px; font-weight:800; color:{{ $totalPending > 0 ? '#b45309' : '#0f172a' }}; margin:0 0 4px; line-height:1.1;">{{ number_format($totalPending) }}</p>
        <p style="font-size:11px; color:#64748b; margin:0;">
            <span style="color:#f59e0b; font-weight:600;">{{ $pendingBooks }}</span> bookings
            · <span style="color:#3b82f6; font-weight:600;">{{ $newInquiries }}</span> inquiries
        </p>
    </div>
</div>

{{-- ── Row 3: Revenue Chart + Recent Bookings ──────────────────────────────── --}}
<div style="display:grid; grid-template-columns:3fr 2fr; gap:12px;">

    {{-- Revenue & Bookings chart --}}
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; overflow:hidden;">
        <div style="padding:14px 18px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between;">
            <div>
                <p style="font-size:13px; font-weight:700; color:#0f172a; margin:0; line-height:1;">Revenue & Bookings</p>
                <p style="font-size:11px; color:#94a3b8; margin:2px 0 0;">{{ $revenueMonths->count() }}-month trend</p>
            </div>
            <div style="display:flex; gap:14px; font-size:11px; color:#64748b;">
                <span style="display:flex; align-items:center; gap:4px;"><span style="width:12px; height:3px; border-radius:2px; background:#3b82f6; display:inline-block;"></span> Revenue</span>
                <span style="display:flex; align-items:center; gap:4px;"><span style="width:12px; height:3px; border-radius:2px; background:#10b981; display:inline-block;"></span> Bookings</span>
                <span style="display:flex; align-items:center; gap:4px;"><span style="width:12px; height:3px; border-radius:2px; background:#f59e0b; display:inline-block;"></span> New Users</span>
            </div>
        </div>
        <div style="padding:16px 18px; height:200px;">
            <canvas id="db-revenue-chart" style="width:100%; height:100%;"></canvas>
        </div>
    </div>

    {{-- Recent Bookings list --}}
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; overflow:hidden;">
        <div style="padding:14px 18px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between;">
            <p style="font-size:13px; font-weight:700; color:#0f172a; margin:0;">Recent Bookings</p>
            <a href="/admin/bookings" style="font-size:11px; color:#3b82f6; text-decoration:none; font-weight:600;">View all →</a>
        </div>
        <div style="overflow:hidden;">
            @forelse($recentBookings as $bk)
            @php
                $st = match($bk->status) {
                    'confirmed' => ['bg'=>'#f0fdf4','color'=>'#166534','label'=>'Confirmed'],
                    'completed' => ['bg'=>'#eff6ff','color'=>'#1e3a8a','label'=>'Completed'],
                    'cancelled' => ['bg'=>'#fef2f2','color'=>'#991b1b','label'=>'Cancelled'],
                    default     => ['bg'=>'#fffbeb','color'=>'#92400e','label'=>'Pending'],
                };
                $initials = strtoupper(substr($bk->guest_name ?? '?', 0, 2));
                $avatarBg = match($bk->status) {
                    'confirmed' => '#dcfce7', 'completed' => '#dbeafe',
                    'cancelled' => '#fee2e2', default => '#fef3c7',
                };
                $avatarColor = match($bk->status) {
                    'confirmed' => '#166534', 'completed' => '#1e3a8a',
                    'cancelled' => '#991b1b', default => '#92400e',
                };
            @endphp
            <div style="padding:10px 18px; border-bottom:1px solid #f8fafc; display:flex; align-items:center; gap:10px;">
                <div style="width:32px; height:32px; border-radius:50%; background:{{ $avatarBg }}; color:{{ $avatarColor }}; font-size:11px; font-weight:700; display:flex; align-items:center; justify-content:center; flex-shrink:0;">{{ $initials }}</div>
                <div style="flex:1; min-width:0;">
                    <div style="display:flex; align-items:center; gap:6px; margin-bottom:1px;">
                        <span style="font-size:12px; font-weight:600; color:#0f172a; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $bk->guest_name }}</span>
                        <span style="flex-shrink:0; font-size:9px; font-weight:700; background:{{ $st['bg'] }}; color:{{ $st['color'] }}; padding:1px 6px; border-radius:8px;">{{ $st['label'] }}</span>
                    </div>
                    <p style="font-size:11px; color:#94a3b8; margin:0; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $bk->bookable?->name ?? '—' }}</p>
                </div>
                <div style="text-align:right; flex-shrink:0;">
                    <p style="font-size:12px; font-weight:700; color:#0f172a; margin:0;">{{ $bk->total_price ? 'Rs. '.number_format($bk->total_price) : '—' }}</p>
                    <p style="font-size:10px; color:#94a3b8; margin:1px 0 0;">{{ $bk->created_at->format('d M') }}</p>
                </div>
            </div>
            @empty
            <div style="padding:32px; text-align:center; color:#94a3b8; font-size:12px;">No bookings yet</div>
            @endforelse
        </div>
    </div>
</div>

{{-- ── Row 4: Status + Business Types + Inquiries & Quick Actions ─────────── --}}
<div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px;">

    {{-- Booking Status donut --}}
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; overflow:hidden;">
        <div style="padding:12px 18px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between;">
            <p style="font-size:13px; font-weight:700; color:#0f172a; margin:0;">Booking Status</p>
            <span style="font-size:11px; color:#94a3b8;">{{ number_format($statusTotal) }} total</span>
        </div>
        <div style="padding:16px 18px; display:flex; align-items:center; gap:16px;">
            <div style="width:100px; height:100px; position:relative; flex-shrink:0;">
                <canvas id="db-status-donut"></canvas>
                <div style="position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; pointer-events:none;">
                    <span style="font-size:18px; font-weight:800; color:#0f172a; line-height:1;">{{ number_format($statusTotal) }}</span>
                    <span style="font-size:9px; color:#94a3b8;">total</span>
                </div>
            </div>
            <div style="display:flex; flex-direction:column; gap:6px; flex:1;">
                @foreach([
                    'confirmed' => ['Confirmed','#10b981','#f0fdf4'],
                    'completed' => ['Completed','#3b82f6','#eff6ff'],
                    'pending'   => ['Pending',  '#f59e0b','#fffbeb'],
                    'cancelled' => ['Cancelled','#ef4444','#fef2f2'],
                ] as $key => [$lbl,$color,$bg])
                <div style="display:flex; align-items:center; justify-content:space-between;">
                    <div style="display:flex; align-items:center; gap:6px;">
                        <span style="width:8px; height:8px; border-radius:50%; background:{{ $color }}; flex-shrink:0;"></span>
                        <span style="font-size:11px; color:#64748b;">{{ $lbl }}</span>
                    </div>
                    <span style="font-size:12px; font-weight:700; color:#0f172a;">{{ number_format($statusCounts[$key]) }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Business Types donut --}}
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; overflow:hidden;">
        <div style="padding:12px 18px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between;">
            <p style="font-size:13px; font-weight:700; color:#0f172a; margin:0;">Business Types</p>
            <span style="font-size:11px; color:#94a3b8;">{{ number_format($totalBiz) }} partners</span>
        </div>
        <div style="padding:16px 18px; display:flex; align-items:center; gap:16px;">
            <div style="width:100px; height:100px; position:relative; flex-shrink:0;">
                @if(!empty($businessTypes))
                <canvas id="db-biz-donut"></canvas>
                <div style="position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; pointer-events:none;">
                    <span style="font-size:18px; font-weight:800; color:#0f172a; line-height:1;">{{ number_format($totalBiz) }}</span>
                    <span style="font-size:9px; color:#94a3b8;">businesses</span>
                </div>
                @else
                <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size:11px; color:#94a3b8;">No data</div>
                @endif
            </div>
            <div style="display:flex; flex-direction:column; gap:5px; flex:1; min-width:0;">
                @php $bizColors = ['#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6']; $bi = 0; @endphp
                @foreach($businessTypes as $type => $cnt)
                <div style="display:flex; align-items:center; justify-content:space-between; gap:4px;">
                    <div style="display:flex; align-items:center; gap:5px; min-width:0;">
                        <span style="width:8px; height:8px; border-radius:50%; background:{{ $bizColors[$bi % 5] }}; flex-shrink:0;"></span>
                        <span style="font-size:10px; color:#64748b; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; text-transform:capitalize;">{{ str_replace('_',' ',$type) }}</span>
                    </div>
                    <div style="display:flex; align-items:center; gap:5px; flex-shrink:0;">
                        <span style="font-size:10px; color:#94a3b8;">{{ round($cnt/$bizTotal*100) }}%</span>
                        <span style="font-size:11px; font-weight:700; color:#0f172a;">{{ $cnt }}</span>
                    </div>
                </div>
                @php $bi++; @endphp
                @endforeach
            </div>
        </div>
    </div>

    {{-- Package Inquiries + Quick Actions --}}
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; overflow:hidden; display:flex; flex-direction:column;">
        {{-- Inquiries chart --}}
        <div style="padding:12px 18px; border-bottom:1px solid #f1f5f9;">
            <p style="font-size:13px; font-weight:700; color:#0f172a; margin:0 0 2px;">Package Inquiries</p>
            <div style="display:flex; align-items:baseline; gap:8px;">
                <span style="font-size:22px; font-weight:800; color:#0f172a; line-height:1;">{{ number_format($totalInquiries) }}</span>
                @if($inquiryGrowth !== 0)
                <span style="font-size:11px; font-weight:600; color:{{ $inquiryGrowth > 0 ? '#16a34a' : '#dc2626' }};">
                    {{ $inquiryGrowth > 0 ? '▲' : '▼' }} {{ abs($inquiryGrowth) }}%
                </span>
                <span style="font-size:10px; color:#94a3b8;">vs prev. 6 mo</span>
                @endif
            </div>
        </div>
        <div style="padding:8px 18px; height:80px;">
            <canvas id="db-inquiry-chart" style="width:100%; height:100%;"></canvas>
        </div>

        {{-- Quick Actions --}}
        <div style="padding:12px 18px; border-top:1px solid #f1f5f9; flex:1;">
            <p style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.05em; margin:0 0 8px;">Quick Actions</p>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:6px;">
                <a href="/admin/packages/create" style="display:flex; align-items:center; gap:6px; padding:8px 10px; background:#f0fdf4; border-radius:7px; text-decoration:none; border:1px solid #dcfce7;">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="#16a34a"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span style="font-size:11px; font-weight:600; color:#166534;">Add Package</span>
                </a>
                <a href="/admin/businesses?tableFilters[is_verified][value]=0" style="display:flex; align-items:center; gap:6px; padding:8px 10px; background:#eff6ff; border-radius:7px; text-decoration:none; border:1px solid #dbeafe;">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="#2563eb"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span style="font-size:11px; font-weight:600; color:#1e40af;">Verify Business</span>
                    @if($totalBiz - $verifiedBiz > 0)
                    <span style="margin-left:auto; font-size:9px; background:#dbeafe; color:#1d4ed8; padding:1px 5px; border-radius:8px; font-weight:700;">{{ $totalBiz - $verifiedBiz }}</span>
                    @endif
                </a>
                <a href="/admin/package-inquiries?tableFilters[status][value]=new" style="display:flex; align-items:center; gap:6px; padding:8px 10px; background:#fff7ed; border-radius:7px; text-decoration:none; border:1px solid #fed7aa;">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="#ea580c"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span style="font-size:11px; font-weight:600; color:#9a3412;">Reply Inquiry</span>
                    @if($newInquiries > 0)
                    <span style="margin-left:auto; font-size:9px; background:#fed7aa; color:#c2410c; padding:1px 5px; border-radius:8px; font-weight:700;">{{ $newInquiries }}</span>
                    @endif
                </a>
                <a href="/admin/analytics" style="display:flex; align-items:center; gap:6px; padding:8px 10px; background:#faf5ff; border-radius:7px; text-decoration:none; border:1px solid #e9d5ff;">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="#9333ea"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    <span style="font-size:11px; font-weight:600; color:#7e22ce;">Analytics</span>
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ── Row 5: Top Packages + Heatmap + Messages ────────────────────────────── --}}
<div style="display:grid; grid-template-columns:3fr 2fr; gap:12px;">

    {{-- Top Performing Packages --}}
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; overflow:hidden;">
        <div style="padding:12px 18px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between;">
            <div>
                <p style="font-size:13px; font-weight:700; color:#0f172a; margin:0; line-height:1;">Top Performing Packages</p>
                <p style="font-size:10px; color:#94a3b8; margin:2px 0 0;">by total bookings</p>
            </div>
            <a href="/admin/packages" style="font-size:11px; color:#3b82f6; text-decoration:none; font-weight:600;">View all →</a>
        </div>
        @if($topPackages->isEmpty())
        <div style="padding:32px; text-align:center; color:#94a3b8; font-size:12px;">No package data yet</div>
        @else
        <table style="width:100%; border-collapse:collapse; font-size:12px;">
            <thead>
                <tr style="background:#f8fafc;">
                    <th style="padding:9px 18px; text-align:left; font-size:10px; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:.04em; border-bottom:1px solid #f1f5f9;">#</th>
                    <th style="padding:9px 6px; text-align:left; font-size:10px; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:.04em; border-bottom:1px solid #f1f5f9;">Package</th>
                    <th style="padding:9px 6px; text-align:left; font-size:10px; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:.04em; border-bottom:1px solid #f1f5f9;">Business</th>
                    <th style="padding:9px 6px; text-align:left; font-size:10px; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:.04em; border-bottom:1px solid #f1f5f9;">Bookings</th>
                    <th style="padding:9px 6px; text-align:center; font-size:10px; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:.04em; border-bottom:1px solid #f1f5f9;">Conversion</th>
                    <th style="padding:9px 18px; text-align:right; font-size:10px; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:.04em; border-bottom:1px solid #f1f5f9;">Revenue</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topPackages as $i => $pkg)
                @php
                    $conv = $pkg->total_bookings > 0 ? round($pkg->successful_bookings / $pkg->total_bookings * 100) : 0;
                    $barW = $maxPkgBookings > 0 ? round($pkg->total_bookings / $maxPkgBookings * 100) : 0;
                    $rev  = (int)($pkg->bookings_sum_total_price ?? 0);
                    $rankColors = [
                        0 => ['bg'=>'#fef3c7','color'=>'#b45309'],
                        1 => ['bg'=>'#f1f5f9','color'=>'#475569'],
                        2 => ['bg'=>'#fce7f3','color'=>'#be185d'],
                    ];
                    $rc = $rankColors[$i] ?? ['bg'=>'#f8fafc','color'=>'#94a3b8'];
                @endphp
                <tr style="{{ $i % 2 === 1 ? 'background:#fafafa;' : '' }}">
                    <td style="padding:10px 18px; border-bottom:1px solid #f8fafc;">
                        <span style="width:22px; height:22px; border-radius:50%; background:{{ $rc['bg'] }}; color:{{ $rc['color'] }}; font-size:10px; font-weight:700; display:inline-flex; align-items:center; justify-content:center;">{{ $i+1 }}</span>
                    </td>
                    <td style="padding:10px 6px; border-bottom:1px solid #f8fafc; max-width:180px;">
                        <p style="font-size:12px; font-weight:600; color:#0f172a; margin:0; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $pkg->name }}</p>
                        @if($pkg->listing_type === 'paid')
                        <span style="font-size:9px; background:#fef3c7; color:#b45309; padding:1px 5px; border-radius:6px; font-weight:700;">Sponsored</span>
                        @endif
                    </td>
                    <td style="padding:10px 6px; border-bottom:1px solid #f8fafc; color:#64748b; font-size:11px; max-width:120px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $pkg->business?->name ?? '—' }}</td>
                    <td style="padding:10px 6px; border-bottom:1px solid #f8fafc; min-width:100px;">
                        <div style="display:flex; align-items:center; gap:6px;">
                            <div style="flex:1; height:5px; background:#e2e8f0; border-radius:3px; overflow:hidden;">
                                <div style="height:5px; width:{{ $barW }}%; background:#3b82f6; border-radius:3px;"></div>
                            </div>
                            <span style="font-size:12px; font-weight:700; color:#0f172a; flex-shrink:0;">{{ $pkg->total_bookings }}</span>
                        </div>
                    </td>
                    <td style="padding:10px 6px; border-bottom:1px solid #f8fafc; text-align:center;">
                        <span style="font-size:11px; font-weight:600; color:{{ $conv >= 60 ? '#16a34a' : ($conv >= 30 ? '#d97706' : '#dc2626') }};">{{ $conv }}%</span>
                    </td>
                    <td style="padding:10px 18px; border-bottom:1px solid #f8fafc; text-align:right; font-size:11px; font-weight:600; color:#0f172a; white-space:nowrap;">
                        {{ $rev > 0 ? 'Rs. '.number_format($rev) : '—' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- Right column: Heatmap + Messages --}}
    <div style="display:flex; flex-direction:column; gap:12px;">

        {{-- Daily Bookings Heatmap --}}
        <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; overflow:hidden;">
            <div style="padding:12px 18px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between;">
                <p style="font-size:13px; font-weight:700; color:#0f172a; margin:0;">Daily Bookings</p>
                <div style="display:flex; align-items:center; gap:4px; font-size:10px; color:#94a3b8;">
                    Low
                    @foreach(['#dbeafe','#93c5fd','#60a5fa','#2563eb','#1e3a8a'] as $shade)
                    <span style="width:10px; height:10px; border-radius:2px; background:{{ $shade }};"></span>
                    @endforeach
                    High
                </div>
            </div>
            <div style="padding:12px 18px;">
                {{-- Day labels --}}
                <div style="display:grid; grid-template-columns:repeat(7,1fr); gap:3px; margin-bottom:3px;">
                    @foreach(['S','M','T','W','T','F','S'] as $d)
                    <div style="text-align:center; font-size:9px; color:#94a3b8; font-weight:600;">{{ $d }}</div>
                    @endforeach
                </div>
                {{-- Heatmap grid --}}
                @foreach($heatmapRows as $row)
                <div style="display:grid; grid-template-columns:repeat(7,1fr); gap:3px; margin-bottom:3px;">
                    @foreach($row as $day)
                    @php
                        $intensity = $heatmapMax > 0 ? $day['count'] / $heatmapMax : 0;
                        $cellColor = $day['count'] === 0
                            ? '#f1f5f9'
                            : ($intensity < 0.25
                                ? '#dbeafe'
                                : ($intensity < 0.5
                                    ? '#93c5fd'
                                    : ($intensity < 0.75
                                        ? '#3b82f6'
                                        : '#1e3a8a')));
                    @endphp
                    <div title="{{ $day['date'] }}: {{ $day['count'] }} booking{{ $day['count'] !== 1 ? 's' : '' }}"
                         style="aspect-ratio:1; border-radius:3px; background:{{ $cellColor }};"></div>
                    @endforeach
                </div>
                @endforeach
                <p style="font-size:10px; color:#94a3b8; margin:6px 0 0; text-align:right;">Past 35 days · {{ $heatmapDays->sum('count') }} bookings</p>
            </div>
        </div>

        {{-- Contact Messages --}}
        <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; overflow:hidden; flex:1;">
            <div style="padding:12px 18px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between;">
                <p style="font-size:13px; font-weight:700; color:#0f172a; margin:0;">Contact Messages</p>
                <a href="/admin/contact-submissions" style="font-size:11px; color:#3b82f6; text-decoration:none; font-weight:600;">View all →</a>
            </div>
            @forelse($recentMessages as $msg)
            @php $isNew = $msg->status === 'new'; @endphp
            <div style="padding:10px 18px; border-bottom:1px solid #f8fafc; display:flex; align-items:flex-start; gap:10px;">
                <div style="width:30px; height:30px; border-radius:50%; background:{{ $isNew ? '#dbeafe' : '#f1f5f9' }}; color:{{ $isNew ? '#1d4ed8' : '#64748b' }}; font-size:11px; font-weight:700; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    {{ strtoupper(substr($msg->name ?? '?', 0, 2)) }}
                </div>
                <div style="flex:1; min-width:0;">
                    <div style="display:flex; align-items:center; gap:6px; justify-content:space-between;">
                        <span style="font-size:12px; font-weight:600; color:#0f172a; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $msg->name }}</span>
                        <div style="display:flex; align-items:center; gap:4px; flex-shrink:0;">
                            @if($isNew)
                            <span style="font-size:9px; font-weight:700; background:#dbeafe; color:#1d4ed8; padding:1px 5px; border-radius:6px;">● New</span>
                            @else
                            <span style="font-size:9px; color:#94a3b8; background:#f1f5f9; padding:1px 5px; border-radius:6px;">○ Open</span>
                            @endif
                            <span style="font-size:10px; color:#94a3b8;">{{ $msg->created_at->diffForHumans(null, true) }}</span>
                        </div>
                    </div>
                    <p style="font-size:11px; color:#94a3b8; margin:1px 0 0; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $msg->subject ?? $msg->message }}</p>
                </div>
            </div>
            @empty
            <div style="padding:20px; text-align:center; color:#94a3b8; font-size:12px;">No messages yet</div>
            @endforelse
        </div>
    </div>
</div>

</div>

<script>
(function () {
    function initCharts() {
        if (!window.Chart) return;
        Chart.defaults.font.family = 'inherit';
        Chart.defaults.font.size = 11;

        // Destroy existing
        ['db-revenue-chart','db-status-donut','db-biz-donut','db-inquiry-chart'].forEach(id => {
            const el = document.getElementById(id);
            if (el) { const c = Chart.getChart(el); if (c) c.destroy(); }
        });

        // Revenue & Bookings dual-axis line
        const revEl = document.getElementById('db-revenue-chart');
        if (revEl) {
            new Chart(revEl.getContext('2d'), {
                type: 'line',
                data: {
                    labels: {!! $rl !!},
                    datasets: [
                        { label:'Revenue', data:{!! $rv !!}, borderColor:'#3b82f6', backgroundColor:'rgba(59,130,246,0.07)', borderWidth:2.5, fill:true, tension:0.4, pointRadius:2.5, pointBackgroundColor:'#3b82f6', yAxisID:'yRev' },
                        { label:'Bookings', data:{!! $bv !!}, borderColor:'#10b981', backgroundColor:'transparent', borderWidth:2, fill:false, tension:0.4, pointRadius:2.5, pointBackgroundColor:'#10b981', yAxisID:'yCnt' },
                        { label:'New Users', data:{!! $uv !!}, borderColor:'#f59e0b', backgroundColor:'transparent', borderWidth:1.5, borderDash:[5,3], fill:false, tension:0.4, pointRadius:2, pointBackgroundColor:'#f59e0b', yAxisID:'yCnt' },
                    ],
                },
                options: {
                    responsive:true, maintainAspectRatio:false,
                    interaction:{ mode:'index', intersect:false },
                    plugins:{ legend:{display:false}, tooltip:{ backgroundColor:'#1e293b', titleColor:'#f8fafc', bodyColor:'#94a3b8', padding:10, callbacks:{ label(c){ return c.dataset.yAxisID==='yRev' ? ' Rs.'+c.parsed.y.toLocaleString() : ' '+c.parsed.y+' '+c.dataset.label.toLowerCase(); } } } },
                    scales:{
                        x:{ grid:{color:'#f1f5f9'}, ticks:{color:'#94a3b8', maxRotation:0} },
                        yRev:{ position:'left', grid:{color:'#f1f5f9'}, ticks:{color:'#94a3b8', callback:v=>'Rs.'+(v>=1000?(v/1000).toFixed(0)+'k':v)} },
                        yCnt:{ position:'right', grid:{drawOnChartArea:false}, ticks:{color:'#94a3b8'} },
                    },
                },
            });
        }

        // Booking status donut
        const stEl = document.getElementById('db-status-donut');
        if (stEl) {
            new Chart(stEl.getContext('2d'), {
                type:'doughnut',
                data:{ labels:{!! $sl !!}, datasets:[{ data:{!! $sv !!}, backgroundColor:{!! $sc !!}, borderWidth:2, borderColor:'#fff', hoverOffset:3 }] },
                options:{ responsive:true, maintainAspectRatio:false, cutout:'72%', plugins:{ legend:{display:false}, tooltip:{backgroundColor:'#1e293b',titleColor:'#f8fafc',bodyColor:'#94a3b8',padding:8} } },
            });
        }

        // Business type donut
        const bzEl = document.getElementById('db-biz-donut');
        if (bzEl && {!! json_encode(!empty($businessTypes)) !!}) {
            new Chart(bzEl.getContext('2d'), {
                type:'doughnut',
                data:{ labels:{!! $bl !!}, datasets:[{ data:{!! $bz !!}, backgroundColor:{!! $bc !!}, borderWidth:2, borderColor:'#fff', hoverOffset:3 }] },
                options:{ responsive:true, maintainAspectRatio:false, cutout:'68%', plugins:{ legend:{display:false}, tooltip:{backgroundColor:'#1e293b',titleColor:'#f8fafc',bodyColor:'#94a3b8',padding:8} } },
            });
        }

        // Inquiry line chart
        const inqEl = document.getElementById('db-inquiry-chart');
        if (inqEl) {
            new Chart(inqEl.getContext('2d'), {
                type:'line',
                data:{ labels:{!! $il !!}, datasets:[{ label:'Inquiries', data:{!! $iv !!}, borderColor:'#8b5cf6', backgroundColor:'rgba(139,92,246,0.1)', borderWidth:2, fill:true, tension:0.4, pointRadius:0 }] },
                options:{
                    responsive:true, maintainAspectRatio:false,
                    plugins:{ legend:{display:false}, tooltip:{backgroundColor:'#1e293b',titleColor:'#f8fafc',bodyColor:'#94a3b8',padding:6} },
                    scales:{ x:{display:false}, y:{display:false, beginAtZero:true} },
                },
            });
        }
    }

    if (window.Chart) { initCharts(); }
    else {
        const interval = setInterval(() => { if (window.Chart) { clearInterval(interval); initCharts(); } }, 100);
    }

    document.addEventListener('livewire:navigated', initCharts);
})();
</script>
