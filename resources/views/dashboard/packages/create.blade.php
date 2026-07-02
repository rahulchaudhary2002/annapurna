@extends('layouts.dashboard')

@section('page_title', 'Add Package — ' . $business->name)

@section('content')

    <div class="d-flex align-items-center mb-3" style="gap: 12px;">
        <a href="{{ route('dashboard.businesses.packages.index', $business) }}" class="btn-dash-secondary btn-dash-sm">
            <i class="ti-arrow-left"></i> Back
        </a>
        <h2 style="font-size: 18px; color: #1a1a2e; margin: 0;">Add Package — {{ $business->name }}</h2>
    </div>

    @if($errors->any())
    <div class="dash-alert dash-alert-error">
        <ul style="margin: 0; padding-left: 18px;">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('dashboard.businesses.packages.store', $business) }}" enctype="multipart/form-data">
        @csrf

        {{-- Basic Info --}}
        <div class="dash-card">
            <h3 class="dash-card-title">Basic Information</h3>

            <div class="dash-row">
                <div class="dash-col-6">
                    <div class="dash-form-group">
                        <label>Package Name <span style="color:#e74c3c">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="dash-form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                               placeholder="e.g. Annapurna Circuit 12-Day Package" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="dash-col-6">
                    <div class="dash-form-group">
                        <label>Price (Rs.) <span style="color:#e74c3c">*</span></label>
                        <input type="number" name="price" value="{{ old('price') }}"
                               class="dash-form-control {{ $errors->has('price') ? 'is-invalid' : '' }}"
                               placeholder="e.g. 45000" min="0" step="0.01" required>
                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="dash-col-6">
                    <div class="dash-form-group">
                        <label>Duration Label <span style="color:#e74c3c">*</span></label>
                        <input type="text" name="duration" value="{{ old('duration') }}"
                               class="dash-form-control {{ $errors->has('duration') ? 'is-invalid' : '' }}"
                               placeholder="e.g. 12 Days / 11 Nights" required>
                        @error('duration')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="dash-col-6">
                    <div class="dash-form-group">
                        <label>Duration (days, for sorting) <span style="color:#e74c3c">*</span></label>
                        <input type="number" name="duration_days" value="{{ old('duration_days', 1) }}"
                               class="dash-form-control {{ $errors->has('duration_days') ? 'is-invalid' : '' }}"
                               min="1" required>
                        @error('duration_days')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Highlights --}}
        <div class="dash-card">
            <h3 class="dash-card-title">Highlights</h3>
            <div class="dash-form-group">
                <label>Package Highlights <small class="text-muted">— one highlight per line</small></label>
                <textarea name="highlights" class="dash-form-control {{ $errors->has('highlights') ? 'is-invalid' : '' }}"
                          rows="6" placeholder="Sunrise view from Poon Hill&#10;Annapurna Base Camp (4130m)&#10;Hot spring at Jhinu Danda&#10;Local Gurung culture experience">{{ old('highlights') }}</textarea>
                @error('highlights')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- Itinerary --}}
        <div class="dash-card">
            <h3 class="dash-card-title">Full Itinerary</h3>
            <p class="text-muted mb-2" style="font-size: 13px;">
                Enter each day as a block separated by a blank line. First line = day title, remaining lines = description.
            </p>
            <div class="dash-form-group">
                <textarea name="itinerary" class="dash-form-control {{ $errors->has('itinerary') ? 'is-invalid' : '' }}"
                          rows="14" placeholder="Arrival in Pokhara&#10;Transfer to hotel, rest and acclimatization. Trek briefing in the evening.&#10;&#10;Pokhara to Nayapul to Ghorepani&#10;Drive to Nayapul (1 hour), then trek 5-6 hours to Ghorepani (2860m).">{{ old('itinerary') }}</textarea>
                @error('itinerary')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- Photos & Video --}}
        <div class="dash-card">
            <h3 class="dash-card-title">Photos &amp; Video</h3>
            <div class="dash-form-group">
                <label>Photos <small class="text-muted">— up to 10 images, max 5MB each</small></label>
                <input type="file" name="photos[]" multiple accept="image/*"
                       class="dash-form-control {{ $errors->has('photos.*') ? 'is-invalid' : '' }}">
                @error('photos.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="dash-form-group mb-0">
                <label>Video URL <small class="text-muted">— YouTube or Vimeo embed link (optional)</small></label>
                <input type="url" name="video_url" value="{{ old('video_url') }}"
                       class="dash-form-control {{ $errors->has('video_url') ? 'is-invalid' : '' }}"
                       placeholder="https://www.youtube.com/embed/...">
                @error('video_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- FAQs --}}
        <div class="dash-card">
            <h3 class="dash-card-title">FAQs</h3>
            <p class="text-muted mb-2" style="font-size: 13px;">
                Each FAQ block separated by a blank line. First line = question, remaining = answer.
            </p>
            <div class="dash-form-group">
                <textarea name="faqs" class="dash-form-control {{ $errors->has('faqs') ? 'is-invalid' : '' }}"
                          rows="10" placeholder="What is the best season for this trek?&#10;The best seasons are spring (March–May) and autumn (September–November).&#10;&#10;Is altitude sickness a concern?&#10;Altitudes above 3000m require acclimatization. Our guides are trained for this.">{{ old('faqs') }}</textarea>
                @error('faqs')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- Map --}}
        <div class="dash-card">
            <h3 class="dash-card-title">Map</h3>
            <div class="dash-form-group mb-0">
                <label>Google Maps Embed Code <small class="text-muted">(optional)</small></label>
                <textarea name="map_embed" class="dash-form-control {{ $errors->has('map_embed') ? 'is-invalid' : '' }}"
                          rows="3" placeholder='&lt;iframe src="https://maps.google.com/..." ...&gt;&lt;/iframe&gt;'>{{ old('map_embed') }}</textarea>
                @error('map_embed')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- Listing Type --}}
        <div class="dash-card">
            <h3 class="dash-card-title">Listing Type</h3>

            <div class="dash-form-group">
                <label>Listing Type <span style="color:#e74c3c">*</span></label>
                <select name="listing_type" id="listingType" class="dash-form-control" required>
                    <option value="free" {{ old('listing_type', 'free') === 'free' ? 'selected' : '' }}>
                        Free — visible on your business profile only
                    </option>
                    <option value="paid" {{ old('listing_type') === 'paid' ? 'selected' : '' }}>
                        Paid — also featured on discovery page &amp; home feed
                    </option>
                </select>
            </div>

            <div id="paidFields" style="{{ old('listing_type') === 'paid' ? '' : 'display:none' }}">
                <div class="dash-row">
                    <div class="dash-col-4">
                        <div class="dash-form-group">
                            <label>Promote From</label>
                            <input type="date" name="paid_from" value="{{ old('paid_from') }}"
                                   class="dash-form-control {{ $errors->has('paid_from') ? 'is-invalid' : '' }}">
                            @error('paid_from')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="dash-col-4">
                        <div class="dash-form-group">
                            <label>Promote Until</label>
                            <input type="date" name="paid_until" value="{{ old('paid_until') }}"
                                   class="dash-form-control {{ $errors->has('paid_until') ? 'is-invalid' : '' }}">
                            @error('paid_until')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="dash-col-4">
                        <div class="dash-form-group">
                            <label>Daily Rate (Rs.)</label>
                            <input type="number" name="daily_rate" value="{{ old('daily_rate', 50) }}"
                                   class="dash-form-control {{ $errors->has('daily_rate') ? 'is-invalid' : '' }}"
                                   min="0" step="0.01">
                            @error('daily_rate')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SEO & Status --}}
        <div class="dash-card">
            <h3 class="dash-card-title">SEO &amp; Status</h3>
            <div class="dash-form-group">
                <label>Meta Title <small class="text-muted">(optional — defaults to package name)</small></label>
                <input type="text" name="meta_title" value="{{ old('meta_title') }}"
                       class="dash-form-control" placeholder="SEO page title">
            </div>
            <div class="dash-form-group">
                <label>Meta Description <small class="text-muted">(optional)</small></label>
                <textarea name="meta_description" class="dash-form-control" rows="2"
                          placeholder="Short description for search engines">{{ old('meta_description') }}</textarea>
            </div>
            <div class="dash-form-group mb-0">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1"
                           {{ old('is_active', '1') == '1' ? 'checked' : '' }}
                           style="width: auto;">
                    Active (visible to the public)
                </label>
            </div>
        </div>

        <div style="display: flex; gap: 12px; margin-top: 4px;">
            <button type="submit" class="btn-dash-primary">
                <i class="ti-check"></i> Save Package
            </button>
            <a href="{{ route('dashboard.businesses.packages.index', $business) }}" class="btn-dash-secondary">
                Cancel
            </a>
        </div>

    </form>

@endsection

@push('scripts')
<script>
    document.getElementById('listingType').addEventListener('change', function () {
        document.getElementById('paidFields').style.display = this.value === 'paid' ? '' : 'none';
    });
</script>
@endpush
