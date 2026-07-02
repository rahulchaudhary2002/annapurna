@extends('layouts.dashboard')

@section('page_title', 'Packages — ' . $business->name)

@section('content')

    <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="d-flex align-items-center" style="gap: 12px;">
            <a href="{{ route('dashboard.businesses.dashboard', $business) }}" class="btn-dash-secondary btn-dash-sm">
                <i class="ti-arrow-left"></i> Back
            </a>
            <div>
                <h2 style="font-size: 18px; color: #1a1a2e; margin: 0;">Packages — {{ $business->name }}</h2>
                <p class="text-muted mb-0" style="margin-top: 2px;">Manage your tour/travel packages</p>
            </div>
        </div>
        <a href="{{ route('dashboard.businesses.packages.create', $business) }}" class="btn-dash-primary">
            <i class="ti-plus"></i> Add Package
        </a>
    </div>

    <div class="dash-card mb-3" style="padding: 14px 20px; background: #fff8e1; border-left: 4px solid #c8a96e;">
        <strong style="font-size: 13px;">Listing Types:</strong>
        <span class="text-muted" style="font-size: 13px;">
            &nbsp;<strong>Free</strong> — visible only on your business profile.
            &nbsp;<strong>Paid</strong> (Rs. 50/day) — also shown on the Package Discovery page and home feed as a sponsored post.
        </span>
    </div>

    @if($packages->isEmpty())
        <div class="dash-card" style="text-align: center; padding: 48px;">
            <i class="ti-package" style="font-size: 40px; color: #ccc;"></i>
            <p style="color: #888; margin-top: 12px;">No packages yet. Add your first package to attract more customers.</p>
            <a href="{{ route('dashboard.businesses.packages.create', $business) }}" class="btn-dash-primary">
                <i class="ti-plus"></i> Add Package
            </a>
        </div>
    @else
        <div class="dash-card" style="padding: 0;">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Package</th>
                        <th>Price</th>
                        <th>Duration</th>
                        <th>Listing</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($packages as $package)
                    <tr>
                        <td>
                            <div style="font-weight: 500; color: #1a1a2e;">{{ $package->name }}</div>
                            <div class="text-muted">{{ $package->duration }}</div>
                        </td>
                        <td>
                            <span style="font-weight: 600; color: #1a1a2e;">Rs. {{ number_format($package->price) }}</span>
                        </td>
                        <td>{{ $package->duration_days }} day{{ $package->duration_days > 1 ? 's' : '' }}</td>
                        <td>
                            @if($package->listing_type === 'paid')
                                @if($package->isSponsored())
                                    <span style="background:#d4edda;color:#155724;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;">
                                        Paid – Active
                                    </span>
                                    <div class="text-muted" style="font-size: 11px; margin-top: 2px;">
                                        Until {{ $package->paid_until->format('d M Y') }}
                                    </div>
                                @else
                                    <span style="background:#fff3cd;color:#856404;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;">
                                        Paid – Expired
                                    </span>
                                @endif
                            @else
                                <span style="background:#e9ecef;color:#495057;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;">
                                    Free
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($package->is_active)
                                <span class="badge-active">Active</span>
                            @else
                                <span class="badge-inactive">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex" style="gap: 8px;">
                                <a href="{{ route('packages.show', $package->slug) }}" target="_blank"
                                   class="btn-dash-secondary btn-dash-sm" title="View">
                                    <i class="ti-eye"></i>
                                </a>
                                <a href="{{ route('dashboard.businesses.packages.edit', [$business, $package]) }}"
                                   class="btn-dash-secondary btn-dash-sm">
                                    <i class="ti-pencil"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('dashboard.businesses.packages.destroy', [$business, $package]) }}"
                                      onsubmit="return confirm('Delete this package?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-dash-danger btn-dash-sm">
                                        <i class="ti-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($packages->hasPages())
        <div style="margin-top: 16px;">
            {{ $packages->links() }}
        </div>
        @endif
    @endif

@endsection
