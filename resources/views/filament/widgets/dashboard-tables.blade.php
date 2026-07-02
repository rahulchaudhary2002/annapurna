<div style="display:grid; grid-template-columns:3fr 2fr; gap:16px; font-family:inherit;">

    {{-- ── Left: Recent Bookings ────────────────────────────────────────────── --}}
    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden;">
        <div style="padding:12px 16px; background:#f8fafc; border-bottom:1px solid #e2e8f0; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="#64748b"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span style="font-size:12px; font-weight:700; color:#1e293b;">Recent Bookings</span>
            </div>
            <a href="/admin/bookings" style="font-size:11px; color:#3b82f6; text-decoration:none; font-weight:600;">View all →</a>
        </div>

        @if($recentBookings->isEmpty())
        <div style="padding:32px; text-align:center; color:#94a3b8; font-size:12px;">No bookings yet</div>
        @else
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; font-size:12px; min-width:600px;">
                <thead>
                    <tr>
                        <th style="text-align:left; padding:9px 16px; color:#64748b; font-weight:600; border-bottom:1px solid #e2e8f0; font-size:11px; white-space:nowrap;">Booking #</th>
                        <th style="text-align:left; padding:9px 8px; color:#64748b; font-weight:600; border-bottom:1px solid #e2e8f0; font-size:11px;">Guest</th>
                        <th style="text-align:left; padding:9px 8px; color:#64748b; font-weight:600; border-bottom:1px solid #e2e8f0; font-size:11px;">Property</th>
                        <th style="text-align:center; padding:9px 8px; color:#64748b; font-weight:600; border-bottom:1px solid #e2e8f0; font-size:11px;">Status</th>
                        <th style="text-align:right; padding:9px 8px; color:#64748b; font-weight:600; border-bottom:1px solid #e2e8f0; font-size:11px;">Price</th>
                        <th style="text-align:right; padding:9px 16px; color:#64748b; font-weight:600; border-bottom:1px solid #e2e8f0; font-size:11px; white-space:nowrap;">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentBookings as $booking)
                    @php
                        $statusStyles = [
                            'pending'   => ['bg'=>'#fffbeb','color'=>'#92400e','label'=>'Pending'],
                            'confirmed' => ['bg'=>'#f0fdf4','color'=>'#064e3b','label'=>'Confirmed'],
                            'completed' => ['bg'=>'#eff6ff','color'=>'#1e3a8a','label'=>'Completed'],
                            'cancelled' => ['bg'=>'#fef2f2','color'=>'#7f1d1d','label'=>'Cancelled'],
                        ];
                        $st = $statusStyles[$booking->status] ?? ['bg'=>'#f1f5f9','color'=>'#475569','label'=>ucfirst($booking->status)];
                    @endphp
                    <tr style="border-bottom:1px solid #f8fafc;">
                        <td style="padding:9px 16px; white-space:nowrap;">
                            <a href="/admin/bookings/{{ $booking->id }}" style="font-weight:700; color:#1d4ed8; text-decoration:none; font-size:11px;">{{ $booking->booking_number }}</a>
                        </td>
                        <td style="padding:9px 8px; max-width:120px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; color:#374151; font-weight:500;">{{ $booking->guest_name }}</td>
                        <td style="padding:9px 8px; max-width:140px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; color:#64748b;">{{ $booking->bookable?->name ?? '—' }}</td>
                        <td style="padding:9px 8px; text-align:center;">
                            <span style="background:{{ $st['bg'] }}; color:{{ $st['color'] }}; font-size:10px; font-weight:700; padding:2px 7px; border-radius:9px; white-space:nowrap;">{{ $st['label'] }}</span>
                        </td>
                        <td style="padding:9px 8px; text-align:right; font-weight:600; color:#0f172a; white-space:nowrap;">{{ $booking->total_price ? 'Rs. '.number_format($booking->total_price) : '—' }}</td>
                        <td style="padding:9px 16px; text-align:right; color:#94a3b8; font-size:10px; white-space:nowrap;">{{ $booking->created_at->format('d M y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    {{-- ── Right: Inquiries + Messages ──────────────────────────────────────── --}}
    <div style="display:flex; flex-direction:column; gap:16px;">

        {{-- Package Inquiries --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden; flex:1;">
            <div style="padding:12px 16px; background:#f8fafc; border-bottom:1px solid #e2e8f0; display:flex; align-items:center; justify-content:space-between;">
                <div style="display:flex; align-items:center; gap:8px;">
                    <svg style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="#64748b"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span style="font-size:12px; font-weight:700; color:#1e293b;">Package Inquiries</span>
                </div>
                <a href="/admin/package-inquiries" style="font-size:11px; color:#3b82f6; text-decoration:none; font-weight:600;">View all →</a>
            </div>

            @if($recentInquiries->isEmpty())
            <div style="padding:20px; text-align:center; color:#94a3b8; font-size:12px;">No inquiries yet</div>
            @else
            <div style="display:flex; flex-direction:column;">
                @foreach($recentInquiries as $inq)
                @php $isNew = $inq->status === 'new'; @endphp
                <div style="padding:10px 16px; border-bottom:1px solid #f8fafc; display:flex; align-items:flex-start; gap:10px; {{ $isNew ? 'background:#fffbf0;' : '' }}">
                    <div style="width:28px; height:28px; border-radius:50%; background:{{ $isNew ? '#fef3c7' : '#f1f5f9' }}; color:{{ $isNew ? '#b45309' : '#64748b' }}; font-size:11px; font-weight:700; display:inline-flex; align-items:center; justify-content:center; flex-shrink:0;">
                        {{ strtoupper(substr($inq->name ?? '?', 0, 1)) }}
                    </div>
                    <div style="flex:1; min-width:0;">
                        <div style="display:flex; align-items:center; justify-content:space-between; gap:4px;">
                            <span style="font-size:12px; font-weight:600; color:#1e293b; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $inq->name }}</span>
                            @if($isNew)<span style="font-size:9px; font-weight:700; color:#b45309; background:#fef3c7; padding:1px 5px; border-radius:6px; flex-shrink:0;">NEW</span>@endif
                        </div>
                        <p style="font-size:11px; color:#64748b; margin:1px 0 0; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $inq->package?->name ?? 'Unknown package' }}</p>
                        <p style="font-size:10px; color:#94a3b8; margin:1px 0 0;">{{ $inq->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Contact Messages --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden; flex:1;">
            <div style="padding:12px 16px; background:#f8fafc; border-bottom:1px solid #e2e8f0; display:flex; align-items:center; justify-content:space-between;">
                <div style="display:flex; align-items:center; gap:8px;">
                    <svg style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="#64748b"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    <span style="font-size:12px; font-weight:700; color:#1e293b;">Contact Messages</span>
                </div>
                <a href="/admin/contact-submissions" style="font-size:11px; color:#3b82f6; text-decoration:none; font-weight:600;">View all →</a>
            </div>

            @if($recentMessages->isEmpty())
            <div style="padding:20px; text-align:center; color:#94a3b8; font-size:12px;">No messages yet</div>
            @else
            <div style="display:flex; flex-direction:column;">
                @foreach($recentMessages as $msg)
                @php $isNew = $msg->status === 'new'; @endphp
                <div style="padding:10px 16px; border-bottom:1px solid #f8fafc; display:flex; align-items:flex-start; gap:10px; {{ $isNew ? 'background:#f0f9ff;' : '' }}">
                    <div style="width:28px; height:28px; border-radius:50%; background:{{ $isNew ? '#dbeafe' : '#f1f5f9' }}; color:{{ $isNew ? '#1d4ed8' : '#64748b' }}; font-size:11px; font-weight:700; display:inline-flex; align-items:center; justify-content:center; flex-shrink:0;">
                        {{ strtoupper(substr($msg->name ?? '?', 0, 1)) }}
                    </div>
                    <div style="flex:1; min-width:0;">
                        <div style="display:flex; align-items:center; justify-content:space-between; gap:4px;">
                            <span style="font-size:12px; font-weight:600; color:#1e293b; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $msg->name }}</span>
                            @if($isNew)<span style="font-size:9px; font-weight:700; color:#1d4ed8; background:#dbeafe; padding:1px 5px; border-radius:6px; flex-shrink:0;">NEW</span>@endif
                        </div>
                        <p style="font-size:11px; color:#64748b; margin:1px 0 0; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $msg->subject ?? 'No subject' }}</p>
                        <p style="font-size:10px; color:#94a3b8; margin:1px 0 0;">{{ $msg->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

    </div>
</div>
