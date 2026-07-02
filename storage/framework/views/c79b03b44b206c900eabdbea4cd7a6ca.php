<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    
    <title><?php echo $__env->yieldContent('meta_title', \App\Helpers\Cms::defaultMetaTitle()); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('meta_description', \App\Helpers\Cms::defaultMetaDescription()); ?>">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($page) && !empty($page->meta_keywords)): ?>
        <meta name="keywords" content="<?php echo e($page->meta_keywords); ?>">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($page) && !empty($page->no_index)): ?>
        <meta name="robots" content="noindex, nofollow">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <meta property="og:title" content="<?php echo $__env->yieldContent('og_title', \App\Helpers\Cms::defaultMetaTitle()); ?>" />
    <meta property="og:description" content="<?php echo $__env->yieldContent('og_description', \App\Helpers\Cms::defaultMetaDescription()); ?>" />
    <meta property="og:type" content="<?php echo $__env->yieldContent('og_type', 'website'); ?>" />
    <meta property="og:url" content="<?php echo e(url()->current()); ?>" />
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($page) && !empty($page->og_image)): ?>
        <meta property="og:image" content="<?php echo e(\App\Helpers\Cms::imageUrl($page->og_image)); ?>" />
    <?php else: ?>
        <meta property="og:image" content="<?php echo e(asset('annapurna/img/slider/annapurna-region.png')); ?>" />
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />

    
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?php echo $__env->yieldContent('og_title', \App\Helpers\Cms::defaultMetaTitle()); ?>" />
    <meta name="twitter:description" content="<?php echo $__env->yieldContent('og_description', \App\Helpers\Cms::defaultMetaDescription()); ?>" />
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($page) && !empty($page->og_image)): ?>
        <meta name="twitter:image" content="<?php echo e(\App\Helpers\Cms::imageUrl($page->og_image)); ?>" />
    <?php else: ?>
        <meta name="twitter:image" content="<?php echo e(asset('annapurna/img/slider/annapurna-region.png')); ?>" />
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <link rel="shortcut icon" href="<?php echo e(\App\Helpers\Cms::siteFavicon()); ?>" />

    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Barlow:wght@300;400;500&family=Poppins:wght@300;400;500;600;700&display=swap">

    
    <link rel="stylesheet" href="<?php echo e(asset('annapurna/css/plugins.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('annapurna/css/style.css')); ?>" />

    
    <?php echo $__env->yieldPushContent('styles'); ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(\App\Helpers\Cms::setting('google_analytics')): ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo e(\App\Helpers\Cms::setting('google_analytics')); ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '<?php echo e(\App\Helpers\Cms::setting('google_analytics')); ?>');
    </script>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</head>
<body>

    
    <div class="preloader-bg"></div>
    <div id="preloader">
        <div id="preloader-status">
            <div class="preloader-position loader"> <span></span> </div>
        </div>
    </div>

    
    <div class="progress-wrap cursor-pointer">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>

    
    <?php echo $__env->make('partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    
    <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <script src="<?php echo e(asset('annapurna/js/jquery-3.6.3.min.js')); ?>"></script>
    <script src="<?php echo e(asset('annapurna/js/jquery-migrate-3.0.0.min.js')); ?>"></script>
    <script src="<?php echo e(asset('annapurna/js/modernizr-2.6.2.min.js')); ?>"></script>
    <script src="<?php echo e(asset('annapurna/js/imagesloaded.pkgd.min.js')); ?>"></script>
    <script src="<?php echo e(asset('annapurna/js/jquery.isotope.v3.0.2.js')); ?>"></script>
    <script src="<?php echo e(asset('annapurna/js/pace.js')); ?>"></script>
    <script src="<?php echo e(asset('annapurna/js/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('annapurna/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('annapurna/js/scrollIt.min.js')); ?>"></script>
    <script src="<?php echo e(asset('annapurna/js/jquery.waypoints.min.js')); ?>"></script>
    <script src="<?php echo e(asset('annapurna/js/owl.carousel.min.js')); ?>"></script>
    <script src="<?php echo e(asset('annapurna/js/jquery.stellar.min.js')); ?>"></script>
    <script src="<?php echo e(asset('annapurna/js/jquery.magnific-popup.js')); ?>"></script>
    <script src="<?php echo e(asset('annapurna/js/YouTubePopUp.js')); ?>"></script>
    <script src="<?php echo e(asset('annapurna/js/select2.js')); ?>"></script>
    <script src="<?php echo e(asset('annapurna/js/datepicker.js')); ?>"></script>
    <script src="<?php echo e(asset('annapurna/js/jquery.counterup.min.js')); ?>"></script>
    <script src="<?php echo e(asset('annapurna/js/smooth-scroll.min.js')); ?>"></script>
    <script src="<?php echo e(asset('annapurna/js/vegas.slider.min.js')); ?>"></script>
    <script src="<?php echo e(asset('annapurna/js/custom.js')); ?>"></script>

    
    <?php echo $__env->yieldPushContent('scripts'); ?>

</body>
</html>
<?php /**PATH /var/www/resources/views/layouts/app.blade.php ENDPATH**/ ?>