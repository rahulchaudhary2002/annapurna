@extends('layouts.dashboard')

@section('page_title', $business->name . ' — Team Members')

@section('content')

    <div class="d-flex align-items-center mb-3" style="gap: 12px;">
        <a href="{{ route('dashboard.businesses.dashboard', $business) }}" class="btn-dash-secondary btn-dash-sm">
            <i class="ti-arrow-left"></i> Back
        </a>
        <div>
            <h2 style="font-size: 18px; color: #1a1a2e; margin: 0;">Team Members — {{ $business->name }}</h2>
        </div>
    </div>

    <div class="dash-row">
        {{-- Members List --}}
        <div class="dash-col-6">
            <div class="dash-card">
                <h3 class="dash-card-title">Current Members</h3>

                @if($members->count() > 0)
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Role</th>
                            @if($business->user_id === auth()->id())
                            <th>Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members as $member)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 34px; height: 34px; border-radius: 50%; background: #c8a96e; display: flex; align-items: center; justify-content: center; font-size: 13px; color: #fff; font-weight: 700; flex-shrink: 0; overflow: hidden;">
                                        @if($member->user?->avatar)
                                            <img src="{{ asset('storage/' . $member->user->avatar) }}" style="width:100%;height:100%;object-fit:cover;">
                                        @else
                                            {{ strtoupper(substr($member->user?->name ?? '?', 0, 1)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <div style="font-weight: 500; font-size: 13px;">{{ $member->user?->name }}</div>
                                        <div class="text-muted text-small">{{ $member->user?->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($business->user_id === auth()->id() && $member->user_id !== auth()->id())
                                <form method="POST" action="{{ route('dashboard.businesses.members.update', [$business, $member]) }}"
                                      style="display: flex; gap: 6px; align-items: center;">
                                    @csrf
                                    @method('PUT')
                                    <select name="role" class="dash-form-control" style="padding: 5px 10px; font-size: 12px; width: auto;">
                                        <option value="owner" {{ $member->role == 'owner' ? 'selected' : '' }}>Owner</option>
                                        <option value="manager" {{ $member->role == 'manager' ? 'selected' : '' }}>Manager</option>
                                        <option value="staff" {{ $member->role == 'staff' ? 'selected' : '' }}>Staff</option>
                                    </select>
                                    <button type="submit" class="btn-dash-secondary btn-dash-sm">Save</button>
                                </form>
                                @else
                                    <span class="badge-{{ $member->role }}">{{ ucfirst($member->role) }}</span>
                                @endif
                            </td>
                            @if($business->user_id === auth()->id())
                            <td>
                                @if($member->user_id !== auth()->id())
                                <form method="POST" action="{{ route('dashboard.businesses.members.destroy', [$business, $member]) }}"
                                      onsubmit="return confirm('Remove this member?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-dash-danger btn-dash-sm">Remove</button>
                                </form>
                                @else
                                <span class="text-muted text-small">You</span>
                                @endif
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-muted">No team members yet.</p>
                @endif
            </div>
        </div>

        {{-- Add Member Form (Owner only) --}}
        @if($business->user_id === auth()->id())
        <div class="dash-col-6">
            <div class="dash-card">
                <h3 class="dash-card-title">Add Team Member</h3>
                <p class="text-muted" style="font-size: 13px; margin-bottom: 20px;">
                    The person must already have an account. Enter their email to add them.
                </p>

                @if($errors->any())
                <div class="dash-alert dash-alert-error">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
                @endif

                <form method="POST" action="{{ route('dashboard.businesses.members.store', $business) }}">
                    @csrf

                    <div class="dash-form-group">
                        <label>Email Address <span style="color: #e74c3c;">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="dash-form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                               placeholder="member@email.com" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="dash-form-group">
                        <label>Role <span style="color: #e74c3c;">*</span></label>
                        <select name="role" class="dash-form-control {{ $errors->has('role') ? 'is-invalid' : '' }}" required>
                            <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                            <option value="staff" {{ old('role', 'staff') == 'staff' ? 'selected' : '' }}>Staff</option>
                        </select>
                        @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn-dash-primary">Add Member</button>
                </form>
            </div>
        </div>
        @endif
    </div>

@endsection
