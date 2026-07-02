@extends('layouts.dashboard')

@section('page_title', 'Edit Business')

@section('content')

    <div class="d-flex align-items-center mb-3" style="gap: 12px;">
        <a href="{{ route('dashboard.businesses.index') }}" class="btn-dash-secondary btn-dash-sm">
            <i class="ti-arrow-left"></i> Back
        </a>
        <div>
            <h2 style="font-size: 18px; color: #1a1a2e; margin: 0;">Edit: {{ $business->name }}</h2>
        </div>
    </div>

    @if($errors->any())
    <div class="dash-alert dash-alert-error">
        <ul style="margin: 0; padding-left: 18px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('dashboard.businesses.update', $business) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="dash-row">
            {{-- Basic Info --}}
            <div class="dash-col-6">
                <div class="dash-card">
                    <h3 class="dash-card-title">Basic Information</h3>

                    <div class="dash-form-group">
                        <label>Business Name <span style="color: #e74c3c;">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $business->name) }}"
                               class="dash-form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                               required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="dash-form-group">
                        <label>Business Type <span style="color: #e74c3c;">*</span></label>
                        <select name="type" class="dash-form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" required>
                            <option value="">-- Select Type --</option>
                            <option value="hotel" {{ old('type', $business->type) == 'hotel' ? 'selected' : '' }}>Hotel / Lodge</option>
                            <option value="restaurant" {{ old('type', $business->type) == 'restaurant' ? 'selected' : '' }}>Restaurant / Cafe</option>
                            <option value="travel_agency" {{ old('type', $business->type) == 'travel_agency' ? 'selected' : '' }}>Travel Agency</option>
                            <option value="guide" {{ old('type', $business->type) == 'guide' ? 'selected' : '' }}>Trekking Guide</option>
                            <option value="porter" {{ old('type', $business->type) == 'porter' ? 'selected' : '' }}>Porter Service</option>
                        </select>
                        @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="dash-form-group">
                        <label>Short Description</label>
                        <input type="text" name="short_description" value="{{ old('short_description', $business->short_description) }}"
                               class="dash-form-control {{ $errors->has('short_description') ? 'is-invalid' : '' }}"
                               placeholder="Brief one-line description">
                        @error('short_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="dash-form-group">
                        <label>Full Description</label>
                        <textarea name="description" class="dash-form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                                  rows="5">{{ old('description', $business->description) }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Contact Info --}}
                <div class="dash-card">
                    <h3 class="dash-card-title">Contact Information</h3>

                    <div class="dash-form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $business->phone) }}"
                               class="dash-form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="dash-form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $business->email) }}"
                               class="dash-form-control {{ $errors->has('email') ? 'is-invalid' : '' }}">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="dash-form-group">
                        <label>Website</label>
                        <input type="url" name="website" value="{{ old('website', $business->website) }}"
                               class="dash-form-control {{ $errors->has('website') ? 'is-invalid' : '' }}">
                        @error('website') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="dash-form-group">
                        <label>Address</label>
                        <input type="text" name="address" value="{{ old('address', $business->address) }}"
                               class="dash-form-control {{ $errors->has('address') ? 'is-invalid' : '' }}">
                        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="dash-form-group">
                        <label>Opening Hours</label>
                        <input type="text" name="opening_hours" value="{{ old('opening_hours', $business->opening_hours) }}"
                               class="dash-form-control {{ $errors->has('opening_hours') ? 'is-invalid' : '' }}"
                               placeholder="e.g. Mon-Fri: 8am-8pm">
                        @error('opening_hours') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            {{-- Media & Map --}}
            <div class="dash-col-6">
                <div class="dash-card">
                    <h3 class="dash-card-title">Photos</h3>

                    @if($business->cover_photo)
                    <div style="margin-bottom: 12px;">
                        <img src="{{ asset('storage/' . $business->cover_photo) }}" alt="Cover"
                             style="width: 100%; height: 140px; object-fit: cover; border-radius: 5px;">
                        <small class="text-muted">Current cover photo. Upload a new one to replace.</small>
                    </div>
                    @endif

                    <div class="dash-form-group">
                        <label>Cover Photo</label>
                        <input type="file" name="cover_photo" accept="image/*"
                               class="dash-form-control {{ $errors->has('cover_photo') ? 'is-invalid' : '' }}">
                        <small class="text-muted">Recommended: 1200x600px. Max 4MB.</small>
                        @error('cover_photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    @if($business->logo)
                    <div style="margin-bottom: 12px;">
                        <img src="{{ asset('storage/' . $business->logo) }}" alt="Logo"
                             style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px; border: 1px solid #eee;">
                        <small class="text-muted" style="display: block;">Current logo.</small>
                    </div>
                    @endif

                    <div class="dash-form-group">
                        <label>Logo</label>
                        <input type="file" name="logo" accept="image/*"
                               class="dash-form-control {{ $errors->has('logo') ? 'is-invalid' : '' }}">
                        <small class="text-muted">Square format recommended. Max 2MB.</small>
                        @error('logo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="dash-card">
                    <h3 class="dash-card-title">Map Location</h3>
                    <p class="text-muted" style="font-size: 13px; margin-bottom: 16px;">
                        Paste your Google Maps embed code below.
                    </p>

                    <div class="dash-form-group">
                        <label>Google Maps Embed Code</label>
                        <textarea name="map_embed" class="dash-form-control"
                                  rows="4" placeholder='&lt;iframe src="https://www.google.com/maps/embed?..." ...&gt;&lt;/iframe&gt;'>{{ old('map_embed', $business->map_embed) }}</textarea>
                    </div>
                </div>

                <div class="dash-card">
                    <button type="submit" class="btn-dash-primary" style="width: 100%; padding: 14px; font-size: 15px;">
                        <i class="ti-save"></i> Save Changes
                    </button>
                    <a href="{{ route('dashboard.businesses.dashboard', $business) }}"
                       class="btn-dash-secondary" style="display: block; text-align: center; margin-top: 12px; padding: 12px;">
                        View Dashboard
                    </a>
                </div>
            </div>
        </div>

    </form>

@endsection
