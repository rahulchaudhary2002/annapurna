@extends('layouts.dashboard')

@section('page_title', 'My Profile')

@section('content')

    <div class="dash-row">
        {{-- Profile Info --}}
        <div class="dash-col-6">
            <div class="dash-card">
                <h3 class="dash-card-title">Profile Information</h3>

                @if($errors->hasBag('profile') || (!$errors->hasBag('password') && $errors->any()))
                <div class="dash-alert dash-alert-error">
                    <ul style="margin: 0; padding-left: 18px;">
                        @foreach(($errors->hasBag('profile') ? $errors->getBag('profile') : $errors)->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('dashboard.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Avatar --}}
                    <div class="dash-form-group" style="text-align: center; margin-bottom: 24px;">
                        <div style="margin-bottom: 12px;">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}"
                                     style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #c8a96e;">
                            @else
                                <div style="width: 80px; height: 80px; border-radius: 50%; background: #c8a96e; display: inline-flex; align-items: center; justify-content: center; font-size: 28px; color: #fff; font-weight: 700;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <label class="btn-dash-secondary btn-dash-sm" style="cursor: pointer; display: inline-block;">
                            <i class="ti-upload"></i> Upload Photo
                            <input type="file" name="avatar" accept="image/*" style="display: none;">
                        </label>
                        <div class="text-muted text-small" style="margin-top: 6px;">Max 2MB. JPG, PNG, GIF.</div>
                        @error('avatar') <div class="invalid-feedback" style="display:block;">{{ $message }}</div> @enderror
                    </div>

                    <div class="dash-form-group">
                        <label>Full Name <span style="color: #e74c3c;">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                               class="dash-form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                               required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="dash-form-group">
                        <label>Email Address</label>
                        <input type="email" value="{{ $user->email }}"
                               class="dash-form-control" readonly
                               style="background: #f8f8f8; color: #888;">
                        <small class="text-muted">Email cannot be changed.</small>
                    </div>

                    <div class="dash-form-group">
                        <label>Country</label>
                        <input type="text" name="country" value="{{ old('country', $user->country) }}"
                               class="dash-form-control {{ $errors->has('country') ? 'is-invalid' : '' }}"
                               placeholder="e.g. Nepal">
                        @error('country') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="dash-form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                               class="dash-form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                               placeholder="+977 98XXXXXXXX">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="dash-form-group">
                        <label>Bio</label>
                        <textarea name="bio" class="dash-form-control {{ $errors->has('bio') ? 'is-invalid' : '' }}"
                                  rows="4" placeholder="Tell us about yourself...">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn-dash-primary">Save Changes</button>
                </form>
            </div>
        </div>

        {{-- Change Password --}}
        <div class="dash-col-6">
            <div class="dash-card">
                <h3 class="dash-card-title">Change Password</h3>

                @if($errors->hasBag('password'))
                <div class="dash-alert dash-alert-error">
                    <ul style="margin: 0; padding-left: 18px;">
                        @foreach($errors->getBag('password')->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('dashboard.profile.password') }}">
                    @csrf
                    @method('PUT')

                    <div class="dash-form-group">
                        <label>Current Password</label>
                        <input type="password" name="current_password"
                               class="dash-form-control {{ $errors->hasBag('password') && $errors->getBag('password')->has('current_password') ? 'is-invalid' : '' }}"
                               required>
                        @if($errors->hasBag('password') && $errors->getBag('password')->has('current_password'))
                            <div class="invalid-feedback">{{ $errors->getBag('password')->first('current_password') }}</div>
                        @endif
                    </div>

                    <div class="dash-form-group">
                        <label>New Password</label>
                        <input type="password" name="password"
                               class="dash-form-control {{ $errors->hasBag('password') && $errors->getBag('password')->has('password') ? 'is-invalid' : '' }}"
                               placeholder="Minimum 8 characters"
                               required>
                        @if($errors->hasBag('password') && $errors->getBag('password')->has('password'))
                            <div class="invalid-feedback">{{ $errors->getBag('password')->first('password') }}</div>
                        @endif
                    </div>

                    <div class="dash-form-group">
                        <label>Confirm New Password</label>
                        <input type="password" name="password_confirmation"
                               class="dash-form-control"
                               placeholder="Repeat new password"
                               required>
                    </div>

                    <button type="submit" class="btn-dash-primary">Update Password</button>
                </form>
            </div>

            {{-- Account Info --}}
            <div class="dash-card">
                <h3 class="dash-card-title">Account Info</h3>
                <table class="dash-table">
                    <tr>
                        <td class="text-muted" style="width: 40%;">Member since</td>
                        <td>{{ $user->created_at->format('M j, Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Email status</td>
                        <td>
                            @if($user->hasVerifiedEmail())
                                <span class="badge-active">Verified</span>
                            @else
                                <span class="badge-inactive">Not Verified</span>
                                <a href="{{ route('verification.notice') }}" style="font-size: 12px; color: #c8a96e; margin-left: 8px;">Verify now</a>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

@endsection
