<div class="item" style="{{ $featured ? 'border: 2px solid #c8a96e; border-radius: 4px;' : '' }}">
    <a href="{{ route('packages.show', $package->slug) }}">
        <div class="position-re o-hidden">
            @if(!empty($package->photos))
                <img src="{{ asset('storage/' . $package->photos[0]) }}" alt="{{ $package->name }}">
            @elseif($package->business->cover_photo)
                <img src="{{ \App\Helpers\Cms::imageUrl($package->business->cover_photo) }}" alt="{{ $package->name }}">
            @else
                <img src="{{ asset('annapurna/img/tours/annapurna-circuit.jpg') }}" alt="{{ $package->name }}">
            @endif
        </div>
    </a>

    @if($featured || $package->isSponsored())
    <span class="category" style="background: #c8a96e;">
        <span>Sponsored</span>
    </span>
    @else
    <span class="category">
        <a href="{{ route('businesses.show', $package->business->slug) }}">{{ $package->business->name }}</a>
    </span>
    @endif

    <div class="con">
        <h5><a href="{{ route('packages.show', $package->slug) }}">{{ $package->name }}</a></h5>

        <div class="line"></div>

        <div class="row facilities">
            <div class="col col-md-12">
                <ul>
                    <li><i class="ti-time"></i> {{ $package->duration }}</li>
                    <li><i class="ti-money"></i> Rs. {{ number_format($package->price) }}</li>
                    @if($package->business->address)
                    <li><i class="ti-location-pin"></i> {{ Str::limit($package->business->address, 35) }}</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
