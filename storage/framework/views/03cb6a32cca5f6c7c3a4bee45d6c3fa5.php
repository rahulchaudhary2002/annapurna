<?php
    $siteName = \App\Helpers\Cms::siteName();
    $siteLogo = \App\Helpers\Cms::siteLogo();
    $mainMenu = \App\Helpers\Cms::menu('main');

    $isMenuItemActive = function (object $item): bool {
        $itemPath = trim(parse_url($item->resolved_url ?? '', PHP_URL_PATH) ?? '', '/');
        $currentPath = trim(request()->path(), '/');
        return $currentPath === $itemPath || ($itemPath !== '' && str_starts_with($currentPath, $itemPath . '/'));
    };
?>

<?php if (! $__env->hasRenderedOnce('635c62bc-7c55-4459-beec-65cc83af94c1')): $__env->markAsRenderedOnce('635c62bc-7c55-4459-beec-65cc83af94c1'); ?>
    <?php $__env->startPush('styles'); ?>
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
    <?php $__env->stopPush(); ?>
<?php endif; ?>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        
        <div class="logo-wrapper">
            <a class="logo" href="<?php echo e(route('home')); ?>">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($siteLogo): ?>
                    <img src="<?php echo e($siteLogo); ?>" class="logo-img" alt="<?php echo e($siteName); ?>">
                <?php else: ?>
                    <h2><?php echo e($siteName); ?></h2>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </a>
        </div>

        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
            aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"><i class="ti-menu"></i></span>
        </button>

        
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav ms-auto">

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($mainMenu && $mainMenu->allItems->count()): ?>
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $mainMenu->allItems->whereNull('parent_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $children = $mainMenu->allItems->where('parent_id', $item->id);
                            $isActive =
                                $isMenuItemActive($item) ||
                                $children->contains(fn($child) => $isMenuItemActive($child));
                        ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($children->count()): ?>
                            <li class="nav-item dropdown <?php echo e($isActive ? 'active' : ''); ?>">
                                <a class="nav-link dropdown-toggle <?php echo e($isActive ? 'active' : ''); ?>" href="#"
                                    role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                                    aria-expanded="false">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->icon): ?>
                                        <i class="<?php echo e($item->icon); ?>"></i>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php echo e($item->title); ?> <i class="ti-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <a href="<?php echo e($child->resolved_url); ?>"
                                                class="dropdown-item <?php echo e($isMenuItemActive($child) ? 'active' : ''); ?>"
                                                <?php if(($child->target ?? '') === '_blank'): ?> target="_blank" rel="noopener noreferrer" <?php endif; ?>>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($child->icon): ?>
                                                    <i class="<?php echo e($child->icon); ?>"></i>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <span><?php echo e($child->title); ?></span>
                                            </a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li class="nav-item <?php echo e($isActive ? 'active' : ''); ?>">
                                <a class="nav-link <?php echo e($isActive ? 'active' : ''); ?>" href="<?php echo e($item->resolved_url); ?>"
                                    <?php if(($item->target ?? '') === '_blank'): ?> target="_blank" rel="noopener noreferrer" <?php endif; ?>>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->icon): ?>
                                        <i class="<?php echo e($item->icon); ?>"></i>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php echo e($item->title); ?>

                                </a>
                            </li>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php else: ?>
                    
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>"
                            href="<?php echo e(route('home')); ?>">Home</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php echo e(request()->routeIs('trek-routes.*') ? 'active' : ''); ?>"
                            href="#" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                            aria-expanded="false">
                            Annapurna Treks &amp; Tours <i class="ti-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo e(route('trek-routes.index')); ?>" class="dropdown-item">
                                    <span>Trek Routes</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('travel-agencies.*') ? 'active' : ''); ?>"
                            href="<?php echo e(route('travel-agencies.index')); ?>">Travel Agencies</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('destinations.*') ? 'active' : ''); ?>"
                            href="<?php echo e(route('destinations.index')); ?>">Destinations</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('feed.*') ? 'active' : ''); ?>"
                            href="<?php echo e(route('feed.index')); ?>">Feed</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php echo e(request()->routeIs('hotels.*') || request()->routeIs('restaurants.*') ? 'active' : ''); ?>"
                            href="#" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                            aria-expanded="false">
                            Hotels &amp; Restaurants <i class="ti-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo e(route('hotels.index')); ?>" class="dropdown-item">
                                    <span>Hotels</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('restaurants.index')); ?>" class="dropdown-item">
                                    <span>Restaurants</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('blog.*') ? 'active' : ''); ?>"
                            href="<?php echo e(route('blog.index')); ?>">Blog</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('contact') ? 'active' : ''); ?>"
                            href="<?php echo e(route('contact')); ?>">Contact</a>
                    </li>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->guest()): ?>
                    <li class="nav-item" style="margin: 10px; color: #fff;">
                        <a class="nav-auth-btn <?php echo e(request()->routeIs('login', 'register') ? 'nav-auth-btn--active' : ''); ?>"
                            href="<?php echo e(route('login')); ?>" title="My Account">
                            <i class="ti-user"></i>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item dropdown" style="margin: 10px; color: #fff;">
                        <a class="nav-link dropdown-toggle <?php echo e(request()->routeIs('dashboard.*') ? 'active' : ''); ?>"
                            href="#" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                            aria-expanded="false">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->avatar): ?>
                                <img src="<?php echo e(asset('storage/' . auth()->user()->avatar)); ?>"
                                    alt="<?php echo e(auth()->user()->name); ?>"
                                    style="width:28px;height:28px;border-radius:50%;object-fit:cover;vertical-align:middle;margin-right:6px;">
                            <?php else: ?>
                                <span
                                    style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:50%;background:#c8a96e;color:#fff;font-size:12px;font-weight:700;vertical-align:middle;margin-right:6px;">
                                    <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php echo e(auth()->user()->name); ?> <i class="ti-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo e(route('dashboard.index')); ?>" class="dropdown-item">
                                    <i class="ti-home"></i> <span>Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('dashboard.profile.edit')); ?>" class="dropdown-item">
                                    <i class="ti-user"></i> <span>My Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('dashboard.businesses.index')); ?>" class="dropdown-item">
                                    <i class="ti-briefcase"></i> <span>My Businesses</span>
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="<?php echo e(route('logout')); ?>" style="margin:0;">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="dropdown-item"
                                        style="width:100%;text-align:left;background:none;border:none;cursor:pointer;padding:8px 16px;font-size:inherit;font-family:inherit;">
                                        <i class="ti-power-off"></i> <span>Logout</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            </ul>
        </div>
    </div>
</nav>
<?php /**PATH /var/www/resources/views/partials/header.blade.php ENDPATH**/ ?>