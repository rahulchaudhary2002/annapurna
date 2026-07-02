@php
    $siteName = \App\Helpers\Cms::siteName();
    $siteLogo = \App\Helpers\Cms::siteLogo();
    $mainMenu = \App\Helpers\Cms::menu('main');

    $isMenuItemActive = function (object $item): bool {
        $itemPath = trim(parse_url($item->resolved_url ?? '', PHP_URL_PATH) ?? '', '/');
        $currentPath = trim(request()->path(), '/');
        return $currentPath === $itemPath || ($itemPath !== '' && str_starts_with($currentPath, $itemPath . '/'));
    };
@endphp

@once
    @push('styles')
        <style>
            /* align the li itself so the circle sits on the same baseline as nav links */
            .navbar-nav .nav-item:has(.nav-auth-btn) {
                display: flex;
                align-items: center;
            }

            .nav-auth-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 34px;
                height: 34px;
                background: transparent;
                border: 1.5px solid rgba(255, 255, 255, 0.6);
                color: #fff !important;
                border-radius: 50%;
                text-decoration: none;
                transition: all 0.3s ease;
                margin-left: 10px;
            }

            .nav-auth-btn i {
                font-size: 1rem;
                line-height: 1;
                color: #fff !important;
            }

            .nav-auth-btn:hover,
            .nav-auth-btn--active {
                background: #c8a96e;
                border-color: #c8a96e;
                color: #fff !important;
            }

            .nav-auth-btn:hover i,
            .nav-auth-btn--active i {
                color: #fff !important;
            }

            .navbar-scrolled .nav-auth-btn {
                border-color: rgba(255, 255, 255, 0.5);
            }

            .navbar-scrolled .nav-auth-btn:hover {
                background: #c8a96e;
                border-color: #c8a96e;
            }

            @media (max-width: 991px) {
                .navbar-nav .nav-item:has(.nav-auth-btn) {
                    display: block;
                }

                .nav-auth-btn {
                    margin: 4px 0;
                    width: 32px;
                    height: 32px;
                }
            }
        </style>
    @endpush
@endonce

<nav class="navbar navbar-expand-lg">
    <div class="container">
        {{-- Logo --}}
        <div class="logo-wrapper">
            <a class="logo" href="{{ route('home') }}">
                @if ($siteLogo)
                    <img src="{{ $siteLogo }}" class="logo-img" alt="{{ $siteName }}">
                @else
                    <h2>{{ $siteName }}</h2>
                @endif
            </a>
        </div>

        {{-- Mobile toggle --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
            aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"><i class="ti-menu"></i></span>
        </button>

        {{-- Menu --}}
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav ms-auto">

                @if ($mainMenu && $mainMenu->allItems->count())
                    {{-- Dynamic menu from database --}}
                    @foreach ($mainMenu->allItems->whereNull('parent_id') as $item)
                        @php
                            $children = $mainMenu->allItems->where('parent_id', $item->id);
                            $isActive =
                                $isMenuItemActive($item) ||
                                $children->contains(fn($child) => $isMenuItemActive($child));
                        @endphp

                        @if ($children->count())
                            <li class="nav-item dropdown {{ $isActive ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle {{ $isActive ? 'active' : '' }}" href="#"
                                    role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                                    aria-expanded="false">
                                    @if ($item->icon)
                                        <i class="{{ $item->icon }}"></i>
                                    @endif
                                    {{ $item->title }} <i class="ti-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach ($children as $child)
                                        <li>
                                            <a href="{{ $child->resolved_url }}"
                                                class="dropdown-item {{ $isMenuItemActive($child) ? 'active' : '' }}"
                                                @if (($child->target ?? '') === '_blank') target="_blank" rel="noopener noreferrer" @endif>
                                                @if ($child->icon)
                                                    <i class="{{ $child->icon }}"></i>
                                                @endif
                                                <span>{{ $child->title }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li class="nav-item {{ $isActive ? 'active' : '' }}">
                                <a class="nav-link {{ $isActive ? 'active' : '' }}" href="{{ $item->resolved_url }}"
                                    @if (($item->target ?? '') === '_blank') target="_blank" rel="noopener noreferrer" @endif>
                                    @if ($item->icon)
                                        <i class="{{ $item->icon }}"></i>
                                    @endif
                                    {{ $item->title }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @else
                    {{-- Static fallback menu --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                            href="{{ route('home') }}">Home</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('trek-routes.*') ? 'active' : '' }}"
                            href="#" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                            aria-expanded="false">
                            Annapurna Treks &amp; Tours <i class="ti-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('trek-routes.index') }}" class="dropdown-item">
                                    <span>Trek Routes</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('travel-agencies.*') ? 'active' : '' }}"
                            href="{{ route('travel-agencies.index') }}">Travel Agencies</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('destinations.*') ? 'active' : '' }}"
                            href="{{ route('destinations.index') }}">Destinations</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('feed.*') ? 'active' : '' }}"
                            href="{{ route('feed.index') }}">Feed</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('hotels.*') || request()->routeIs('restaurants.*') ? 'active' : '' }}"
                            href="#" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                            aria-expanded="false">
                            Hotels &amp; Restaurants <i class="ti-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('hotels.index') }}" class="dropdown-item">
                                    <span>Hotels</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('restaurants.index') }}" class="dropdown-item">
                                    <span>Restaurants</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}"
                            href="{{ route('blog.index') }}">Blog</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                            href="{{ route('contact') }}">Contact</a>
                    </li>
                @endif

                {{-- Auth Links --}}
                @guest
                    <li class="nav-item" style="margin: 10px; color: #fff;">
                        <a class="nav-auth-btn {{ request()->routeIs('login', 'register') ? 'nav-auth-btn--active' : '' }}"
                            href="{{ route('login') }}" title="My Account">
                            <i class="ti-user"></i>
                        </a>
                    </li>
                @else
                    <li class="nav-item dropdown" style="margin: 10px; color: #fff;">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('dashboard.*') ? 'active' : '' }}"
                            href="#" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                            aria-expanded="false">
                            @if (auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}"
                                    alt="{{ auth()->user()->name }}"
                                    style="width:28px;height:28px;border-radius:50%;object-fit:cover;vertical-align:middle;margin-right:6px;">
                            @else
                                <span
                                    style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:50%;background:#c8a96e;color:#fff;font-size:12px;font-weight:700;vertical-align:middle;margin-right:6px;">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                            @endif
                            {{ auth()->user()->name }} <i class="ti-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('dashboard.index') }}" class="dropdown-item">
                                    <i class="ti-home"></i> <span>Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('dashboard.profile.edit') }}" class="dropdown-item">
                                    <i class="ti-user"></i> <span>My Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('dashboard.businesses.index') }}" class="dropdown-item">
                                    <i class="ti-briefcase"></i> <span>My Businesses</span>
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                                    @csrf
                                    <button type="submit" class="dropdown-item"
                                        style="width:100%;text-align:left;background:none;border:none;cursor:pointer;padding:8px 16px;font-size:inherit;font-family:inherit;">
                                        <i class="ti-power-off"></i> <span>Logout</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest

            </ul>
        </div>
    </div>
</nav>
