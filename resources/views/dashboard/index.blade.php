@extends('layouts.dashboard')

@section('page_title', 'Dashboard')

@section('content')

    <div style="margin-bottom: 24px;">
        <h2 style="font-size: 20px; color: #1a1a2e; margin: 0 0 4px;">Welcome back, {{ $user->name }}!</h2>
        <p class="text-muted">Here's an overview of your activity.</p>
    </div>

    {{-- Stats Row --}}
    <div class="dash-row mb-3">
        <div class="dash-col-4">
            <div class="dash-stat-card">
                <div class="stat-value">{{ $stats['businesses'] }}</div>
                <div class="stat-label">My Businesses</div>
            </div>
        </div>
        <div class="dash-col-4">
            <div class="dash-stat-card" style="border-left-color: #3498db;">
                <div class="stat-value">{{ $stats['posts'] }}</div>
                <div class="stat-label">Blog Posts</div>
            </div>
        </div>
        <div class="dash-col-4">
            <div class="dash-stat-card" style="border-left-color: #2ecc71;">
                <div class="stat-value">{{ $stats['memberships'] }}</div>
                <div class="stat-label">Business Memberships</div>
            </div>
        </div>
    </div>

    {{-- Email Verification Notice --}}
    @if(!$user->hasVerifiedEmail())
    <div class="dash-alert dash-alert-warning">
        <i class="ti-alert"></i>
        Your email address is not verified.
        <a href="{{ route('verification.notice') }}" style="color: #856404; font-weight: 600;">Verify now &rarr;</a>
    </div>
    @endif

    <div class="dash-row">
        {{-- Recent Businesses --}}
        <div class="dash-col-6">
            <div class="dash-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h3 class="dash-card-title mb-0">Recent Businesses</h3>
                    <a href="{{ route('dashboard.businesses.index') }}" class="btn-dash-secondary btn-dash-sm">View All</a>
                </div>

                @forelse($recentBusinesses as $business)
                <div style="padding: 12px 0; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <div style="font-weight: 500; font-size: 14px;">{{ $business->name }}</div>
                        <div class="text-muted text-small">{{ ucfirst(str_replace('_', ' ', $business->type)) }}</div>
                    </div>
                    <div style="display: flex; gap: 8px; align-items: center;">
                        <span class="{{ $business->is_active ? 'badge-active' : 'badge-inactive' }}">
                            {{ $business->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        <a href="{{ route('dashboard.businesses.dashboard', $business) }}" class="btn-dash-secondary btn-dash-sm">Dashboard</a>
                    </div>
                </div>
                @empty
                <p class="text-muted">No businesses yet. <a href="{{ route('dashboard.businesses.create') }}" style="color: #c8a96e;">Add your first business</a>.</p>
                @endforelse
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="dash-col-6">
            <div class="dash-card">
                <h3 class="dash-card-title">Quick Actions</h3>

                <a href="{{ route('dashboard.businesses.create') }}" class="btn-dash-primary" style="display: block; text-align: center; margin-bottom: 12px; padding: 14px;">
                    <i class="ti-plus"></i> Add New Business
                </a>
                <a href="{{ route('dashboard.profile.edit') }}" class="btn-dash-secondary" style="display: block; text-align: center; margin-bottom: 12px; padding: 14px;">
                    <i class="ti-user"></i> Edit Profile
                </a>
                <a href="{{ route('home') }}" target="_blank" class="btn-dash-secondary" style="display: block; text-align: center; padding: 14px;">
                    <i class="ti-world"></i> Visit Website
                </a>
            </div>

            {{-- Profile Completion --}}
            <div class="dash-card">
                <h3 class="dash-card-title">Profile</h3>
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div class="dash-avatar" style="width: 52px; height: 52px; font-size: 20px; background: #c8a96e; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; flex-shrink: 0; overflow: hidden;">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" style="width:100%;height:100%;object-fit:cover;">
                        @else
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <div style="font-weight: 600; font-size: 15px;">{{ $user->name }}</div>
                        <div class="text-muted">{{ $user->email }}</div>
                        @if($user->country)<div class="text-muted text-small">{{ $user->country }}</div>@endif
                    </div>
                </div>
                <a href="{{ route('dashboard.profile.edit') }}" class="btn-dash-secondary btn-dash-sm" style="margin-top: 16px;">Edit Profile</a>
            </div>
        </div>
    </div>

@endsection
