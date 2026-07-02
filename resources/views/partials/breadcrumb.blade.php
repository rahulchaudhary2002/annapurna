@props(['title' => '', 'subtitle' => '', 'background' => 'annapurna/img/slider/pokhara-valley-tour.jpg'])

<div class="banner-header section-padding back-position-center valign bg-img bg-fixed"
     data-overlay-dark="5"
     data-background="{{ asset($background) }}">
    <div class="container">
        <div class="row">
            <div class="col-md-9 text-left caption mt-90">
                @if($subtitle)
                    <h6>{{ $subtitle }}</h6>
                @endif
                <h1>{{ $title }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        @if(isset($slot) && $slot->isNotEmpty())
                            {{ $slot }}
                        @else
                            <li class="breadcrumb-item active">{{ $title }}</li>
                        @endif
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
