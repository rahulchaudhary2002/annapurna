<?php $__env->startSection('meta_title', \App\Helpers\Cms::setting('treks_meta_title', 'Trek Routes - Annapurna Region')); ?>
<?php $__env->startSection('meta_description', \App\Helpers\Cms::setting('treks_meta_description', 'Explore the best trekking routes in the Annapurna Region. From Annapurna Circuit to Base Camp treks, find complete guides and itineraries.')); ?>

<?php $__env->startSection('content'); ?>

    <?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['title' => 'Trek Routes','subtitle' => 'Annapurna Region']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Trek Routes','subtitle' => 'Annapurna Region']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2)): ?>
<?php $attributes = $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2; ?>
<?php unset($__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale19f62b34dfe0bfdf95075badcb45bc2)): ?>
<?php $component = $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2; ?>
<?php unset($__componentOriginale19f62b34dfe0bfdf95075badcb45bc2); ?>
<?php endif; ?>

    <section class="tours1 section-padding">
        <div class="container">

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $trekRoutes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trek): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="row mb-90">

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loop->odd): ?>
                
                <div class="col-md-7">
                    <div class="country">
                        <div class="section-subtitle"><?php echo e($trek->difficulty ?? 'Moderate'); ?><?php echo e($trek->duration_days ? ' — ' . $trek->duration_days . ' Days' : ''); ?></div>
                        <div class="section-title2"><?php echo e($trek->name); ?></div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($trek->excerpt): ?><p><?php echo e($trek->excerpt); ?></p><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="row tour-list">
                            <div class="col-md-6">
                                <ul>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($trek->max_altitude): ?><li><i class="flaticon-placeholder"></i> Max Altitude: <?php echo e($trek->max_altitude); ?></li><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($trek->total_distance): ?><li><i class="flaticon-placeholder"></i> Distance: <?php echo e($trek->total_distance); ?></li><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($trek->start_point): ?><li><i class="flaticon-placeholder"></i> Start: <?php echo e($trek->start_point); ?></li><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($trek->best_season): ?><li><i class="flaticon-calendar"></i> Best Season: <?php echo e($trek->best_season); ?></li><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($trek->duration_days): ?><li><i class="flaticon-calendar"></i> Duration: <?php echo e($trek->duration_days); ?> Days</li><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($trek->end_point): ?><li><i class="flaticon-placeholder"></i> End: <?php echo e($trek->end_point); ?></li><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </ul>
                            </div>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($trek->highlights && count((array)$trek->highlights)): ?>
                        <div class="row tour-list mt-10">
                            <div class="col-md-12">
                                <ul>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = array_slice((array)$trek->highlights, 0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $highlight): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><i class="ti-check"></i> <?php echo e($highlight); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </ul>
                            </div>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="butn-dark mt-30 mb-30">
                            <a href="<?php echo e(route('trek-routes.show', $trek->slug)); ?>"><span>View Details <i class="ti-arrow-right"></i></span></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="owl-carousel owl-theme">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($trek->gallery) && count((array)$trek->gallery)): ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = (array)$trek->gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="item">
                                <div class="position-re o-hidden">
                                    <img src="<?php echo e(\App\Helpers\Cms::imageUrl($img)); ?>" alt="<?php echo e($trek->name); ?>">
                                </div>
                                <span class="category"><a href="<?php echo e(route('trek-routes.show', $trek->slug)); ?>"><?php echo e($trek->name); ?></a></span>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php elseif($trek->featured_image): ?>
                            <div class="item">
                                <div class="position-re o-hidden">
                                    <img src="<?php echo e(\App\Helpers\Cms::imageUrl($trek->featured_image)); ?>" alt="<?php echo e($trek->name); ?>">
                                </div>
                                <span class="category"><a href="<?php echo e(route('trek-routes.show', $trek->slug)); ?>"><?php echo e($trek->name); ?></a></span>
                            </div>
                        <?php else: ?>
                            <div class="item">
                                <div class="position-re o-hidden">
                                    <img src="<?php echo e(asset('annapurna/img/tours/annapurna-circuit.jpg')); ?>" alt="<?php echo e($trek->name); ?>">
                                </div>
                                <span class="category"><a href="<?php echo e(route('trek-routes.show', $trek->slug)); ?>"><?php echo e($trek->name); ?></a></span>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <?php else: ?>
                
                <div class="col-md-5">
                    <div class="owl-carousel owl-theme">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($trek->gallery) && count((array)$trek->gallery)): ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = (array)$trek->gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="item">
                                <div class="position-re o-hidden">
                                    <img src="<?php echo e(\App\Helpers\Cms::imageUrl($img)); ?>" alt="<?php echo e($trek->name); ?>">
                                </div>
                                <span class="category"><a href="<?php echo e(route('trek-routes.show', $trek->slug)); ?>"><?php echo e($trek->name); ?></a></span>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php elseif($trek->featured_image): ?>
                            <div class="item">
                                <div class="position-re o-hidden">
                                    <img src="<?php echo e(\App\Helpers\Cms::imageUrl($trek->featured_image)); ?>" alt="<?php echo e($trek->name); ?>">
                                </div>
                                <span class="category"><a href="<?php echo e(route('trek-routes.show', $trek->slug)); ?>"><?php echo e($trek->name); ?></a></span>
                            </div>
                        <?php else: ?>
                            <div class="item">
                                <div class="position-re o-hidden">
                                    <img src="<?php echo e(asset('annapurna/img/tours/annapurna-circuit.jpg')); ?>" alt="<?php echo e($trek->name); ?>">
                                </div>
                                <span class="category"><a href="<?php echo e(route('trek-routes.show', $trek->slug)); ?>"><?php echo e($trek->name); ?></a></span>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="country country1">
                        <div class="section-subtitle"><?php echo e($trek->difficulty ?? 'Moderate'); ?><?php echo e($trek->duration_days ? ' — ' . $trek->duration_days . ' Days' : ''); ?></div>
                        <div class="section-title2"><?php echo e($trek->name); ?></div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($trek->excerpt): ?><p><?php echo e($trek->excerpt); ?></p><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="row tour-list">
                            <div class="col-md-6">
                                <ul>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($trek->max_altitude): ?><li><i class="flaticon-placeholder"></i> Max Altitude: <?php echo e($trek->max_altitude); ?></li><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($trek->total_distance): ?><li><i class="flaticon-placeholder"></i> Distance: <?php echo e($trek->total_distance); ?></li><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($trek->start_point): ?><li><i class="flaticon-placeholder"></i> Start: <?php echo e($trek->start_point); ?></li><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($trek->best_season): ?><li><i class="flaticon-calendar"></i> Best Season: <?php echo e($trek->best_season); ?></li><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($trek->duration_days): ?><li><i class="flaticon-calendar"></i> Duration: <?php echo e($trek->duration_days); ?> Days</li><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($trek->end_point): ?><li><i class="flaticon-placeholder"></i> End: <?php echo e($trek->end_point); ?></li><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </ul>
                            </div>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($trek->highlights && count((array)$trek->highlights)): ?>
                        <div class="row tour-list mt-10">
                            <div class="col-md-12">
                                <ul>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = array_slice((array)$trek->highlights, 0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $highlight): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><i class="ti-check"></i> <?php echo e($highlight); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </ul>
                            </div>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="butn-dark mt-30 mb-30">
                            <a href="<?php echo e(route('trek-routes.show', $trek->slug)); ?>"><span>View Details <i class="ti-arrow-right"></i></span></a>
                        </div>
                    </div>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="row">
                <div class="col-md-12 text-center">
                    <p>No trek routes found. Check back soon!</p>
                    <div class="butn-dark mt-30"><a href="<?php echo e(route('home')); ?>"><span>Back to Home <i class="ti-arrow-right"></i></span></a></div>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(method_exists($trekRoutes, 'links') && $trekRoutes->hasPages()): ?>
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="blog-pagination-wrap mt-30 mb-30">
                        <?php echo e($trekRoutes->links()); ?>

                    </div>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/frontend/trek-routes/index.blade.php ENDPATH**/ ?>