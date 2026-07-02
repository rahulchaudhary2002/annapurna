@extends('layouts.dashboard')

@section('page_title', 'My Businesses')

@section('content')

    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h2 style="font-size: 18px; color: #1a1a2e; margin: 0 0 4px;">My Businesses</h2>
            <p class="text-muted">Manage your business listings.</p>
        </div>
        <a href="{{ route('dashboard.businesses.create') }}" class="btn-dash-primary">
            <i class="ti-plus"></i> Add Business
        </a>
    </div>

    <div class="dash-card">
        @if($businesses->count() > 0)
        <table class="dash-table">
            <thead>
                <tr>
                    <th>Business</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($businesses as $business)
                <tr>
                    <td>
                        <div style="font-weight: 500;">{{ $business->name }}</div>
                        @if($business->address)
                        <div class="text-muted text-small">{{ Str::limit($business->address, 50) }}</div>
                        @endif
                    </td>
                    <td>
                        <span style="background: #f0f0f0; padding: 3px 10px; border-radius: 20px; font-size: 12px; font-weight: 500; text-transform: capitalize;">
                            {{ ucfirst(str_replace('_', ' ', $business->type)) }}
                        </span>
                    </td>
                    <td>
                        <span class="{{ $business->is_active ? 'badge-active' : 'badge-inactive' }}">
                            {{ $business->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="text-muted text-small">{{ $business->created_at->format('M j, Y') }}</td>
                    <td>
                        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                            <a href="{{ route('dashboard.businesses.dashboard', $business) }}"
                               class="btn-dash-primary btn-dash-sm">Dashboard</a>
                            <a href="{{ route('dashboard.businesses.edit', $business) }}"
                               class="btn-dash-secondary btn-dash-sm">Edit</a>
                            <form method="POST" action="{{ route('dashboard.businesses.destroy', $business) }}"
                                  onsubmit="return confirm('Are you sure you want to delete {{ addslashes($business->name) }}?');"
                                  style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-dash-danger btn-dash-sm">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if($businesses->hasPages())
        <div style="margin-top: 20px;">
            {{ $businesses->links() }}
        </div>
        @endif

        @else
        <div style="text-align: center; padding: 48px 0; color: #888;">
            <i class="ti-briefcase" style="font-size: 48px; opacity: 0.3; display: block; margin-bottom: 16px;"></i>
            <h4 style="font-size: 16px; color: #555;">No businesses yet</h4>
            <p style="font-size: 14px;">Add your hotel, restaurant, or travel agency to get discovered.</p>
            <a href="{{ route('dashboard.businesses.create') }}" class="btn-dash-primary">
                <i class="ti-plus"></i> Add Your First Business
            </a>
        </div>
        @endif
    </div>

@endsection
