@extends('layouts.dashboard')

@section('page_title', 'Notifications')

@section('content')
<div class="dash-card">
    <div class="dash-card-header" style="display:flex;align-items:center;justify-content:space-between;">
        <h4 class="dash-card-title">All Notifications</h4>
        @if($notifications->where('read_at', null)->count() > 0)
        <form method="POST" action="{{ route('dashboard.notifications.read-all') }}">
            @csrf
            <button type="submit" class="btn btn-sm" style="background:#c8a96e;color:#fff;border:none;padding:6px 14px;border-radius:4px;font-size:13px;">
                Mark all as read
            </button>
        </form>
        @endif
    </div>

    @if($notifications->isEmpty())
    <div style="padding:40px;text-align:center;color:#aaa;">
        <i class="ti-bell" style="font-size:40px;display:block;margin-bottom:12px;"></i>
        No notifications yet.
    </div>
    @else
    <div style="divide:1px solid #f0f0f0;">
        @foreach($notifications as $notif)
        @php $nd = $notif->data; $isUnread = $notif->read_at === null; @endphp
        <div style="padding:16px 20px;border-bottom:1px solid #f5f5f5;display:flex;gap:14px;align-items:flex-start;background:{{ $isUnread ? '#fffbf2' : '#fff' }};">
            <div style="width:10px;height:10px;border-radius:50%;margin-top:6px;flex-shrink:0;background:{{ $isUnread ? '#c8a96e' : '#ddd' }};"></div>
            <div style="flex:1;">
                <div style="font-weight:{{ $isUnread ? '600' : '400' }};font-size:14px;color:#333;">
                    {{ $nd['title'] ?? 'Notification' }}
                </div>
                <div style="font-size:13px;color:#666;margin-top:4px;">
                    {{ $nd['message'] ?? '' }}
                </div>
                <div style="font-size:11px;color:#bbb;margin-top:6px;">
                    {{ $notif->created_at->format('d M Y, h:i A') }} &bull; {{ $notif->created_at->diffForHumans() }}
                </div>
            </div>
            @if($isUnread)
            <form method="POST" action="{{ route('dashboard.notifications.read', $notif->id) }}" style="flex-shrink:0;">
                @csrf
                <button type="submit" style="background:none;border:none;cursor:pointer;font-size:11px;color:#c8a96e;font-weight:600;">Mark read</button>
            </form>
            @endif
        </div>
        @endforeach
    </div>

    <div style="padding:16px 20px;">
        {{ $notifications->links() }}
    </div>
    @endif
</div>
@endsection
