{{-- Single unified analytics card with internal section borders — no gap issues --}}
<div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden; font-family:inherit;">

    {{-- ── Card header ──────────────────────────────────────────────────────── --}}
    <div style="padding:14px 20px; background:#f8fafc; border-bottom:1px solid #e2e8f0; display:flex; align-items:center; justify-content:space-between;">
        <div style="display:flex; align-items:center; gap:8px;">
            <svg style="width:16px;height:16px;color:#64748b;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            <span style="font-size:13px; font-weight:700; color:#1e293b; letter-spacing:.01em;">Booking Analytics</span>
        </div>
        <span style="font-size:11px; color:#94a3b8; font-weight:500;">{{ $total }} total booking{{ $total !== 1 ? 's' : '' }}</span>
    </div>

    {{-- ── Row 1: Status | Hotel vs Package | 6-Month Trend ────────────────── --}}
    <div style="display:grid; grid-template-columns:1fr 1fr 1fr;">

        {{-- Status Breakdown --}}
        <div style="padding:18px 20px; border-right:1px solid #e2e8f0;">
            <p style="font-size:11px; font-weight:700; color:#64748b; margin:0 0 12px; text-transform:uppercase; letter-spacing:.06em;">Status Breakdown</p>
            <div style="display:flex; flex-direction:column; gap:10px;">
                @foreach([
                    'pending'   => ['Pending',   '#f59e0b','#fffbeb','#92400e'],
                    'confirmed' => ['Confirmed', '#10b981','#f0fdf4','#064e3b'],
                    'cancelled' => ['Cancelled', '#ef4444','#fef2f2','#7f1d1d'],
                    'completed' => ['Completed', '#3b82f6','#eff6ff','#1e3a8a'],
                ] as $status => [$label, $fill, $track, $text])
                @php $s = $statusData[$status]; @endphp
                <div>
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
                        <span style="font-size:11px; font-weight:600; color:{{ $text }}; background:{{ $track }}; padding:1px 7px; border-radius:10px;">{{ $label }}</span>
                        <div style="display:flex; align-items:baseline; gap:6px;">
                            <span style="font-size:10px; color:#94a3b8;">Rs.{{ $s['revenue'] > 0 ? number_format($s['revenue']/1000,0).'k' : '0' }}</span>
                            <span style="font-size:13px; font-weight:700; color:#0f172a;">{{ $s['count'] }}</span>
                        </div>
                    </div>
                    <div style="height:4px; background:{{ $track }}; border-radius:4px; overflow:hidden;">
                        <div style="height:4px; width:{{ max($s['pct'],0) }}%; background:{{ $fill }}; border-radius:4px; transition:width .3s;"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Hotel vs Package + Activity --}}
        <div style="padding:18px 20px; border-right:1px solid #e2e8f0;">
            <p style="font-size:11px; font-weight:700; color:#64748b; margin:0 0 12px; text-transform:uppercase; letter-spacing:.06em;">Hotel vs Package</p>

            <div style="display:flex; flex-direction:column; gap:10px; margin-bottom:14px;">
                {{-- Hotel --}}
                <div>
                    <div style="display:flex; justify-content:space-between; align-items:baseline; font-size:12px; margin-bottom:4px;">
                        <span style="font-weight:600; color:#1d4ed8;">🏨 Hotels</span>
                        <span style="font-weight:700; color:#0f172a;">{{ $hotelCount }} <span style="color:#94a3b8; font-size:10px; font-weight:400;">({{ $hotelPct }}%)</span></span>
                    </div>
                    <div style="height:5px; background:#dbeafe; border-radius:4px; overflow:hidden;">
                        <div style="height:5px; width:{{ $hotelPct }}%; background:#3b82f6; border-radius:4px;"></div>
                    </div>
                    <p style="font-size:10px; color:#94a3b8; margin:2px 0 0;">Rev: Rs. {{ number_format($hotelRevenue) }}</p>
                </div>
                {{-- Package --}}
                <div>
                    <div style="display:flex; justify-content:space-between; align-items:baseline; font-size:12px; margin-bottom:4px;">
                        <span style="font-weight:600; color:#047857;">🎒 Packages</span>
                        <span style="font-weight:700; color:#0f172a;">{{ $packageCount }} <span style="color:#94a3b8; font-size:10px; font-weight:400;">({{ $packagePct }}%)</span></span>
                    </div>
                    <div style="height:5px; background:#d1fae5; border-radius:4px; overflow:hidden;">
                        <div style="height:5px; width:{{ $packagePct }}%; background:#10b981; border-radius:4px;"></div>
                    </div>
                    <p style="font-size:10px; color:#94a3b8; margin:2px 0 0;">Rev: Rs. {{ number_format($packageRevenue) }}</p>
                </div>
            </div>

            {{-- Activity mini stats --}}
            <div style="border-top:1px solid #f1f5f9; padding-top:12px; display:grid; grid-template-columns:1fr 1fr; gap:8px;">
                <div style="background:#f8fafc; border-radius:8px; padding:8px 10px; text-align:center;">
                    <p style="font-size:18px; font-weight:700; color:#0f172a; margin:0; line-height:1;">{{ $today }}</p>
                    <p style="font-size:10px; color:#64748b; margin:2px 0 0;">Today</p>
                </div>
                <div style="background:#f8fafc; border-radius:8px; padding:8px 10px; text-align:center;">
                    <p style="font-size:18px; font-weight:700; color:#0f172a; margin:0; line-height:1;">{{ $thisWeek }}</p>
                    <p style="font-size:10px; color:#64748b; margin:2px 0 0;">This Week</p>
                    @if($lastWeek > 0)
                    <p style="font-size:10px; margin:1px 0 0; color:{{ $thisWeek >= $lastWeek ? '#059669' : '#dc2626' }};">
                        vs {{ $lastWeek }} last wk
                    </p>
                    @endif
                </div>
            </div>
        </div>

        {{-- 6-Month Trend --}}
        <div style="padding:18px 20px;">
            <p style="font-size:11px; font-weight:700; color:#64748b; margin:0 0 12px; text-transform:uppercase; letter-spacing:.06em;">6-Month Trend</p>
            <table style="width:100%; border-collapse:collapse; font-size:11px;">
                <thead>
                    <tr>
                        <th style="text-align:left; padding:0 6px 6px 0; color:#94a3b8; font-weight:600; border-bottom:1px solid #f1f5f9;">Month</th>
                        <th style="text-align:center; padding:0 4px 6px; color:#94a3b8; font-weight:600; border-bottom:1px solid #f1f5f9;">Total</th>
                        <th style="text-align:center; padding:0 4px 6px; color:#059669; font-weight:600; border-bottom:1px solid #f1f5f9;">✓</th>
                        <th style="text-align:center; padding:0 4px 6px; color:#dc2626; font-weight:600; border-bottom:1px solid #f1f5f9;">✗</th>
                        <th style="text-align:right; padding:0 0 6px 4px; color:#94a3b8; font-weight:600; border-bottom:1px solid #f1f5f9;">Rev.</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($monthlyTrend as $row)
                    <tr>
                        <td style="padding:5px 6px 5px 0; color:#475569; font-weight:500; border-bottom:1px solid #f8fafc;">{{ $row['label'] }}</td>
                        <td style="padding:5px 4px; text-align:center; font-weight:700; color:#0f172a; border-bottom:1px solid #f8fafc;">{{ $row['total'] }}</td>
                        <td style="padding:5px 4px; text-align:center; color:#059669; border-bottom:1px solid #f8fafc;">{{ $row['confirmed'] }}</td>
                        <td style="padding:5px 4px; text-align:center; color:#dc2626; border-bottom:1px solid #f8fafc;">{{ $row['cancelled'] }}</td>
                        <td style="padding:5px 0 5px 4px; text-align:right; color:#64748b; border-bottom:1px solid #f8fafc;">
                            {{ $row['revenue'] > 0 ? 'Rs.'.number_format($row['revenue']/1000,0).'k' : '—' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Horizontal divider between rows ─────────────────────────────────────── --}}
    <div style="height:1px; background:#e2e8f0;"></div>

    {{-- ── Row 2: Top Hotels | Top Packages | Repeat Guests ────────────────── --}}
    <div style="display:grid; grid-template-columns:1fr 1fr 1fr;">

        {{-- Top Hotels --}}
        <div style="padding:18px 20px; border-right:1px solid #e2e8f0;">
            <p style="font-size:11px; font-weight:700; color:#64748b; margin:0 0 12px; text-transform:uppercase; letter-spacing:.06em;">🏨 Top Hotels</p>
            @if($topHotels->isEmpty())
                <div style="text-align:center; padding:16px 0; color:#cbd5e1;">
                    <p style="font-size:12px; margin:0;">No hotel bookings yet</p>
                </div>
            @else
            <div style="display:flex; flex-direction:column; gap:8px;">
                @foreach($topHotels as $i => $hotel)
                <div style="display:flex; align-items:center; gap:10px;">
                    <span style="flex-shrink:0; width:20px; height:20px; border-radius:50%; background:{{ $i===0?'#fef3c7':($i===1?'#f1f5f9':'#f8fafc') }}; color:{{ $i===0?'#b45309':'#64748b' }}; font-size:10px; font-weight:700; display:inline-flex; align-items:center; justify-content:center;">{{ $i+1 }}</span>
                    <div style="flex:1; min-width:0;">
                        <p style="font-size:12px; font-weight:600; color:#1e293b; margin:0; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $hotel['name'] }}</p>
                        <p style="font-size:10px; color:#94a3b8; margin:1px 0 0;">Rs. {{ number_format($hotel['revenue']) }}</p>
                    </div>
                    <span style="flex-shrink:0; font-size:10px; font-weight:700; color:#1d4ed8; background:#eff6ff; padding:1px 6px; border-radius:8px; white-space:nowrap;">{{ $hotel['count'] }}×</span>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Top Packages --}}
        <div style="padding:18px 20px; border-right:1px solid #e2e8f0;">
            <p style="font-size:11px; font-weight:700; color:#64748b; margin:0 0 12px; text-transform:uppercase; letter-spacing:.06em;">🎒 Top Packages</p>
            @if($topPackages->isEmpty())
                <div style="text-align:center; padding:16px 0; color:#cbd5e1;">
                    <p style="font-size:12px; margin:0;">No package bookings yet</p>
                </div>
            @else
            <div style="display:flex; flex-direction:column; gap:8px;">
                @foreach($topPackages as $i => $pkg)
                <div style="display:flex; align-items:center; gap:10px;">
                    <span style="flex-shrink:0; width:20px; height:20px; border-radius:50%; background:{{ $i===0?'#d1fae5':($i===1?'#f1f5f9':'#f8fafc') }}; color:{{ $i===0?'#047857':'#64748b' }}; font-size:10px; font-weight:700; display:inline-flex; align-items:center; justify-content:center;">{{ $i+1 }}</span>
                    <div style="flex:1; min-width:0;">
                        <p style="font-size:12px; font-weight:600; color:#1e293b; margin:0; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $pkg['name'] }}</p>
                        <p style="font-size:10px; color:#94a3b8; margin:1px 0 0;">Rs. {{ number_format($pkg['revenue']) }}</p>
                    </div>
                    <span style="flex-shrink:0; font-size:10px; font-weight:700; color:#047857; background:#f0fdf4; padding:1px 6px; border-radius:8px; white-space:nowrap;">{{ $pkg['count'] }}×</span>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Repeat Guests --}}
        <div style="padding:18px 20px;">
            <p style="font-size:11px; font-weight:700; color:#64748b; margin:0 0 12px; text-transform:uppercase; letter-spacing:.06em;">🔁 Repeat Guests</p>
            @if($repeatGuests->isEmpty())
                <div style="text-align:center; padding:16px 0; color:#cbd5e1;">
                    <p style="font-size:12px; margin:0;">No repeat guests yet</p>
                </div>
            @else
            <div style="display:flex; flex-direction:column; gap:8px;">
                @foreach($repeatGuests as $guest)
                <div style="display:flex; align-items:center; gap:10px;">
                    <div style="flex-shrink:0; width:28px; height:28px; border-radius:50%; background:#ede9fe; color:#6d28d9; font-size:11px; font-weight:700; display:inline-flex; align-items:center; justify-content:center;">
                        {{ strtoupper(substr($guest->guest_name ?? $guest->guest_email, 0, 1)) }}
                    </div>
                    <div style="flex:1; min-width:0;">
                        <p style="font-size:12px; font-weight:600; color:#1e293b; margin:0; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $guest->guest_name ?? 'Guest' }}</p>
                        <p style="font-size:10px; color:#94a3b8; margin:1px 0 0; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $guest->guest_email }}</p>
                    </div>
                    <div style="flex-shrink:0; text-align:right;">
                        <p style="font-size:12px; font-weight:700; color:#6d28d9; margin:0; line-height:1;">{{ $guest->booking_count }}×</p>
                        <p style="font-size:10px; color:#94a3b8; margin:2px 0 0;">Rs.{{ number_format($guest->total_spent/1000,1) }}k</p>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
