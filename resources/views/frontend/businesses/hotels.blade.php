@extends('layouts.app')

@section('meta_title', \App\Helpers\Cms::setting('hotels_meta_title', 'Hotels in Annapurna Region, Nepal'))
@section('meta_description', \App\Helpers\Cms::setting('hotels_meta_description', 'Discover the best hotels in Pokhara and the Annapurna region.'))

@push('styles')
<style>
/* ===== LISTING PAGE ===== */
.listing-page { background: #f4f5f8; min-height: 80vh; }

/* layout */
.listing-wrap {
    display: flex;
    gap: 24px;
    align-items: flex-start;
    padding: 32px 0 60px;
}

/* sidebar */
.listing-sidebar {
    width: 280px;
    flex-shrink: 0;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 16px rgba(15,36,84,.07);
    position: sticky;
    top: 90px;
    overflow: hidden;
}
.sidebar-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px 12px;
    border-bottom: 1px solid #f0f0f0;
}
.sidebar-head h6 {
    margin: 0;
    font-size: 15px;
    font-weight: 700;
    color: #0f2454;
    display: flex;
    align-items: center;
    gap: 6px;
}
.sidebar-reset-btn {
    background: none;
    border: none;
    color: #2095AE;
    cursor: pointer;
    font-size: 16px;
    padding: 4px;
    line-height: 1;
}
.sidebar-reset-btn:hover { color: #0f2454; }
.sidebar-body { padding: 16px 20px; }
.s-group { margin-bottom: 22px; }
.s-group:last-child { margin-bottom: 0; }
.s-group-title {
    font-size: 11px;
    font-weight: 700;
    color: #0f2454;
    text-transform: uppercase;
    letter-spacing: .6px;
    margin-bottom: 12px;
}
/* budget */
.budget-val-row { display: flex; justify-content: space-between; font-size: 12px; color: #676977; margin-bottom: 8px; }
.budget-max-val { font-weight: 600; color: #0f2454; }
input[type="range"].s-range {
    -webkit-appearance: none;
    width: 100%;
    height: 4px;
    border-radius: 2px;
    outline: none;
    background: linear-gradient(to right, #2095AE 0%, #2095AE 50%, #e2e6ea 50%, #e2e6ea 100%);
}
input[type="range"].s-range::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 16px; height: 16px;
    border-radius: 50%;
    background: #2095AE;
    border: 2px solid #fff;
    box-shadow: 0 2px 6px rgba(32,149,174,.35);
    cursor: pointer;
}
/* check items */
.s-check-list { display: flex; flex-direction: column; gap: 9px; }
.s-check-item { display: flex; align-items: center; gap: 9px; cursor: pointer; font-size: 13px; color: #555; }
.s-check-item input[type="checkbox"] { width: 15px; height: 15px; accent-color: #2095AE; cursor: pointer; flex-shrink: 0; }
.s-check-item .star-icons { color: #e4a853; font-size: 11px; letter-spacing: 1px; }
.sidebar-apply-btn {
    width: 100%;
    padding: 11px;
    border: none;
    border-radius: 8px;
    background: linear-gradient(135deg, #0f2454 0%, #2095AE 100%);
    color: #fff;
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    margin-top: 20px;
    transition: opacity .2s;
}
.sidebar-apply-btn:hover { opacity: .88; }

/* main content */
.listing-main { flex: 1; min-width: 0; }

/* top bar */
.listing-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #fff;
    border-radius: 10px;
    padding: 12px 18px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(15,36,84,.05);
    flex-wrap: wrap;
    gap: 8px;
}
.listing-topbar-left {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    color: #676977;
}
.listing-topbar-left .dot { color: #2095AE; }
.listing-topbar-left strong { color: #0f2454; }
.listing-topbar-right { font-size: 12px; color: #676977; }

/* active filter chips */
.active-filters { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 16px; }
.filter-chip {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 20px;
    background: #e8f5f8;
    color: #2095AE;
    font-size: 11px;
    font-weight: 600;
    text-decoration: none;
}
.filter-chip a { color: #2095AE; text-decoration: none; font-size: 13px; line-height: 1; }
.filter-chip a:hover { color: #0f2454; }

/* grid */
.listing-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
}
@media (max-width: 1200px) { .listing-grid { grid-template-columns: repeat(3,1fr); } }
@media (max-width: 900px)  { .listing-grid { grid-template-columns: repeat(2,1fr); } }
@media (max-width: 600px)  {
    .listing-wrap { flex-direction: column; }
    .listing-sidebar { width: 100%; position: static; }
    .listing-grid { grid-template-columns: 1fr; }
}

/* card */
.l-card {
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(15,36,84,.07);
    transition: transform .2s, box-shadow .2s;
    display: flex;
    flex-direction: column;
}
.l-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(15,36,84,.13); }
.l-card-img {
    position: relative;
    height: 160px;
    overflow: hidden;
}
.l-card-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
.l-card:hover .l-card-img img { transform: scale(1.06); }
.l-type-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(15,36,84,.85);
    color: #fff;
    font-size: 9px;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 4px;
    letter-spacing: .8px;
    text-transform: uppercase;
}
.l-verified-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background: #198754;
    color: #fff;
    font-size: 9px;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 4px;
}
.l-card-body { padding: 12px 14px 14px; flex: 1; display: flex; flex-direction: column; gap: 6px; }
.l-card-name {
    font-size: 13px;
    font-weight: 700;
    color: #0f2454;
    line-height: 1.3;
}
.l-card-name a { color: inherit; text-decoration: none; }
.l-card-name a:hover { color: #2095AE; }
.l-card-loc {
    font-size: 11px;
    color: #888;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.l-card-loc i { color: #2095AE; margin-right: 3px; }
.l-card-footer {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-top: auto;
    padding-top: 8px;
    border-top: 1px solid #f4f5f8;
}
.l-card-rating {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 12px;
    font-weight: 600;
    color: #198754;
}
.l-card-rating i { font-size: 11px; }
.l-card-price { text-align: right; }
.l-card-price small { display: block; font-size: 10px; color: #999; }
.l-card-price strong { font-size: 13px; font-weight: 700; color: #0f2454; }

/* empty state */
.listing-empty {
    text-align: center;
    padding: 80px 20px;
    color: #676977;
}
.listing-empty i { font-size: 48px; color: #cdd; display: block; margin-bottom: 16px; }

/* pagination */
.listing-pagination { margin-top: 28px; }
</style>
@endpush

@section('content')

{{-- Banner --}}
<div class="banner-header section-padding back-position-center valign bg-img bg-fixed"
     data-overlay-dark="5"
     data-background="{{ asset('annapurna/img/slider/pokhara-valley-tour.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-md-9 text-left caption mt-90">
                <h5>{{ \App\Helpers\Cms::setting('hotels_banner_subtitle', 'Hotels in Nepal') }}</h5>
                <h1>{{ \App\Helpers\Cms::setting('hotels_banner_title', 'Best Hotels in Pokhara, Nepal') }}</h1>
            </div>
        </div>
    </div>
</div>

<div class="listing-page">
    <div class="container">
        <div class="listing-wrap">

            {{-- ===== SIDEBAR ===== --}}
            <aside class="listing-sidebar">
                <div class="sidebar-head">
                    <h6><i class="ti-filter"></i> Filters</h6>
                    <button class="sidebar-reset-btn" id="sidebarReset" title="Reset"><i class="ti-reload"></i></button>
                </div>
                <form method="GET" action="{{ route('hotels.index') }}" id="filterForm">
                    <div class="sidebar-body">

                        {{-- Budget --}}
                        <div class="s-group">
                            <div class="s-group-title">Your Budget (NPR)</div>
                            <div class="budget-val-row">
                                <span>NPR 0</span>
                                <span class="budget-max-val" id="sBudgetVal">
                                    NPR {{ number_format(request()->get('budget_max', 50000)) }}
                                </span>
                            </div>
                            <input type="range" class="s-range" id="sBudgetRange" name="budget_max"
                                min="0" max="50000" step="500"
                                value="{{ request()->get('budget_max', 50000) }}">
                        </div>

                        {{-- Star Rating --}}
                        <div class="s-group">
                            <div class="s-group-title">Star Rating</div>
                            <div class="s-check-list">
                                @foreach([5,4,3,2,1] as $star)
                                <label class="s-check-item">
                                    <input type="checkbox" name="star[]" value="{{ $star }}"
                                        {{ in_array($star, (array)request()->get('star', [])) ? 'checked' : '' }}>
                                    <span class="star-icons">@for($s=0;$s<$star;$s++)★@endfor</span>
                                    <span>{{ $star }} Star</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Type --}}
                        <div class="s-group">
                            <div class="s-group-title">Type</div>
                            <div class="s-check-list">
                                @foreach(['hotel'=>'Hotel','apartment'=>'Apartment','villa'=>'Villa','homestay'=>'Homestay','resort'=>'Resort','boutique'=>'Boutique'] as $val => $label)
                                <label class="s-check-item">
                                    <input type="checkbox" name="subtype[]" value="{{ $val }}"
                                        {{ in_array($val, (array)request()->get('subtype', [])) ? 'checked' : '' }}>
                                    {{ $label }}
                                </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Category --}}
                        <div class="s-group">
                            <div class="s-group-title">Category</div>
                            <div class="s-check-list">
                                @foreach(['luxury'=>'Luxury','standard'=>'Standard','budget'=>'Budget','eco-friendly'=>'Eco Friendly','community-based'=>'Community Based','premium'=>'Premium'] as $val => $label)
                                <label class="s-check-item">
                                    <input type="checkbox" name="category[]" value="{{ $val }}"
                                        {{ in_array($val, (array)request()->get('category', [])) ? 'checked' : '' }}>
                                    {{ $label }}
                                </label>
                                @endforeach
                            </div>
                        </div>

                    </div>
                    <div style="padding: 0 20px 20px;">
                        <button type="submit" class="sidebar-apply-btn">Show Results</button>
                    </div>
                </form>
            </aside>

            {{-- ===== MAIN CONTENT ===== --}}
            <div class="listing-main">

                {{-- Top bar --}}
                <div class="listing-topbar">
                    <div class="listing-topbar-left">
                        <span class="dot"><i class="ti-location-pin"></i></span>
                        <span>
                            <strong>All properties</strong>
                            &nbsp;·&nbsp;
                            {{ $businesses->total() }} result{{ $businesses->total() !== 1 ? 's' : '' }}
                        </span>
                    </div>
                    <div class="listing-topbar-right">
                        @if(request()->hasAny(['budget_max','star','subtype','category']))
                        <a href="{{ route('hotels.index') }}" style="color:#e74c3c;font-size:12px;text-decoration:none;">
                            <i class="ti-close"></i> Clear all filters
                        </a>
                        @endif
                    </div>
                </div>

                {{-- Active filter chips --}}
                @if(request()->hasAny(['star','subtype','category']) || request()->get('budget_max') < 50000)
                <div class="active-filters">
                    @if(request()->get('budget_max') && request()->get('budget_max') < 50000)
                    <span class="filter-chip">
                        Budget ≤ NPR {{ number_format(request()->get('budget_max')) }}
                        <a href="{{ request()->fullUrlWithQuery(['budget_max' => null]) }}">&times;</a>
                    </span>
                    @endif
                    @foreach((array)request()->get('star',[]) as $s)
                    <span class="filter-chip">{{ $s }} Star</span>
                    @endforeach
                    @foreach((array)request()->get('subtype',[]) as $t)
                    <span class="filter-chip">{{ ucfirst($t) }}</span>
                    @endforeach
                    @foreach((array)request()->get('category',[]) as $c)
                    <span class="filter-chip">{{ ucwords(str_replace('-',' ',$c)) }}</span>
                    @endforeach
                </div>
                @endif

                {{-- Grid --}}
                @if($businesses->count())
                <div class="listing-grid">
                    @foreach($businesses as $business)
                    @php
                        $img = $business->cover_photo
                            ? \App\Helpers\Cms::imageUrl($business->cover_photo)
                            : asset('annapurna/img/hotels/hotel-kantipur-annapurna-region.jpg');
                        $minPrice = $business->min_price;
                    @endphp
                    <div class="l-card">
                        <div class="l-card-img">
                            <a href="{{ route('hotels.show', $business->slug) }}">
                                <img src="{{ $img }}" alt="{{ $business->name }}" loading="lazy">
                            </a>
                            <span class="l-type-badge">{{ strtoupper($business->type) }}</span>
                            @if($business->is_verified)
                            <span class="l-verified-badge">✓ Verified</span>
                            @endif
                        </div>
                        <div class="l-card-body">
                            <div class="l-card-name">
                                <a href="{{ route('hotels.show', $business->slug) }}">{{ $business->name }}</a>
                            </div>
                            <div class="l-card-loc">
                                <i class="ti-location-pin"></i>
                                {{ $business->address ?? 'Nepal' }}
                            </div>
                            <div class="l-card-footer">
                                <div class="l-card-rating">
                                    <i class="ti-star"></i>
                                    <span>N/A</span>
                                </div>
                                <div class="l-card-price">
                                    <small>Starting From</small>
                                    <strong>{{ $minPrice ? 'NPR '.number_format($minPrice) : 'On Request' }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="listing-empty">
                    <i class="ti-home"></i>
                    <h5>No hotels found</h5>
                    <p>Try adjusting your filters or <a href="{{ route('hotels.index') }}">clear all filters</a>.</p>
                </div>
                @endif

                {{-- Pagination --}}
                @if($businesses->hasPages())
                <div class="listing-pagination">
                    {{ $businesses->appends(request()->query())->links('vendor.pagination.annapurna') }}
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function () {
    // Budget slider live label
    var $range = $('#sBudgetRange');
    $range.on('input', function () {
        var v = parseInt($(this).val());
        $('#sBudgetVal').text('NPR ' + v.toLocaleString());
        var pct = ((v / 50000) * 100) + '%';
        this.style.background = 'linear-gradient(to right, #2095AE 0%, #2095AE ' + pct + ', #e2e6ea ' + pct + ', #e2e6ea 100%)';
    }).trigger('input');

    // Reset all filters
    $('#sidebarReset').on('click', function () {
        window.location.href = '{{ route("hotels.index") }}';
    });
});
</script>
@endpush
