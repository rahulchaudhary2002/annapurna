@extends('layouts.dashboard')

@section('page_title', 'Edit Package — ' . $package->name)

@section('content')

    <div class="d-flex align-items-center mb-3" style="gap: 12px;">
        <a href="{{ route('dashboard.businesses.packages.index', $business) }}" class="btn-dash-secondary btn-dash-sm">
            <i class="ti-arrow-left"></i> Back
        </a>
        <h2 style="font-size: 18px; color: #1a1a2e; margin: 0;">Edit Package — {{ $package->name }}</h2>
    </div>

    @if($errors->any())
    <div class="dash-alert dash-alert-error">
        <ul style="margin: 0; padding-left: 18px;">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('dashboard.businesses.packages.update', [$business, $package]) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Basic Info --}}
        <div class="dash-card">
            <h3 class="dash-card-title">Basic Information</h3>

            <div class="dash-row">
                <div class="dash-col-6">
                    <div class="dash-form-group">
                        <label>Package Name <span style="color:#e74c3c">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $package->name) }}"
                               class="dash-form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="dash-col-6">
                    <div class="dash-form-group">
                        <label>Price (Rs.) <span style="color:#e74c3c">*</span></label>
                        <input type="number" name="price" value="{{ old('price', $package->price) }}"
                               class="dash-form-control {{ $errors->has('price') ? 'is-invalid' : '' }}"
                               min="0" step="0.01" required>
                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="dash-col-6">
                    <div class="dash-form-group">
                        <label>Duration Label <span style="color:#e74c3c">*</span></label>
                        <input type="text" name="duration" value="{{ old('duration', $package->duration) }}"
                               class="dash-form-control {{ $errors->has('duration') ? 'is-invalid' : '' }}" required>
                        @error('duration')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="dash-col-6">
                    <div class="dash-form-group">
                        <label>Duration (days) <span style="color:#e74c3c">*</span></label>
                        <input type="number" name="duration_days" value="{{ old('duration_days', $package->duration_days) }}"
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
                <label>Package Highlights <small class="text-muted">— one per line</small></label>
                <textarea name="highlights" class="dash-form-control" rows="6">{{ old('highlights', $package->highlights ? implode("\n", $package->highlights) : '') }}</textarea>
            </div>
        </div>

        {{-- Itinerary --}}
        <div class="dash-card">
            <h3 class="dash-card-title">Full Itinerary</h3>
            <p class="text-muted mb-2" style="font-size: 13px;">Each day block separated by a blank line. First line = title, rest = description.</p>
            <div class="dash-form-group">
                @php
                    $itineraryText = '';
                    if ($package->itinerary) {
                        $itineraryText = collect($package->itinerary)->map(fn($day) =>
                            trim(($day['title'] ?? '') . "\n" . ($day['description'] ?? ''))
                        )->implode("\n\n");
                    }
                @endphp
                <textarea name="itinerary" class="dash-form-control" rows="14">{{ old('itinerary', $itineraryText) }}</textarea>
            </div>
        </div>

        {{-- Photos & Video --}}
        <div class="dash-card">
            <h3 class="dash-card-title">Photos &amp; Video</h3>

            @if($package->photos && count($package->photos) > 0)
            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 16px;">
                @foreach($package->photos as $photo)
                <div style="position: relative;">
                    <img src="{{ asset('storage/' . $photo) }}" alt=""
                         style="width: 100px; height: 70px; object-fit: cover; border-radius: 4px; border: 1px solid #eee;">
                </div>
                @endforeach
            </div>
            <p class="text-muted" style="font-size: 12px; margin-bottom: 12px;">
                Uploading new photos will replace the existing ones.
            </p>
            @endif

            <div class="dash-form-group">
                <label>Upload New Photos <small class="text-muted">(optional — replaces existing)</small></label>
                <input type="file" name="photos[]" multiple accept="image/*" class="dash-form-control">
            </div>
            <div class="dash-form-group mb-0">
                <label>Video URL <small class="text-muted">(optional)</small></label>
                <input type="url" name="video_url" value="{{ old('video_url', $package->video_url) }}"
                       class="dash-form-control" placeholder="https://www.youtube.com/embed/...">
            </div>
        </div>

        {{-- FAQs --}}
        <div class="dash-card">
            <h3 class="dash-card-title">FAQs</h3>
            <p class="text-muted mb-2" style="font-size: 13px;">Each FAQ block separated by a blank line. First line = question, rest = answer.</p>
            <div class="dash-form-group">
                @php
                    $faqText = '';
                    if ($package->faqs) {
                        $faqText = collect($package->faqs)->map(fn($faq) =>
                            trim(($faq['question'] ?? '') . "\n" . ($faq['answer'] ?? ''))
                        )->implode("\n\n");
                    }
                @endphp
                <textarea name="faqs" class="dash-form-control" rows="10">{{ old('faqs', $faqText) }}</textarea>
            </div>
        </div>

        {{-- Map --}}
        <div class="dash-card">
            <h3 class="dash-card-title">Map</h3>
            <div class="dash-form-group mb-0">
                <label>Google Maps Embed Code <small class="text-muted">(optional)</small></label>
                <textarea name="map_embed" class="dash-form-control" rows="3">{{ old('map_embed', $package->map_embed) }}</textarea>
            </div>
        </div>

        {{-- Listing Type --}}
        <div class="dash-card">
            <h3 class="dash-card-title">Listing Type</h3>

            <div class="dash-form-group">
                <label>Listing Type <span style="color:#e74c3c">*</span></label>
                <select name="listing_type" id="listingType" class="dash-form-control" required>
                    <option value="free" {{ old('listing_type', $package->listing_type) === 'free' ? 'selected' : '' }}>
                        Free — visible on your business profile only
                    </option>
                    <option value="paid" {{ old('listing_type', $package->listing_type) === 'paid' ? 'selected' : '' }}>
                        Paid — also featured on discovery page &amp; home feed
                    </option>
                </select>
            </div>

            <div id="paidFields" style="{{ old('listing_type', $package->listing_type) === 'paid' ? '' : 'display:none' }}">
                <div class="dash-row">
                    <div class="dash-col-4">
                        <div class="dash-form-group">
                            <label>Promote From</label>
                            <input type="date" name="paid_from"
                                   value="{{ old('paid_from', $package->paid_from?->format('Y-m-d')) }}"
                                   class="dash-form-control {{ $errors->has('paid_from') ? 'is-invalid' : '' }}">
                            @error('paid_from')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="dash-col-4">
                        <div class="dash-form-group">
                            <label>Promote Until</label>
                            <input type="date" name="paid_until"
                                   value="{{ old('paid_until', $package->paid_until?->format('Y-m-d')) }}"
                                   class="dash-form-control {{ $errors->has('paid_until') ? 'is-invalid' : '' }}">
                            @error('paid_until')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="dash-col-4">
                        <div class="dash-form-group">
                            <label>Daily Rate (Rs.)</label>
                            <input type="number" name="daily_rate"
                                   value="{{ old('daily_rate', $package->daily_rate ?? 50) }}"
                                   class="dash-form-control" min="0" step="0.01">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SEO & Status --}}
        <div class="dash-card">
            <h3 class="dash-card-title">SEO &amp; Status</h3>
            <div class="dash-form-group">
                <label>Meta Title</label>
                <input type="text" name="meta_title" value="{{ old('meta_title', $package->meta_title) }}"
                       class="dash-form-control">
            </div>
            <div class="dash-form-group">
                <label>Meta Description</label>
                <textarea name="meta_description" class="dash-form-control" rows="2">{{ old('meta_description', $package->meta_description) }}</textarea>
            </div>
            <div class="dash-form-group mb-0">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1"
                           {{ old('is_active', $package->is_active ? '1' : '0') == '1' ? 'checked' : '' }}
                           style="width: auto;">
                    Active (visible to the public)
                </label>
            </div>
        </div>

        <div style="display: flex; gap: 12px; margin-top: 4px;">
            <button type="submit" class="btn-dash-primary">
                <i class="ti-check"></i> Update Package
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
