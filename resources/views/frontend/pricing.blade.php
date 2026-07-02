@extends('layouts.app')

@section('meta_title', \App\Helpers\Cms::setting('pricing_meta_title', 'Pricing - ' . \App\Helpers\Cms::siteName()))
@section('meta_description', \App\Helpers\Cms::setting('pricing_meta_description', ''))

@section('content')

@include('partials.breadcrumb', ['title' => 'Pricing Plans'])

<section class="pricing-section section-padding fix">
    <div class="container">
        {{-- Toggle Monthly/Yearly --}}
        @if($plans->where('price_yearly', '>', 0)->count())
        <div class="pricing-toggle text-center mb-5">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-primary active" data-period="monthly">Monthly</button>
                <button type="button" class="btn btn-outline-primary" data-period="yearly">Yearly <span class="badge bg-success ms-1">Save 20%</span></button>
            </div>
        </div>
        @endif

        <div class="row justify-content-center">
            @foreach($plans as $plan)
            <div class="col-xl-4 col-lg-4 col-md-6 mb-4 wow fadeInUp" data-wow-delay=".2s">
                <div class="pricing-box-items {{ $plan->is_featured ? 'featured' : '' }}" @if($plan->color) style="border-color: {{ $plan->color }}" @endif>
                    @if($plan->badge)
                        <div class="pricing-badge">{{ $plan->badge }}</div>
                    @endif

                    <div class="pricing-header">
                        <h4>{{ $plan->name }}</h4>
                        @if($plan->description)
                            <p>{{ $plan->description }}</p>
                        @endif
                    </div>

                    <div class="pricing-price">
                        <div class="monthly-price">
                            <span class="currency">{{ $plan->currency_symbol }}</span>
                            <span class="amount">{{ number_format($plan->price_monthly, 0) }}</span>
                            <span class="period">/month</span>
                        </div>
                        @if($plan->price_yearly > 0)
                        <div class="yearly-price d-none">
                            <span class="currency">{{ $plan->currency_symbol }}</span>
                            <span class="amount">{{ number_format($plan->price_yearly, 0) }}</span>
                            <span class="period">/year</span>
                        </div>
                        @endif
                    </div>

                    @if($plan->features && count($plan->features))
                    <ul class="pricing-features list-unstyled">
                        @foreach($plan->features as $feature)
                        <li class="{{ ($feature['included'] ?? true) ? 'included' : 'excluded' }}">
                            <i class="fas {{ ($feature['included'] ?? true) ? 'fa-check text-success' : 'fa-times text-muted' }} me-2"></i>
                            {{ $feature['text'] ?? $feature }}
                        </li>
                        @endforeach
                    </ul>
                    @endif

                    <div class="pricing-footer">
                        <a href="{{ $plan->button_url ?: route('contact') }}" class="theme-btn w-100 text-center {{ !$plan->is_featured ? 'theme-btn-outline' : '' }}">
                            {{ $plan->button_text ?: 'Get Started' }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- FAQ for pricing --}}
        @if($faqs->count())
        <div class="pricing-faq mt-5 pt-5">
            <h3 class="text-center mb-4">Frequently Asked Questions</h3>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion" id="pricingFaq">
                        @foreach($faqs as $i => $faq)
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button {{ $i > 0 ? 'collapsed' : '' }}" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#pfaq{{ $faq->id }}">
                                    {{ $faq->question }}
                                </button>
                            </h2>
                            <div id="pfaq{{ $faq->id }}" class="accordion-collapse collapse {{ $i === 0 ? 'show' : '' }}"
                                 data-bs-parent="#pricingFaq">
                                <div class="accordion-body">{!! $faq->answer !!}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
document.querySelectorAll('[data-period]').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('[data-period]').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        const period = this.dataset.period;
        document.querySelectorAll('.monthly-price').forEach(el => el.classList.toggle('d-none', period === 'yearly'));
        document.querySelectorAll('.yearly-price').forEach(el => el.classList.toggle('d-none', period === 'monthly'));
    });
});
</script>
@endpush

@endsection
