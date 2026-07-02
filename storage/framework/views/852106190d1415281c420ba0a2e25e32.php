<?php
    $siteName  = \App\Helpers\Cms::siteName();
    $siteLogo  = \App\Helpers\Cms::siteLogo();
    $tagline   = \App\Helpers\Cms::setting('footer_tagline', 'Discover trekking, tours, and travel in the Annapurna region.');
    $contact   = \App\Helpers\Cms::contactInfo();
    $social    = \App\Helpers\Cms::socialLinks();
?>

<footer class="footer clearfix">
    <div class="container">

        
        <div class="first-footer">
            <div class="row">
                <div class="col-md-12">
                    <div class="links dark footer-contact-links">
                        <div class="footer-contact-links-wrapper">

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($contact['phone']): ?>
                            <div class="footer-contact-link-wrapper">
                                <div class="image-wrapper footer-contact-link-icon">
                                    <div class="icon-footer"><i class="flaticon-phone-call"></i></div>
                                </div>
                                <div class="footer-contact-link-content">
                                    <h6>Call us</h6>
                                    <p><a href="tel:<?php echo e($contact['phone']); ?>"><?php echo e($contact['phone']); ?></a></p>
                                </div>
                            </div>
                            <div class="footer-contact-links-divider"></div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($contact['email']): ?>
                            <div class="footer-contact-link-wrapper">
                                <div class="image-wrapper footer-contact-link-icon">
                                    <div class="icon-footer"><i class="flaticon-message"></i></div>
                                </div>
                                <div class="footer-contact-link-content">
                                    <h6>Write to us</h6>
                                    <p><a href="mailto:<?php echo e($contact['email']); ?>"><?php echo e($contact['email']); ?></a></p>
                                </div>
                            </div>
                            <div class="footer-contact-links-divider"></div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($contact['address']): ?>
                            <div class="footer-contact-link-wrapper">
                                <div class="image-wrapper footer-contact-link-icon">
                                    <div class="icon-footer"><i class="flaticon-placeholder"></i></div>
                                </div>
                                <div class="footer-contact-link-content">
                                    <h6>Address</h6>
                                    <p><?php echo e($contact['address']); ?></p>
                                </div>
                            </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="second-footer">
            <div class="row">

                
                <div class="col-md-4 widget-area">
                    <div class="widget clearfix">
                        <div class="footer-logo">
                            <a href="<?php echo e(route('home')); ?>">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($siteLogo): ?>
                                    <img class="img-fluid" src="<?php echo e($siteLogo); ?>" alt="<?php echo e($siteName); ?>">
                                <?php else: ?>
                                    <h2 class="text-white"><?php echo e($siteName); ?></h2>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </a>
                        </div>
                        <div class="widget-text">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tagline): ?>
                                <p><?php echo e($tagline); ?></p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <div class="social-icons">
                                <ul class="list-inline">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($social['instagram']): ?>
                                        <li><a href="<?php echo e($social['instagram']); ?>" target="_blank" rel="noopener noreferrer"><i class="ti-instagram"></i></a></li>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($social['twitter']): ?>
                                        <li><a href="<?php echo e($social['twitter']); ?>" target="_blank" rel="noopener noreferrer"><i class="ti-twitter"></i></a></li>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($social['facebook']): ?>
                                        <li><a href="<?php echo e($social['facebook']); ?>" target="_blank" rel="noopener noreferrer"><i class="ti-facebook"></i></a></li>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($social['youtube']): ?>
                                        <li><a href="<?php echo e($social['youtube']); ?>" target="_blank" rel="noopener noreferrer"><i class="ti-youtube"></i></a></li>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="col-md-3 offset-md-1 widget-area">
                    <div class="widget clearfix usful-links">
                        <h3 class="widget-title">Quick Links</h3>
                        <ul>
                            <li><a href="<?php echo e(route('trek-routes.index')); ?>">Trek Routes</a></li>
                            <li><a href="<?php echo e(route('travel-agencies.index')); ?>">Travel Agencies</a></li>
                            <li><a href="<?php echo e(route('destinations.index')); ?>">Destinations</a></li>
                            <li><a href="<?php echo e(route('hotels.index')); ?>">Hotels</a></li>
                            <li><a href="<?php echo e(route('restaurants.index')); ?>">Restaurants</a></li>
                            <li><a href="<?php echo e(route('blog.index')); ?>">Blog</a></li>
                            <li><a href="<?php echo e(route('contact')); ?>">Contact</a></li>
                        </ul>
                    </div>
                </div>

                
                <div class="col-md-4 widget-area">
                    <div class="widget clearfix">
                        <h3 class="widget-title">Subscribe</h3>
                        <p>Sign up for our monthly newsletter to stay informed about Annapurna travel and tours.</p>
                        <div class="widget-newsletter">
                            <form action="<?php echo e(route('contact')); ?>" method="GET">
                                <input type="email" name="email" placeholder="Email Address" required>
                                <button type="submit">Send</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        
        <div class="bottom-footer-text">
            <div class="row copyright">
                <div class="col-md-12">
                    <p class="mb-0">&copy;<?php echo e(date('Y')); ?> <a href="<?php echo e(route('home')); ?>"><?php echo e($siteName); ?></a>. All rights reserved.</p>
                </div>
            </div>
        </div>

    </div>
</footer>
<?php /**PATH /var/www/resources/views/partials/footer.blade.php ENDPATH**/ ?>