@php
    $layout  = $section['columns_layout'] ?? '2';
    $columns = $section['columns'] ?? [];

    // Bootstrap col classes per column index for each layout
    $colMap = [
        '1'   => ['col-12'],
        '2'   => ['col-md-6', 'col-md-6'],
        '2-1' => ['col-md-8', 'col-md-4'],
        '1-2' => ['col-md-4', 'col-md-8'],
        '3'   => ['col-md-4', 'col-md-4', 'col-md-4'],
        '4'   => ['col-md-6 col-lg-3', 'col-md-6 col-lg-3', 'col-md-6 col-lg-3', 'col-md-6 col-lg-3'],
    ];
    $colClasses = $colMap[$layout] ?? ['col-md-6', 'col-md-6'];
@endphp

<section class="columns-section section-padding">
    <div class="container">

        @if($section['title'] ?? '')
            <div class="section-title text-center mb-50">
                <h2>{{ $section['title'] }}</h2>
            </div>
        @endif

        <div class="row g-4 align-items-start">
            @foreach($columns as $i => $col)
                @php
                    $colClass  = $colClasses[$i] ?? 'col-md-6';
                    $blockType = $col['block_type'] ?? '';
                @endphp
                <div class="{{ $colClass }}">

                    {{-- ══ CONTENT BLOCKS ══════════════════════════════════ --}}

                    @if($blockType === 'text')
                        {{-- Rich Text --}}
                        <div class="columns-block-text">
                            {!! $col['content'] ?? '' !!}
                        </div>

                    @elseif($blockType === 'image')
                        {{-- Image --}}
                        @if($col['image'] ?? '')
                            <div class="columns-block-image">
                                @if($col['link_url'] ?? '')<a href="{{ $col['link_url'] }}">@endif
                                <img src="{{ \App\Helpers\Cms::imageUrl($col['image']) }}"
                                     alt="{{ $col['caption'] ?? '' }}"
                                     class="img-fluid rounded w-100"
                                     style="object-fit: {{ $col['image_fit'] ?? 'contain' }};">
                                @if($col['link_url'] ?? '')</a>@endif
                                @if($col['caption'] ?? '')
                                    <p class="text-muted small mt-2 mb-0">{{ $col['caption'] }}</p>
                                @endif
                            </div>
                        @endif

                    @elseif($blockType === 'image_text')
                        {{-- Image + Text --}}
                        <div class="columns-block-image-text">
                            @if(($col['image_position'] ?? 'top') === 'top' && ($col['image'] ?? ''))
                                <img src="{{ \App\Helpers\Cms::imageUrl($col['image']) }}"
                                     alt="" class="img-fluid rounded w-100 mb-3">
                            @endif
                            @if($col['content'] ?? '')
                                <div class="content">{!! $col['content'] !!}</div>
                            @endif
                            @if(($col['image_position'] ?? 'top') === 'bottom' && ($col['image'] ?? ''))
                                <img src="{{ \App\Helpers\Cms::imageUrl($col['image']) }}"
                                     alt="" class="img-fluid rounded w-100 mt-3">
                            @endif
                            @if($col['button_text'] ?? '')
                                <a href="{{ $col['button_url'] ?? '#' }}" class="main-btn mt-3 d-inline-block">
                                    {{ $col['button_text'] }}
                                </a>
                            @endif
                        </div>

                    @elseif($blockType === 'icon_card')
                        {{-- Icon Card --}}
                        <div class="columns-block-icon-card">
                            @if($col['icon'] ?? '')
                                <div class="icon mb-3"><i class="{{ $col['icon'] }}"></i></div>
                            @endif
                            @if($col['heading'] ?? '')
                                <h4>{{ $col['heading'] }}</h4>
                            @endif
                            @if($col['description'] ?? '')
                                <p>{{ $col['description'] }}</p>
                            @endif
                            @if($col['button_text'] ?? '')
                                <a href="{{ $col['button_url'] ?? '#' }}" class="main-btn-sm d-inline-block mt-2">
                                    {{ $col['button_text'] }}
                                </a>
                            @endif
                        </div>

                    @elseif($blockType === 'button')
                        {{-- Button --}}
                        @php
                            $btnClass = match($col['button_style'] ?? 'primary') {
                                'secondary' => 'btn btn-secondary',
                                'outline'   => 'btn btn-outline-primary',
                                'ghost'     => 'btn btn-link p-0',
                                default     => 'main-btn',
                            };
                            $btnAlign = match($col['button_align'] ?? 'left') {
                                'center' => 'text-center',
                                'right'  => 'text-end',
                                default  => '',
                            };
                        @endphp
                        <div class="columns-block-button {{ $btnAlign }}">
                            <a href="{{ $col['button_url'] ?? '#' }}" class="{{ $btnClass }}">
                                {{ $col['button_text'] ?? 'Button' }}
                            </a>
                        </div>

                    @elseif($blockType === 'html')
                        {{-- Custom HTML --}}
                        <div class="columns-block-html">
                            {!! $col['html'] ?? '' !!}
                        </div>

                    {{-- ══ WIDGETS ═════════════════════════════════════════ --}}

                    @elseif($blockType === 'stat_counter')
                        {{-- Stat Counter --}}
                        @php
                            if (($col['counter_source'] ?? 'db') === 'custom') {
                                $ctr = [
                                    'value'  => $col['counter_value'] ?? '0',
                                    'suffix' => $col['counter_suffix'] ?? '',
                                    'label'  => $col['counter_label'] ?? '',
                                    'icon'   => $col['counter_icon'] ?? '',
                                ];
                            } else {
                                $cRec = \App\Models\Counter::find($col['counter_id'] ?? null);
                                $ctr  = $cRec ? [
                                    'value'  => $cRec->value,
                                    'suffix' => $cRec->suffix ?? '',
                                    'label'  => $cRec->label,
                                    'icon'   => $cRec->icon ?? '',
                                ] : null;
                            }
                        @endphp
                        @if(!empty($ctr))
                            <div class="counter-box-items text-center">
                                @if($ctr['icon'])
                                    <div class="icon mb-3"><i class="{{ $ctr['icon'] }}"></i></div>
                                @endif
                                <h2 class="odometer" data-count="{{ $ctr['value'] }}">0</h2>
                                @if($ctr['suffix'])<span class="suffix">{{ $ctr['suffix'] }}</span>@endif
                                <p>{{ $ctr['label'] }}</p>
                            </div>
                        @endif

                    @elseif($blockType === 'testimonial_card')
                        {{-- Testimonial Card --}}
                        @php
                            $t = isset($col['testimonial_id']) && $col['testimonial_id']
                                ? \App\Models\Testimonial::find($col['testimonial_id'])
                                : \App\Models\Testimonial::where('is_active', true)->inRandomOrder()->first();
                        @endphp
                        @if($t)
                            <div class="testimonial-card-single p-4 bg-white rounded shadow-sm h-100">
                                @if($t->rating)
                                    <div class="stars mb-3">
                                        @for($s = 0; $s < (int)$t->rating; $s++)
                                            <i class="fas fa-star text-warning"></i>
                                        @endfor
                                    </div>
                                @endif
                                <p class="mb-4 fst-italic">"{{ $t->content }}"</p>
                                <div class="d-flex align-items-center gap-3">
                                    @if($t->image)
                                        <img src="{{ \App\Helpers\Cms::imageUrl($t->image) }}"
                                             alt="{{ $t->name }}"
                                             class="rounded-circle flex-shrink-0"
                                             style="width:52px;height:52px;object-fit:cover;">
                                    @endif
                                    <div>
                                        <strong class="d-block">{{ $t->name }}</strong>
                                        @if($t->position || $t->company)
                                            <span class="text-muted small">
                                                {{ implode(', ', array_filter([$t->position, $t->company])) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                    @elseif($blockType === 'service_card')
                        {{-- Service Card --}}
                        @php $srv = \App\Models\Service::find($col['service_id'] ?? null); @endphp
                        @if($srv)
                            <div class="service-item-single p-4 bg-white rounded shadow-sm h-100">
                                @if($srv->image)
                                    <img src="{{ \App\Helpers\Cms::imageUrl($srv->image) }}"
                                         alt="{{ $srv->title }}" class="img-fluid rounded mb-3 w-100"
                                         style="max-height:180px;object-fit:cover;">
                                @elseif($srv->icon)
                                    <div class="icon mb-3"><i class="{{ $srv->icon }}"></i></div>
                                @endif
                                <h4>{{ $srv->title }}</h4>
                                @if($srv->excerpt)
                                    <p class="text-muted">{{ $srv->excerpt }}</p>
                                @endif
                                <a href="{{ route('services.show', $srv->slug) }}" class="main-btn-sm d-inline-block mt-2">
                                    Learn More
                                </a>
                            </div>
                        @endif

                    @elseif($blockType === 'team_card')
                        {{-- Team Member Card --}}
                        @php $member = \App\Models\TeamMember::find($col['team_member_id'] ?? null); @endphp
                        @if($member)
                            <div class="team-item-single text-center p-4 bg-white rounded shadow-sm h-100">
                                @if($member->image)
                                    <img src="{{ \App\Helpers\Cms::imageUrl($member->image) }}"
                                         alt="{{ $member->name }}"
                                         class="rounded-circle mb-3"
                                         style="width:88px;height:88px;object-fit:cover;">
                                @endif
                                <h5 class="mb-1">{{ $member->name }}</h5>
                                <p class="text-muted small mb-2">{{ $member->position }}</p>
                                @if(($col['card_style'] ?? '') === 'social')
                                    <div class="social-links d-flex justify-content-center gap-2 mt-2">
                                        @foreach(['facebook','twitter','linkedin','instagram','github'] as $net)
                                            @if($member->$net)
                                                <a href="{{ $member->$net }}" target="_blank" rel="noopener">
                                                    <i class="fab fa-{{ $net }}"></i>
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endif

                    @elseif($blockType === 'pricing_card')
                        {{-- Pricing Plan Card --}}
                        @php
                            $plan     = \App\Models\PricingPlan::find($col['pricing_plan_id'] ?? null);
                            $featured = (bool)($col['highlight'] ?? false);
                        @endphp
                        @if($plan)
                            <div class="pricing-item-single h-100 p-4 rounded {{ $featured ? 'active' : '' }}"
                                 style="{{ $featured && $plan->color ? 'border-color:' . $plan->color . ';' : '' }}">
                                @if($plan->badge)
                                    <span class="badge bg-primary mb-2">{{ $plan->badge }}</span>
                                @endif
                                <h4 class="mb-1">{{ $plan->name }}</h4>
                                <div class="price my-3">
                                    <span class="display-5 fw-bold">
                                        {{ $plan->currency_symbol ?? '$' }}{{ number_format($plan->price_monthly ?? 0) }}
                                    </span>
                                    <span class="text-muted">/mo</span>
                                </div>
                                @if($plan->description)
                                    <p class="mb-3">{{ $plan->description }}</p>
                                @endif
                                @if($plan->features)
                                    <ul class="list-unstyled mb-4">
                                        @foreach($plan->features as $feat)
                                            <li class="mb-2">
                                                <i class="fas fa-check text-success me-2"></i>
                                                {{ is_array($feat) ? ($feat['text'] ?? '') : $feat }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                                @if($plan->button_text)
                                    <a href="{{ $plan->button_url ?? '#' }}"
                                       class="{{ $featured ? 'main-btn' : 'main-btn border-btn' }} w-100 d-block text-center">
                                        {{ $plan->button_text }}
                                    </a>
                                @endif
                            </div>
                        @endif

                    @elseif($blockType === 'quote')
                        {{-- Blockquote --}}
                        @if($col['quote_style'] === 'large')
                            <blockquote class="columns-block-quote large text-center py-4">
                                <p class="display-6 fst-italic mb-3">"{{ $col['quote_text'] ?? '' }}"</p>
                                @if($col['quote_author'] ?? '')
                                    <cite class="text-muted">— {{ $col['quote_author'] }}</cite>
                                @endif
                            </blockquote>
                        @elseif(($col['quote_style'] ?? '') === 'minimal')
                            <blockquote class="columns-block-quote minimal border-start border-4 border-primary ps-4 py-2">
                                <p class="mb-1 fst-italic">{{ $col['quote_text'] ?? '' }}</p>
                                @if($col['quote_author'] ?? '')
                                    <cite class="text-muted small">— {{ $col['quote_author'] }}</cite>
                                @endif
                            </blockquote>
                        @else
                            <blockquote class="columns-block-quote default bg-light rounded p-4">
                                <i class="fas fa-quote-left text-primary mb-3 d-block fs-3"></i>
                                <p class="mb-2 fst-italic">{{ $col['quote_text'] ?? '' }}</p>
                                @if($col['quote_author'] ?? '')
                                    <cite class="text-muted small">— {{ $col['quote_author'] }}</cite>
                                @endif
                            </blockquote>
                        @endif

                    @elseif($blockType === 'alert')
                        {{-- Alert / Notice Box --}}
                        @php
                            $alertClass = match($col['alert_type'] ?? 'info') {
                                'success' => 'alert-success',
                                'warning' => 'alert-warning',
                                'error'   => 'alert-danger',
                                default   => 'alert-info',
                            };
                        @endphp
                        <div class="alert {{ $alertClass }} {{ ($col['dismissible'] ?? false) ? 'alert-dismissible fade show' : '' }}"
                             role="alert">
                            @if($col['alert_title'] ?? '')
                                <strong>{{ $col['alert_title'] }}</strong><br>
                            @endif
                            {{ $col['alert_message'] ?? '' }}
                            @if($col['dismissible'] ?? false)
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            @endif
                        </div>

                    @elseif($blockType === 'accordion')
                        {{-- Accordion --}}
                        @php $accordionId = 'acc-' . uniqid(); @endphp
                        <div class="accordion {{ ($col['accordion_style'] ?? '') === 'flush' ? 'accordion-flush' : '' }}"
                             id="{{ $accordionId }}">
                            @foreach($col['accordion_items'] ?? [] as $idx => $item)
                                @php
                                    $itemId  = $accordionId . '-' . $idx;
                                    $isOpen  = (bool)($item['open_by_default'] ?? false);
                                @endphp
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button {{ $isOpen ? '' : 'collapsed' }}"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#{{ $itemId }}"
                                                aria-expanded="{{ $isOpen ? 'true' : 'false' }}">
                                            {{ $item['question'] ?? '' }}
                                        </button>
                                    </h2>
                                    <div id="{{ $itemId }}"
                                         class="accordion-collapse collapse {{ $isOpen ? 'show' : '' }}"
                                         data-bs-parent="#{{ $accordionId }}">
                                        <div class="accordion-body">{{ $item['answer'] ?? '' }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    @elseif($blockType === 'icon_list')
                        {{-- Icon List --}}
                        @php
                            $listStyle  = $col['icon_list_style'] ?? 'check';
                            $listCols   = $col['icon_list_columns'] ?? '1';
                            $defaultIcon = match($listStyle) {
                                'check'  => 'fas fa-check-circle',
                                'bullet' => 'fas fa-circle',
                                default  => 'fas fa-check',
                            };
                        @endphp
                        <ul class="columns-block-icon-list list-unstyled {{ $listCols === '2' ? 'row row-cols-1 row-cols-sm-2 g-2' : '' }}">
                            @foreach($col['list_items'] ?? [] as $li)
                                <li class="{{ $listCols === '2' ? 'col' : 'mb-2' }} d-flex align-items-start gap-2">
                                    <i class="{{ $li['icon'] ?? $defaultIcon }} mt-1 flex-shrink-0 text-primary"></i>
                                    <div>
                                        <span>{{ $li['text'] ?? '' }}</span>
                                        @if($li['sub_text'] ?? '')
                                            <div class="text-muted small">{{ $li['sub_text'] }}</div>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                    {{-- ══ LAYOUT BLOCKS ════════════════════════════════════ --}}

                    @elseif($blockType === 'divider')
                        {{-- Divider --}}
                        @php
                            $dStyle  = $col['divider_style'] ?? 'solid';
                            $dWeight = $col['divider_weight'] ?? '1';
                            $dColor  = $col['divider_color'] ?: '#e5e7eb';
                            $dLabel  = $col['divider_label'] ?? '';
                        @endphp
                        @if($dLabel)
                            <div class="d-flex align-items-center gap-3 my-3">
                                <hr style="flex:1;margin:0;border-style:{{ $dStyle }};border-top-width:{{ $dWeight }}px;border-color:{{ $dColor }};">
                                <span class="text-muted small px-2 flex-shrink-0">{{ $dLabel }}</span>
                                <hr style="flex:1;margin:0;border-style:{{ $dStyle }};border-top-width:{{ $dWeight }}px;border-color:{{ $dColor }};">
                            </div>
                        @else
                            <hr style="border-style:{{ $dStyle }};border-top-width:{{ $dWeight }}px;border-color:{{ $dColor }};margin:12px 0;">
                        @endif

                    @elseif($blockType === 'spacer')
                        {{-- Spacer --}}
                        @php
                            $spacerH = match($col['spacer_size'] ?? 'md') {
                                'xs'    => '8px',
                                'sm'    => '16px',
                                'lg'    => '64px',
                                'xl'    => '96px',
                                default => '32px',
                            };
                        @endphp
                        <div style="height:{{ $spacerH }};"></div>

                    @endif
                </div>{{-- /.col --}}
            @endforeach
        </div>{{-- /.row --}}
    </div>{{-- /.container --}}
</section>
