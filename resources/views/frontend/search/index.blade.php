@extends('layouts.app')

@section('meta_title', ($search ? 'Search: '.e($search) : 'Search Results').' — Annapurna Region')
@section('meta_description', 'Search results for '.e($search).' on Annapurna Region.')

@php
$typeLabels = [
    'trekking'       => 'Trekking',
    'hotel'          => 'Hotels & Stays',
    'hotels'         => 'Hotels & Stays',
    'restaurant'     => 'Restaurants',
    'travel'         => 'Travel & Activities',
    'travel-agency'  => 'Travel & Activities',
    'vehicle'        => 'Vehicle Rentals',
    'destinations'   => 'Destinations',
];
$typeLabel = $typeLabels[$type] ?? ucfirst($type);

$typeIcons = [
    'trekking'      => 'ti-map-alt',
    'hotel'         => 'ti-home',
    'hotels'        => 'ti-home',
    'restaurant'    => 'ti-cup',
    'travel'        => 'ti-car',
    'travel-agency' => 'ti-car',
    'vehicle'       => 'ti-car',
    'destinations'  => 'ti-location-pin',
];
$typeIcon = $typeIcons[$type] ?? 'ti-search';
@endphp

@push('styles')
<style>
/* ===== SEARCH PAGE ===== */
.search-page { background: #f4f5f8; min-height: 80vh; padding-bottom: 60px; }

/* two-column layout */
.search-layout {
    display: flex;
    gap: 24px;
    align-items: flex-start;
    padding-top: 28px;
}

/* ── sidebar ── */
.search-sidebar {
    width: 280px;
    flex-shrink: 0;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 16px rgba(15,36,84,.07);
    position: sticky;
    top: 88px;
    overflow: hidden;
}
.ss-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px 12px;
    border-bottom: 1px solid #f0f0f0;
}
.ss-head h6 { margin:0; font-size:15px; font-weight:700; color:#0f2454; display:flex; align-items:center; gap:6px; }
.ss-reset { background:none; border:none; color:#2095AE; cursor:pointer; font-size:16px; padding:4px; }
.ss-reset:hover { color:#0f2454; }
.ss-body { padding: 16px 20px; }
.ss-group { margin-bottom: 22px; }
.ss-group:last-child { margin-bottom: 0; }
.ss-group-title { font-size:11px; font-weight:700; color:#0f2454; text-transform:uppercase; letter-spacing:.6px; margin-bottom:12px; }
.ss-type-btns { display:flex; flex-wrap:wrap; gap:6px; }
.ss-type-btn {
    padding: 5px 12px;
    border-radius: 20px;
    border: 1.5px solid #e2e6ea;
    background: #fff;
    color: #676977;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all .18s;
    text-decoration: none;
    display: inline-block;
}
.ss-type-btn:hover, .ss-type-btn.active { border-color:#2095AE; background:#2095AE; color:#fff; }
/* budget */
.budget-row { display:flex; justify-content:space-between; font-size:12px; color:#676977; margin-bottom:8px; }
.budget-row strong { color:#0f2454; }
input[type="range"].ss-range {
    -webkit-appearance:none; width:100%; height:4px; border-radius:2px; outline:none;
    background: linear-gradient(to right, #2095AE 0%, #2095AE 100%, #e2e6ea 100%, #e2e6ea 100%);
}
input[type="range"].ss-range::-webkit-slider-thumb {
    -webkit-appearance:none; width:16px; height:16px; border-radius:50%;
    background:#2095AE; border:2px solid #fff; box-shadow:0 2px 6px rgba(32,149,174,.35); cursor:pointer;
}
/* check items */
.ss-checks { display:flex; flex-direction:column; gap:9px; }
.ss-check { display:flex; align-items:center; gap:9px; cursor:pointer; font-size:13px; color:#555; }
.ss-check input[type="checkbox"] { width:15px; height:15px; accent-color:#2095AE; cursor:pointer; flex-shrink:0; }
.ss-check .star-ico { color:#e4a853; font-size:11px; letter-spacing:1px; }
.ss-apply {
    width:100%; padding:11px; border:none; border-radius:8px;
    background: linear-gradient(135deg, #0f2454 0%, #2095AE 100%);
    color:#fff; font-family:'Poppins',sans-serif; font-size:14px; font-weight:600;
    cursor:pointer; margin-top:20px; transition:opacity .2s;
}
.ss-apply:hover { opacity:.88; }

/* ── main content ── */
.search-main { flex:1; min-width:0; }
.search-topbar {
    display:flex; align-items:center; justify-content:space-between;
    background:#fff; border-radius:10px; padding:12px 18px;
    margin-bottom:20px; box-shadow:0 2px 8px rgba(15,36,84,.05);
    flex-wrap:wrap; gap:8px;
}
.search-topbar-left { font-size:13px; color:#676977; display:flex; align-items:center; gap:8px; }
.search-topbar-left strong { color:#0f2454; }
.search-topbar-left .s-badge {
    background:#e8f5f8; color:#2095AE; font-size:11px; font-weight:700;
    padding:3px 10px; border-radius:20px;
}
.search-topbar-right a { font-size:12px; color:#e74c3c; text-decoration:none; }

/* active filter chips */
.active-chips { display:flex; flex-wrap:wrap; gap:6px; margin-bottom:16px; }
.a-chip {
    display:inline-flex; align-items:center; gap:5px;
    padding:4px 10px; border-radius:20px;
    background:#e8f5f8; color:#2095AE; font-size:11px; font-weight:600;
}
.a-chip a { color:#2095AE; text-decoration:none; font-size:13px; line-height:1; }
.a-chip a:hover { color:#0f2454; }

/* card grid */
.search-grid {
    display:grid;
    grid-template-columns: repeat(3,1fr);
    gap:16px;
}
@media(max-width:1200px){ .search-grid{ grid-template-columns:repeat(3,1fr); } }
@media(max-width:900px) { .search-grid{ grid-template-columns:repeat(2,1fr); } }
@media(max-width:600px) {
    .search-layout{ flex-direction:column; }
    .search-sidebar{ width:100%; position:static; }
    .search-grid{ grid-template-columns:1fr; }
}
.s-card {
    background:#fff; border-radius:10px; overflow:hidden;
    box-shadow:0 2px 12px rgba(15,36,84,.07);
    transition:transform .2s,box-shadow .2s;
    display:flex; flex-direction:column;
}
.s-card:hover { transform:translateY(-4px); box-shadow:0 8px 24px rgba(15,36,84,.13); }
.s-card-img { position:relative; height:160px; overflow:hidden; }
.s-card-img img { width:100%; height:100%; object-fit:cover; transition:transform .4s; }
.s-card:hover .s-card-img img { transform:scale(1.06); }
.s-type-badge {
    position:absolute; top:10px; right:10px;
    background:rgba(15,36,84,.82); color:#fff;
    font-size:9px; font-weight:700; padding:3px 8px;
    border-radius:4px; letter-spacing:.8px; text-transform:uppercase;
}
.s-verified {
    position:absolute; top:10px; left:10px;
    background:#198754; color:#fff;
    font-size:9px; font-weight:700; padding:3px 8px; border-radius:4px;
}
.s-card-body { padding:12px 14px 14px; flex:1; display:flex; flex-direction:column; gap:6px; }
.s-card-name { font-size:13px; font-weight:700; color:#0f2454; line-height:1.3; }
.s-card-name a { color:inherit; text-decoration:none; }
.s-card-name a:hover { color:#2095AE; }
.s-card-loc { font-size:11px; color:#888; display:-webkit-box; -webkit-line-clamp:1; -webkit-box-orient:vertical; overflow:hidden; }
.s-card-loc i { color:#2095AE; margin-right:3px; }
.s-card-meta { font-size:11px; color:#888; display:flex; gap:10px; flex-wrap:wrap; }
.s-card-meta span { display:flex; align-items:center; gap:3px; }
.s-card-footer {
    display:flex; align-items:flex-end; justify-content:space-between;
    margin-top:auto; padding-top:8px; border-top:1px solid #f4f5f8;
}
.s-card-rating { display:flex; align-items:center; gap:4px; font-size:12px; font-weight:600; color:#198754; }
.s-card-price { text-align:right; }
.s-card-price small { display:block; font-size:10px; color:#999; }
.s-card-price strong { font-size:13px; font-weight:700; color:#0f2454; }

/* empty */
.search-empty { text-align:center; padding:80px 20px; color:#676977; }
.search-empty i { font-size:48px; color:#cdd; display:block; margin-bottom:16px; }

/* pagination */
.search-pages { margin-top:28px; }
</style>
@endpush

@section('content')

<x-breadcrumb
    title="{{ $search ? 'Search: '.e($search) : $typeLabel }}"
    subtitle="Annapurna Region">
    <li class="breadcrumb-item"><a href="{{ route('search') }}">Search</a></li>
    <li class="breadcrumb-item active">{{ $search ?: $typeLabel }}</li>
</x-breadcrumb>

<div class="search-page">
    <div class="container">
        <div class="search-layout">

            {{-- ===== SIDEBAR ===== --}}
            <aside class="search-sidebar">
                <div class="ss-head">
                    <h6><i class="ti-filter"></i> Filters</h6>
                    <button class="ss-reset" title="Reset all filters" onclick="window.location='{{ route('search') }}'"><i class="ti-reload"></i></button>
                </div>
                <form method="GET" action="{{ route('search') }}" id="searchFilterForm">

                    <div class="ss-body">

                        {{-- Type --}}
                        <div class="ss-group">
                            <div class="ss-group-title">Search In</div>
                            <div class="ss-type-btns">
                                @foreach(['trekking'=>'Trekking','hotel'=>'Hotels','restaurant'=>'Restaurants','travel'=>'Travel & Activities','destinations'=>'Destinations','vehicle'=>'Vehicle Rentals'] as $t => $lbl)
                                <a href="{{ route('search', array_merge(request()->except('type','page'),['type'=>$t])) }}"
                                   class="ss-type-btn {{ $type === $t ? 'active' : '' }}">{{ $lbl }}</a>
                                @endforeach
                            </div>
                        </div>

                        {{-- Keyword --}}
                        <div class="ss-group">
                            <div class="ss-group-title">Keyword</div>
                            <input type="hidden" name="type" value="{{ $type }}">
                            <input type="text" name="search" value="{{ $search }}"
                                placeholder="Search..." class="form-control" style="border-radius:6px;font-size:13px;padding:8px 12px;border:1.5px solid #e2e6ea;">
                        </div>

                        {{-- Budget --}}
                        <div class="ss-group">
                            <div class="ss-group-title">Budget (NPR)</div>
                            <div class="budget-row">
                                <span>NPR 0</span>
                                <strong id="ssBudgetVal">NPR {{ number_format($budgetMax ?: 50000) }}</strong>
                            </div>
                            <input type="range" class="ss-range" id="ssBudgetRange" name="budget_max"
                                min="0" max="50000" step="500"
                                value="{{ $budgetMax ?: 50000 }}">
                        </div>

                        {{-- Star Rating --}}
                        <div class="ss-group">
                            <div class="ss-group-title">Star Rating</div>
                            <div class="ss-checks">
                                @foreach([5,4,3,2,1] as $s)
                                <label class="ss-check">
                                    <input type="checkbox" name="star[]" value="{{ $s }}" {{ in_array($s,$stars)?'checked':'' }}>
                                    <span class="star-ico">@for($i=0;$i<$s;$i++)★@endfor</span>
                                    <span>{{ $s }} Star</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Category --}}
                        <div class="ss-group">
                            <div class="ss-group-title">Category</div>
                            <div class="ss-checks">
                                @foreach(['luxury'=>'Luxury','standard'=>'Standard','budget'=>'Budget','eco-friendly'=>'Eco Friendly','community-based'=>'Community Based','premium'=>'Premium'] as $val=>$lbl)
                                <label class="ss-check">
                                    <input type="checkbox" name="category[]" value="{{ $val }}" {{ in_array($val,$cats)?'checked':'' }}>
                                    {{ $lbl }}
                                </label>
                                @endforeach
                            </div>
                        </div>

                    </div>

                    <div style="padding:0 20px 20px;">
                        <button type="submit" class="ss-apply">Show Results</button>
                    </div>
                </form>
            </aside>

            {{-- ===== MAIN ===== --}}
            <div class="search-main">

                {{-- Top bar --}}
                <div class="search-topbar">
                    <div class="search-topbar-left">
                        <span class="s-badge"><i class="{{ $typeIcon }}"></i> {{ $typeLabel }}</span>
                        @if($search)
                        <span>Results for <strong>"{{ $search }}"</strong></span>
                        @else
                        <span>All <strong>{{ $typeLabel }}</strong></span>
                        @endif
                        <span>&nbsp;·&nbsp; {{ $total }} result{{ $total !== 1 ? 's' : '' }}</span>
                    </div>
                    <div class="search-topbar-right">
                        @if(request()->except('type'))
                        <a href="{{ route('search', ['type'=>$type]) }}"><i class="ti-close"></i> Clear filters</a>
                        @endif
                    </div>
                </div>

                {{-- Active chips --}}
                @if($search || $budgetMax < 50000 || count($stars) || count($cats))
                <div class="active-chips">
                    @if($search)
                    <span class="a-chip">
                        "{{ $search }}"
                        <a href="{{ route('search', array_merge(request()->except('search','page'))) }}">&times;</a>
                    </span>
                    @endif
                    @if($budgetMax && $budgetMax < 50000)
                    <span class="a-chip">
                        Budget ≤ NPR {{ number_format($budgetMax) }}
                        <a href="{{ route('search', array_merge(request()->except('budget_max','page'))) }}">&times;</a>
                    </span>
                    @endif
                    @foreach($stars as $s)<span class="a-chip">{{ $s }} Star</span>@endforeach
                    @foreach($cats as $c)<span class="a-chip">{{ ucwords(str_replace('-',' ',$c)) }}</span>@endforeach
                </div>
                @endif

                {{-- Results grid --}}
                @if($results->count())
                <div class="search-grid">
                    @foreach($results as $item)
                    @php
                        if ($resultType === 'trek') {
                            $name    = $item->name;
                            $url     = route('trek-routes.show', $item->slug);
                            $img     = $item->featured_image
                                ? (str_starts_with($item->featured_image,'annapurna/') ? asset($item->featured_image) : \App\Helpers\Cms::imageUrl($item->featured_image))
                                : asset('annapurna/img/tours/annapurna-circuit.jpg');
                            $loc     = $item->start_point ?? 'Nepal';
                            $price   = $item->price_range ?? 'On Request';
                            $meta    = ($item->duration_days ? $item->duration_days.' Days' : '').($item->difficulty ? ' · '.$item->difficulty : '');
                            $verified= $item->is_featured ?? false;
                        } elseif ($resultType === 'destination') {
                            $name    = $item->name;
                            $url     = route('destinations.show', $item->slug);
                            $img     = $item->featured_image ? \App\Helpers\Cms::imageUrl($item->featured_image) : asset('annapurna/img/destination/pokhara-city-tours.png');
                            $loc     = $item->region ?? 'Annapurna Region, Nepal';
                            $price   = 'On Request';
                            $meta    = $item->best_season ? 'Best Season: '.$item->best_season : '';
                            $verified= $item->is_featured ?? false;
                        } else {
                            $name    = $item->name;
                            $url     = ($item->type === 'hotel') ? route('hotels.show', $item->slug) : route('businesses.show', $item->slug);
                            $img     = $item->cover_photo ? \App\Helpers\Cms::imageUrl($item->cover_photo) : asset('annapurna/img/hotels/hotel-kantipur-annapurna-region.jpg');
                            $loc     = $item->address ?? 'Nepal';
                            $price   = $item->min_price ? 'NPR '.number_format($item->min_price) : 'On Request';
                            $meta    = '';
                            $verified= $item->is_verified ?? false;
                        }
                    @endphp
                    <div class="s-card">
                        <div class="s-card-img">
                            <a href="{{ $url }}">
                                <img src="{{ $img }}" alt="{{ $name }}" loading="lazy">
                            </a>
                            <span class="s-type-badge">{{ $cardType }}</span>
                            @if($verified)<span class="s-verified">✓ Verified</span>@endif
                        </div>
                        <div class="s-card-body">
                            <div class="s-card-name"><a href="{{ $url }}">{{ $name }}</a></div>
                            <div class="s-card-loc"><i class="ti-location-pin"></i>{{ $loc }}</div>
                            @if($meta)<div class="s-card-meta"><span>{{ $meta }}</span></div>@endif
                            <div class="s-card-footer">
                                <div class="s-card-rating"><i class="ti-star"></i><span>N/A</span></div>
                                <div class="s-card-price">
                                    <small>Starting From</small>
                                    <strong>{{ $price }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="search-empty">
                    <i class="{{ $typeIcon }}"></i>
                    <h5>No results found</h5>
                    <p>Try a different keyword or <a href="{{ route('search',['type'=>$type]) }}" style="color:#2095AE;">clear filters</a>.</p>
                </div>
                @endif

                {{-- Pagination --}}
                @if($results instanceof \Illuminate\Pagination\LengthAwarePaginator && $results->hasPages())
                <div class="search-pages">
                    {{ $results->appends(request()->query())->links('vendor.pagination.annapurna') }}
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
    var $r = $('#ssBudgetRange');
    $r.on('input', function () {
        var v = parseInt($(this).val());
        $('#ssBudgetVal').text('NPR ' + v.toLocaleString());
        var pct = ((v/50000)*100)+'%';
        this.style.background = 'linear-gradient(to right,#2095AE 0%,#2095AE '+pct+',#e2e6ea '+pct+',#e2e6ea 100%)';
    }).trigger('input');
});
</script>
@endpush
