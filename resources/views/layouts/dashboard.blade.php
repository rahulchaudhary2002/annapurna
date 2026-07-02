<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page_title', 'Dashboard') - {{ \App\Helpers\Cms::siteName() }}</title>

    {{-- Google Fonts --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Barlow:wght@300;400;500&family=Poppins:wght@300;400;500;600;700&display=swap">

    {{-- Annapurna Theme CSS --}}
    <link rel="stylesheet" href="{{ asset('annapurna/css/plugins.css') }}" />
    <link rel="stylesheet" href="{{ asset('annapurna/css/style.css') }}" />

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ \App\Helpers\Cms::siteFavicon() }}" />

    <style>
        * { box-sizing: border-box; }

        body.dashboard-body {
            background: #f4f6f9;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Sidebar */
        .dash-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100vh;
            background: #1a1a2e;
            overflow-y: auto;
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }

        .dash-sidebar-logo {
            padding: 24px 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .dash-sidebar-logo a {
            text-decoration: none;
            color: #fff;
            font-size: 18px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .dash-sidebar-logo img {
            max-height: 40px;
            max-width: 180px;
        }

        .dash-sidebar-nav {
            flex: 1;
            padding: 16px 0;
        }

        .dash-sidebar-nav .nav-section-label {
            padding: 8px 20px 4px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255,255,255,0.35);
            font-weight: 600;
        }

        .dash-sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 14px;
            font-weight: 400;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .dash-sidebar-nav a:hover,
        .dash-sidebar-nav a.active {
            color: #fff;
            background: rgba(255,255,255,0.08);
            border-left-color: #c8a96e;
        }

        .dash-sidebar-nav a i {
            width: 18px;
            text-align: center;
            font-size: 15px;
            opacity: 0.85;
        }

        .dash-sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .dash-logout-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            color: rgba(255,255,255,0.6);
            font-size: 14px;
            text-decoration: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            transition: color 0.2s;
            width: 100%;
        }

        .dash-logout-btn:hover {
            color: #e74c3c;
        }

        /* Main area */
        .dash-main {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top header */
        .dash-header {
            background: #fff;
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .dash-header-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a2e;
            margin: 0;
        }

        .dash-header-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dash-header-user .user-name {
            font-size: 14px;
            font-weight: 500;
            color: #333;
        }

        .dash-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            background: #c8a96e;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #fff;
            font-size: 14px;
            overflow: hidden;
        }

        .dash-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Content */
        .dash-content {
            flex: 1;
            padding: 28px;
        }

        /* Alert messages */
        .dash-alert {
            padding: 12px 18px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .dash-alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .dash-alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .dash-alert-warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        /* Cards */
        .dash-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06);
            padding: 24px;
            margin-bottom: 24px;
        }

        .dash-card-title {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a2e;
            margin: 0 0 18px;
            padding-bottom: 12px;
            border-bottom: 1px solid #eee;
        }

        /* Stats cards */
        .dash-stat-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06);
            padding: 20px 24px;
            border-left: 4px solid #c8a96e;
        }

        .dash-stat-card .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #1a1a2e;
            line-height: 1;
        }

        .dash-stat-card .stat-label {
            font-size: 13px;
            color: #777;
            margin-top: 4px;
        }

        /* Tables */
        .dash-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .dash-table th {
            text-align: left;
            padding: 10px 14px;
            background: #f8f9fa;
            color: #555;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #eee;
        }

        .dash-table td {
            padding: 12px 14px;
            border-bottom: 1px solid #f0f0f0;
            color: #333;
            vertical-align: middle;
        }

        .dash-table tr:last-child td {
            border-bottom: none;
        }

        .dash-table tr:hover td {
            background: #fafafa;
        }

        /* Buttons */
        .btn-dash-primary {
            background: #c8a96e;
            color: #fff;
            border: none;
            padding: 9px 20px;
            border-radius: 5px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background 0.2s;
        }

        .btn-dash-primary:hover {
            background: #b8924a;
            color: #fff;
            text-decoration: none;
        }

        .btn-dash-secondary {
            background: #fff;
            color: #333;
            border: 1px solid #ddd;
            padding: 8px 18px;
            border-radius: 5px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s;
        }

        .btn-dash-secondary:hover {
            background: #f5f5f5;
            color: #333;
            text-decoration: none;
        }

        .btn-dash-danger {
            background: #e74c3c;
            color: #fff;
            border: none;
            padding: 7px 14px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background 0.2s;
        }

        .btn-dash-danger:hover {
            background: #c0392b;
            color: #fff;
            text-decoration: none;
        }

        .btn-dash-sm {
            padding: 5px 12px;
            font-size: 12px;
        }

        /* Forms */
        .dash-form-group {
            margin-bottom: 18px;
        }

        .dash-form-group label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #444;
            margin-bottom: 6px;
        }

        .dash-form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            color: #333;
            font-family: 'Poppins', sans-serif;
            transition: border-color 0.2s;
            background: #fff;
        }

        .dash-form-control:focus {
            outline: none;
            border-color: #c8a96e;
        }

        .dash-form-control.is-invalid {
            border-color: #e74c3c;
        }

        .invalid-feedback {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 4px;
        }

        textarea.dash-form-control {
            min-height: 100px;
            resize: vertical;
        }

        select.dash-form-control {
            cursor: pointer;
        }

        /* Badges */
        .badge-active { background: #d4edda; color: #155724; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .badge-inactive { background: #f8d7da; color: #721c24; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .badge-owner { background: #c8a96e; color: #fff; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .badge-manager { background: #3498db; color: #fff; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .badge-staff { background: #95a5a6; color: #fff; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }

        /* Grid helpers */
        .dash-row { display: flex; flex-wrap: wrap; margin: 0 -12px; }
        .dash-col-4 { flex: 0 0 33.333%; max-width: 33.333%; padding: 0 12px; }
        .dash-col-6 { flex: 0 0 50%; max-width: 50%; padding: 0 12px; }
        .dash-col-12 { flex: 0 0 100%; max-width: 100%; padding: 0 12px; }

        .mb-0 { margin-bottom: 0 !important; }
        .mb-1 { margin-bottom: 8px !important; }
        .mb-2 { margin-bottom: 16px !important; }
        .mb-3 { margin-bottom: 24px !important; }
        .mt-1 { margin-top: 8px !important; }
        .mt-2 { margin-top: 16px !important; }
        .mt-3 { margin-top: 24px !important; }
        .d-flex { display: flex; }
        .align-items-center { align-items: center; }
        .justify-content-between { justify-content: space-between; }
        .gap-2 { gap: 8px; }
        .gap-3 { gap: 12px; }
        .text-muted { color: #888; font-size: 13px; }
        .text-small { font-size: 12px; }

        /* Responsive */
        @media (max-width: 900px) {
            .dash-sidebar { transform: translateX(-260px); transition: transform 0.3s; }
            .dash-sidebar.open { transform: translateX(0); }
            .dash-main { margin-left: 0; }
            .dash-col-4, .dash-col-6 { flex: 0 0 100%; max-width: 100%; margin-bottom: 16px; }
        }
    </style>

    @stack('styles')
</head>
<body class="dashboard-body">

    {{-- Sidebar --}}
    <aside class="dash-sidebar">
        <div class="dash-sidebar-logo">
            @php $siteLogo = \App\Helpers\Cms::siteLogo(); @endphp
            <a href="{{ route('home') }}">
                @if($siteLogo)
                    <img src="{{ $siteLogo }}" alt="{{ \App\Helpers\Cms::siteName() }}">
                @else
                    {{ \App\Helpers\Cms::siteName() }}
                @endif
            </a>
        </div>

        <nav class="dash-sidebar-nav">
            <div class="nav-section-label">Main</div>
            <a href="{{ route('dashboard.index') }}"
               class="{{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                <i class="ti-home"></i> Dashboard
            </a>
            <a href="{{ route('dashboard.profile.edit') }}"
               class="{{ request()->routeIs('dashboard.profile.*') ? 'active' : '' }}">
                <i class="ti-user"></i> My Profile
            </a>

            <div class="nav-section-label" style="margin-top: 12px;">Businesses</div>
            <a href="{{ route('dashboard.businesses.index') }}"
               class="{{ request()->routeIs('dashboard.businesses.index') || request()->routeIs('dashboard.businesses.create') || request()->routeIs('dashboard.businesses.edit') ? 'active' : '' }}">
                <i class="ti-briefcase"></i> My Businesses
            </a>
            <a href="{{ route('dashboard.businesses.create') }}">
                <i class="ti-plus"></i> Add Business
            </a>
            <a href="{{ route('packages.index') }}" target="_blank">
                <i class="ti-package"></i> Browse Packages
            </a>

            <div class="nav-section-label" style="margin-top: 12px;">Community</div>
            <a href="{{ route('dashboard.feed.index') }}"
               class="{{ request()->routeIs('dashboard.feed.*') ? 'active' : '' }}">
                <i class="ti-layout-list-post"></i> My Posts
            </a>
            <a href="{{ route('feed.create') }}">
                <i class="ti-pencil-alt"></i> New Post
            </a>

            <div class="nav-section-label" style="margin-top: 12px;">Site</div>
            <a href="{{ route('home') }}" target="_blank">
                <i class="ti-world"></i> View Website
            </a>
            @if(auth()->user()?->hasRole('admin') || auth()->user()?->hasRole('super_admin'))
            <a href="{{ url('/admin') }}">
                <i class="ti-settings"></i> Admin Panel
            </a>
            @endif
        </nav>

        <div class="dash-sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dash-logout-btn">
                    <i class="ti-power-off"></i> Sign Out
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="dash-main">
        {{-- Top Header --}}
        <header class="dash-header">
            <h1 class="dash-header-title">@yield('page_title', 'Dashboard')</h1>

            <div class="dash-header-user">
                @php
                    $authUser = auth()->user();
                    $unreadNotifications = $authUser->unreadNotifications()->latest()->take(5)->get();
                    $unreadCount = $authUser->unreadNotifications()->count();
                @endphp

                {{-- Notification Bell --}}
                <div style="position:relative;margin-right:16px;">
                    <button id="notif-toggle" type="button"
                        style="background:none;border:none;cursor:pointer;position:relative;padding:4px;">
                        <i class="ti-bell" style="font-size:20px;color:#555;"></i>
                        @if($unreadCount > 0)
                        <span id="notif-badge" style="position:absolute;top:-2px;right:-4px;background:#e74c3c;color:#fff;font-size:10px;font-weight:700;width:18px;height:18px;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                            {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                        </span>
                        @endif
                    </button>

                    <div id="notif-dropdown" style="display:none;position:absolute;right:0;top:36px;width:340px;background:#fff;border-radius:8px;box-shadow:0 4px 20px rgba(0,0,0,.15);z-index:9999;overflow:hidden;">
                        <div style="padding:12px 16px;border-bottom:1px solid #f0f0f0;display:flex;align-items:center;justify-content:space-between;">
                            <span style="font-weight:600;font-size:14px;">Notifications</span>
                            @if($unreadCount > 0)
                            <form method="POST" action="{{ route('dashboard.notifications.read-all') }}" style="display:inline;">
                                @csrf
                                <button type="submit" style="background:none;border:none;font-size:12px;color:#c8a96e;cursor:pointer;font-weight:600;">Mark all read</button>
                            </form>
                            @endif
                        </div>
                        @if($unreadNotifications->isEmpty())
                        <div style="padding:20px;text-align:center;color:#aaa;font-size:13px;">No new notifications</div>
                        @else
                        @foreach($unreadNotifications as $notif)
                        @php $nd = $notif->data; @endphp
                        <div style="padding:12px 16px;border-bottom:1px solid #f8f8f8;display:flex;gap:10px;align-items:flex-start;">
                            <div style="width:8px;height:8px;background:#c8a96e;border-radius:50%;margin-top:5px;flex-shrink:0;"></div>
                            <div style="flex:1;">
                                <div style="font-size:13px;font-weight:600;color:#333;">{{ $nd['title'] ?? 'Notification' }}</div>
                                <div style="font-size:12px;color:#777;margin-top:2px;">{{ $nd['message'] ?? '' }}</div>
                                <div style="font-size:11px;color:#bbb;margin-top:4px;">{{ $notif->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                        <div style="padding:10px 16px;text-align:center;">
                            <a href="{{ route('dashboard.notifications.index') }}" style="font-size:12px;color:#c8a96e;font-weight:600;">View all notifications</a>
                        </div>
                    </div>
                </div>

                <div class="dash-avatar">
                    @if($authUser->avatar)
                        <img src="{{ asset('storage/' . $authUser->avatar) }}" alt="{{ $authUser->name }}">
                    @else
                        {{ strtoupper(substr($authUser->name, 0, 1)) }}
                    @endif
                </div>
                <span class="user-name">{{ $authUser->name }}</span>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var btn = document.getElementById('notif-toggle');
                    var dd = document.getElementById('notif-dropdown');
                    if (btn && dd) {
                        btn.addEventListener('click', function (e) {
                            e.stopPropagation();
                            dd.style.display = dd.style.display === 'none' ? 'block' : 'none';
                        });
                        document.addEventListener('click', function () { dd.style.display = 'none'; });
                    }
                });
            </script>
        </header>

        {{-- Content Area --}}
        <main class="dash-content">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="dash-alert dash-alert-success">
                    <i class="ti-check"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="dash-alert dash-alert-error">
                    <i class="ti-alert"></i> {{ session('error') }}
                </div>
            @endif
            @if(session('status'))
                <div class="dash-alert dash-alert-warning">
                    {{ session('status') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    {{-- Scripts --}}
    <script src="{{ asset('annapurna/js/jquery-3.6.3.min.js') }}"></script>
    <script src="{{ asset('annapurna/js/bootstrap.min.js') }}"></script>

    @stack('scripts')

</body>
</html>
