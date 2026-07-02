<?php $__env->startSection('meta_title', \App\Helpers\Cms::setting('home_meta_title', \App\Helpers\Cms::siteName())); ?>
<?php $__env->startSection('meta_description', \App\Helpers\Cms::setting('home_meta_description', \App\Helpers\Cms::defaultMetaDescription())); ?>

<?php $__env->startPush('styles'); ?>
<style>
/* =====================================================
   HOME PAGE — eBookingNepal-inspired layout
   Palette: teal #2095AE | navy #0f2454 | gold #e4a853
===================================================== */

/* ---- HERO ---- */
.hero-wrap {
    position: relative;
    min-height: 580px;
    overflow: hidden;
}
.hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom,
        rgba(15,36,84,.6) 0%,
        rgba(15,36,84,.3) 55%,
        rgba(15,36,84,.72) 100%);
    z-index: 1;
}
.hero-content {
    position: relative;
    z-index: 2;
    padding: 110px 0 0;
    text-align: center;
}
.hero-content h5 {
    color: rgba(255,255,255,.85);
    font-size: 13px;
    font-weight: 400;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 10px;
}
.hero-content h1 {
    color: #fff;
    font-size: 40px;
    font-weight: 700;
    margin-bottom: 6px;
    line-height: 1.15;
}
.hero-content h1 span { color: #e4a853; }
.hero-content > .container > p {
    color: rgba(255,255,255,.8);
    font-size: 15px;
    margin-bottom: 0;
}

/* ---- SEARCH TABS ---- */
.search-panel { position: relative; z-index: 2; margin-top: 32px; }
.search-tabs {
    display: flex;
    justify-content: center;
    gap: 0;
    list-style: none;
    padding: 0;
    margin: 0;
}
.search-tabs li a {
    display: block;
    padding: 10px 22px;
    background: rgba(255,255,255,.18);
    color: #fff;
    font-family: 'Poppins', sans-serif;
    font-size: 13px;
    font-weight: 500;
    border-radius: 4px 4px 0 0;
    text-decoration: none;
    transition: background .25s;
    border: 1px solid rgba(255,255,255,.18);
    border-bottom: none;
}
.search-tabs li a:hover,
.search-tabs li.active a {
    background: #fff;
    color: #2095AE;
    font-weight: 600;
}

/* ---- SEARCH BAR ---- */
.search-bar-wrap {
    background: #fff;
    border-radius: 0 8px 8px 8px;
    box-shadow: 0 8px 32px rgba(15,36,84,.15);
    padding: 20px 22px;
    display: flex;
    align-items: flex-end;
    gap: 12px;
    flex-wrap: wrap;
}
.search-bar-field { flex: 1; min-width: 150px; }
.search-bar-field label {
    display: block;
    font-family: 'Poppins', sans-serif;
    font-size: 10px;
    font-weight: 600;
    color: #0f2454;
    text-transform: uppercase;
    letter-spacing: .5px;
    margin-bottom: 5px;
}
.search-bar-field input,
.search-bar-field select {
    width: 100%;
    border: 1px solid #e2e6ea;
    border-radius: 6px;
    padding: 8px 11px;
    font-size: 13px;
    color: #676977;
    outline: none;
    background: #fff;
    height: 40px;
    box-sizing: border-box;
    transition: border .2s;
}
.search-bar-field input:focus,
.search-bar-field select:focus { border-color: #2095AE; }
.search-btn {
    background: #2095AE;
    border: none;
    border-radius: 6px;
    color: #fff;
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 17px;
    cursor: pointer;
    flex-shrink: 0;
    transition: background .2s;
}
.search-btn:hover { background: #0f2454; }

/* ---- CATEGORY PILLS ---- */
.cat-pills {
    display: flex;
    gap: 8px;
    align-items: center;
    flex-wrap: wrap;
    margin-top: 12px;
    justify-content: center;
}
.cat-pills span { color: rgba(255,255,255,.7); font-size: 12px; }
.cat-pill {
    background: rgba(255,255,255,.18);
    border: 1px solid rgba(255,255,255,.35);
    color: #fff;
    border-radius: 20px;
    padding: 4px 13px;
    font-size: 12px;
    text-decoration: none;
    transition: background .2s;
}
.cat-pill:hover, .cat-pill.active {
    background: #2095AE;
    border-color: #2095AE;
    color: #fff;
}

/* ---- SECTION HEADING ---- */
.sec-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 26px;
}
.sec-head-left .sec-tag {
    font-family: 'Poppins', sans-serif;
    font-size: 11px;
    font-weight: 600;
    color: #2095AE;
    text-transform: uppercase;
    letter-spacing: 1px;
    display: flex;
    align-items: center;
    gap: 5px;
    margin-bottom: 3px;
}
.sec-head-left h3 { font-size: 22px; font-weight: 700; color: #0f2454; margin: 0; }
.sec-head-left h3 span { color: #2095AE; }
.sec-nav { display: flex; align-items: center; gap: 10px; }
.sec-nav-btn {
    width: 34px;
    height: 34px;
    border: 1px solid #e2e6ea;
    border-radius: 50%;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #676977;
    font-size: 13px;
    transition: all .2s;
}
.sec-nav-btn:hover { background: #2095AE; border-color: #2095AE; color: #fff; }
.sec-view-all {
    font-size: 13px;
    font-weight: 600;
    color: #2095AE;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    white-space: nowrap;
}
.sec-view-all:hover { color: #0f2454; }
/* deals 2-row grid */
.deals-panel .owl-carousel {
    display: grid !important;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    transform: none !important;
}
.deals-panel .owl-carousel .deal-card { display: none; flex-direction: column; }
.deals-panel .owl-carousel .deal-card.d-show { display: flex !important; }
@media (max-width: 1199px) { .deals-panel .owl-carousel { grid-template-columns: repeat(3,1fr); } }
@media (max-width: 767px)  { .deals-panel .owl-carousel { grid-template-columns: repeat(2,1fr); } }
@media (max-width: 480px)  { .deals-panel .owl-carousel { grid-template-columns: 1fr; } }
/* page indicator */
.deals-page-info {
    font-size: 13px;
    font-weight: 600;
    color: #0f2454;
    min-width: 40px;
    text-align: center;
}

/* ---- DEAL CARDS ---- */
.deal-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 14px rgba(15,36,84,.08);
    transition: transform .3s, box-shadow .3s;
    height: 100%;
}
.deal-card:hover { transform: translateY(-4px); box-shadow: 0 8px 28px rgba(15,36,84,.14); }
.deal-card-img { position: relative; height: 190px; overflow: hidden; }
.deal-card-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s; }
.deal-card:hover .deal-card-img img { transform: scale(1.05); }
.deal-badge {
    position: absolute;
    top: 10px; left: 10px;
    background: #2095AE;
    color: #fff;
    font-size: 10px;
    font-weight: 600;
    padding: 3px 9px;
    border-radius: 4px;
    text-transform: uppercase;
    letter-spacing: .5px;
}
.deal-badge.verified { background: #28a745; }
.deal-badge.hot { background: #e4a853; color: #0f2454; }
.deal-card-body { padding: 13px 15px 15px; }
.deal-card-rating { display: flex; align-items: center; gap: 3px; margin-bottom: 5px; }
.deal-card-rating i { color: #e4a853; font-size: 10px; }
.deal-card-rating span { font-size: 11px; color: #676977; }
.deal-card-title { font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 600; color: #0f2454; margin-bottom: 3px; line-height: 1.3; }
.deal-card-title a { color: inherit; text-decoration: none; }
.deal-card-title a:hover { color: #2095AE; }
.deal-card-loc { font-size: 12px; color: #676977; display: flex; align-items: center; gap: 4px; margin-bottom: 9px; }
.deal-card-loc i { color: #2095AE; }
.deal-card-footer { display: flex; align-items: center; justify-content: space-between; padding-top: 9px; border-top: 1px solid #f4f5f8; }
.deal-card-price small { display: block; font-size: 10px; color: #9a9ca8; text-transform: uppercase; }
.deal-card-price strong { font-family: 'Poppins', sans-serif; font-size: 16px; font-weight: 700; color: #2095AE; }
.deal-card-price .old-price { text-decoration: line-through; color: #b0b3c0; font-size: 11px; margin-left: 3px; }
.deal-save { background: rgba(32,149,174,.1); color: #2095AE; font-size: 10px; font-weight: 600; padding: 2px 7px; border-radius: 10px; }
.deal-card-meta { display: flex; gap: 10px; font-size: 11px; color: #676977; margin-top: 6px; }
.deal-card-meta i { color: #2095AE; }

/* ---- STATS BAR ---- */
.stats-bar { background: #f4f5f8; border-radius: 12px; padding: 20px 0; }
.stat-item { text-align: center; padding: 8px 16px; border-right: 1px solid #e2e6ea; }
.stat-item:last-child { border-right: none; }
.stat-item h4 { font-family: 'Poppins', sans-serif; font-size: 26px; font-weight: 700; color: #2095AE; margin-bottom: 3px; }
.stat-item p { font-size: 11px; color: #676977; margin: 0; text-transform: uppercase; letter-spacing: .5px; }

/* ---- COLLECTIONS ---- */
.collection-grid { display: grid; grid-template-columns: repeat(5,1fr); gap: 14px; }
.coll-card { position: relative; border-radius: 12px; overflow: hidden; height: 200px; cursor: pointer; display: block; text-decoration: none; }
.coll-card img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
.coll-card:hover img { transform: scale(1.08); }
.coll-card-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(15,36,84,.75) 0%, rgba(15,36,84,.08) 55%);
    display: flex; flex-direction: column; justify-content: flex-end; padding: 14px;
}
.coll-card-overlay h6 { color: #fff; font-size: 13px; font-weight: 600; margin: 0 0 2px; }
.coll-card-overlay span { color: rgba(255,255,255,.7); font-size: 11px; }

/* ---- LISTED CARDS ---- */
.listed-card { background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(15,36,84,.08); transition: transform .3s, box-shadow .3s; }
.listed-card:hover { transform: translateY(-4px); box-shadow: 0 8px 22px rgba(15,36,84,.12); }
.listed-card-img { height: 165px; overflow: hidden; position: relative; }
.listed-card-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s; }
.listed-card:hover .listed-card-img img { transform: scale(1.06); }
.listed-card-body { padding: 12px 13px 13px; }
.listed-card-body h6 { font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 600; color: #0f2454; margin-bottom: 3px; }
.listed-card-body h6 a { color: inherit; text-decoration: none; }
.listed-card-body h6 a:hover { color: #2095AE; }
.listed-card-loc { font-size: 11px; color: #676977; display: flex; align-items: center; gap: 4px; margin-bottom: 7px; }
.listed-card-loc i { color: #2095AE; }
.listed-card-footer { display: flex; align-items: center; justify-content: space-between; }
.listed-card-meta { font-size: 11px; color: #9a9ca8; display: flex; align-items: center; gap: 3px; }
.listed-card-meta i { color: #e4a853; }
.listed-card-price strong { font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 700; color: #2095AE; }

/* ---- CTA BANNER ---- */
.cta-banner { border-radius: 16px; overflow: hidden; background: #f0f8fc; display: flex; align-items: center; min-height: 210px; }
.cta-banner-img { width: 320px; flex-shrink: 0; height: 210px; overflow: hidden; }
.cta-banner-img img { width: 100%; height: 100%; object-fit: cover; }
.cta-banner-body { padding: 28px 36px; flex: 1; }
.cta-banner-body h3 { font-size: 20px; font-weight: 700; color: #0f2454; margin-bottom: 14px; line-height: 1.3; }
.cta-banner-body h3 span { color: #2095AE; }
.cta-features { display: grid; grid-template-columns: 1fr 1fr; gap: 8px 28px; }
.cta-feature { display: flex; align-items: center; gap: 7px; font-size: 13px; color: #676977; }
.cta-feature-icon { width: 26px; height: 26px; border-radius: 6px; background: #2095AE; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 11px; flex-shrink: 0; }

/* ---- ACTIVITY TABS ---- */
.activity-tabs { display: flex; gap: 6px; margin-bottom: 22px; border-bottom: 2px solid #f4f5f8; padding-bottom: 0; }
.act-tab { padding: 8px 18px; border-radius: 6px 6px 0 0; font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 500; color: #676977; cursor: pointer; border: none; background: transparent; border-bottom: 2px solid transparent; margin-bottom: -2px; transition: color .2s; }
.act-tab.active, .act-tab:hover { color: #2095AE; border-bottom-color: #2095AE; }
.act-tab-content { display: none; }
.act-tab-content.active { display: block; }

/* ---- PARTNER CTA ---- */
.partner-cta {
    background: linear-gradient(135deg, #0f2454 0%, #1a3a6e 100%);
    border-radius: 16px; padding: 44px 40px;
    display: flex; align-items: center; justify-content: space-between; gap: 24px; flex-wrap: wrap;
}
.partner-cta-left h3 { color: #fff; font-size: 22px; font-weight: 700; margin-bottom: 8px; }
.partner-cta-left h3 span { color: #e4a853; }
.partner-cta-left p { color: rgba(255,255,255,.75); font-size: 13px; margin: 0; }
.partner-feats { display: flex; gap: 20px; margin-top: 18px; flex-wrap: wrap; }
.partner-feat { display: flex; align-items: center; gap: 7px; color: rgba(255,255,255,.85); font-size: 13px; }
.partner-feat i { color: #2095AE; font-size: 15px; }
.partner-cta-right { display: flex; gap: 10px; flex-wrap: wrap; }
.btn-partner { padding: 11px 26px; border-radius: 8px; font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 600; text-decoration: none; transition: all .2s; }
.btn-partner-primary { background: #2095AE; color: #fff; border: 2px solid #2095AE; }
.btn-partner-primary:hover { background: #1288a2; border-color: #1288a2; color: #fff; }
.btn-partner-outline { background: transparent; color: #fff; border: 2px solid rgba(255,255,255,.4); }
.btn-partner-outline:hover { background: rgba(255,255,255,.1); color: #fff; }

/* ---- CATEGORY FILTER TABS ---- */
.filter-tabs-wrap { padding: 24px 0 0; }
.filter-tabs {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}
.filter-tab {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 20px;
    border-radius: 30px;
    border: 1.5px solid #e2e6ea;
    background: #fff;
    color: #676977;
    font-family: 'Poppins', sans-serif;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    transition: all .2s;
    text-decoration: none;
}
.filter-tab:hover { border-color: #2095AE; color: #2095AE; }
.filter-tab.active {
    background: #0f2454;
    border-color: #0f2454;
    color: #fff;
}
.filter-tab .tab-icon {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: rgba(255,255,255,.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
}
.filter-tab.active .tab-icon { background: rgba(255,255,255,.25); }
.filter-tab:not(.active) .tab-icon { background: #f4f5f8; color: #676977; }
button.filter-tab { outline: none; }
.deals-panel { display: none; }
.deals-panel.active { display: block; }

/* ---- FILTER BUTTON ---- */
.filter-open-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 18px;
    border-radius: 30px;
    border: 1.5px solid #2095AE;
    background: #fff;
    color: #2095AE;
    font-family: 'Poppins', sans-serif;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all .2s;
    outline: none;
    margin-left: auto;
}
.filter-open-btn:hover { background: #2095AE; color: #fff; }

/* ---- FILTER DRAWER ---- */
.filter-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15,36,84,.45);
    z-index: 1100;
    backdrop-filter: blur(2px);
}
.filter-overlay.open { display: block; }
.filter-drawer {
    position: fixed;
    top: 0;
    left: -360px;
    width: 320px;
    height: 100vh;
    background: #fff;
    z-index: 1101;
    overflow-y: auto;
    transition: left .3s cubic-bezier(.4,0,.2,1);
    display: flex;
    flex-direction: column;
    box-shadow: 4px 0 24px rgba(15,36,84,.15);
}
.filter-drawer.open { left: 0; }
.filter-drawer-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 24px 14px;
    border-bottom: 1px solid #eee;
    position: sticky;
    top: 0;
    background: #fff;
    z-index: 2;
}
.filter-drawer-head h5 { margin: 0; font-size: 17px; font-weight: 700; color: #0f2454; }
.filter-drawer-close {
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    color: #676977;
    line-height: 1;
    padding: 4px;
}
.filter-drawer-close:hover { color: #0f2454; }
.filter-reset-btn {
    background: none;
    border: none;
    cursor: pointer;
    color: #2095AE;
    font-size: 18px;
    padding: 4px;
}
.filter-drawer-body { padding: 20px 24px; flex: 1; }
.filter-group { margin-bottom: 28px; }
.filter-group-title {
    font-family: 'Poppins', sans-serif;
    font-size: 13px;
    font-weight: 700;
    color: #0f2454;
    text-transform: uppercase;
    letter-spacing: .5px;
    margin-bottom: 14px;
}
/* Budget slider */
.budget-range-wrap { display: flex; flex-direction: column; gap: 8px; }
.budget-labels { display: flex; justify-content: space-between; font-size: 12px; color: #676977; }
.budget-values { display: flex; justify-content: space-between; font-size: 13px; font-weight: 600; color: #0f2454; }
input[type="range"].budget-slider {
    -webkit-appearance: none;
    width: 100%;
    height: 4px;
    border-radius: 2px;
    background: linear-gradient(to right, #2095AE 0%, #2095AE var(--val, 50%), #e2e6ea var(--val, 50%), #e2e6ea 100%);
    outline: none;
}
input[type="range"].budget-slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: #2095AE;
    border: 2px solid #fff;
    box-shadow: 0 2px 6px rgba(32,149,174,.4);
    cursor: pointer;
}
/* Star rating */
.star-check-list { display: flex; flex-direction: column; gap: 10px; }
.star-check-item { display: flex; align-items: center; gap: 10px; cursor: pointer; }
.star-check-item input[type="checkbox"] { width: 16px; height: 16px; accent-color: #2095AE; cursor: pointer; }
.star-check-item .stars { color: #e4a853; font-size: 13px; }
.star-check-item span { font-size: 13px; color: #676977; }
/* Category */
.cat-check-list { display: flex; flex-direction: column; gap: 10px; }
.cat-check-item { display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 13px; color: #676977; }
.cat-check-item input[type="checkbox"] { width: 16px; height: 16px; accent-color: #2095AE; cursor: pointer; flex-shrink: 0; }
/* Footer */
.filter-drawer-footer {
    padding: 16px 24px;
    border-top: 1px solid #eee;
    position: sticky;
    bottom: 0;
    background: #fff;
}
.filter-show-btn {
    width: 100%;
    padding: 13px;
    border: none;
    border-radius: 8px;
    background: linear-gradient(135deg, #0f2454 0%, #2095AE 100%);
    color: #fff;
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: opacity .2s;
    outline: none;
}
.filter-show-btn:hover { opacity: .9; }

/* ---- UTILITIES ---- */
.bg-light-gray { background-color: #f4f5f8; }
.section-pad { padding: 60px 0; }
.section-pad-sm { padding: 36px 0; }

/* ---- RESPONSIVE ---- */
@media (max-width: 991px) {
    .collection-grid { grid-template-columns: repeat(3,1fr); }
    .cta-banner { flex-direction: column; }
    .cta-banner-img { width: 100%; height: 200px; }
    .partner-cta { flex-direction: column; }
    .hero-content h1 { font-size: 30px; }
    .stat-item { border-right: none; }
}
@media (max-width: 767px) {
    .collection-grid { grid-template-columns: repeat(2,1fr); }
    .search-bar-wrap { flex-direction: column; }
    .search-bar-field { min-width: 100%; }
    .search-btn { width: 100%; height: 42px; border-radius: 6px; }
    .cta-features { grid-template-columns: 1fr; }
    .hero-content h1 { font-size: 24px; }
    .search-tabs { flex-wrap: wrap; }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>


<section class="hero-wrap" id="kenburnsSliderContainer" data-overlay-dark="4">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="container">
            <h5><?php echo e(\App\Helpers\Cms::setting('home_hero_subtitle', 'Trekking Paradise · Cultural Diversity · Panoramic Views')); ?></h5>
            <h1><?php echo e(\App\Helpers\Cms::setting('home_hero_title', 'Travel: A companion that collects')); ?> <span><?php echo e(\App\Helpers\Cms::setting('home_hero_span', 'memories')); ?></span></h1>
            <p><?php echo e(\App\Helpers\Cms::setting('home_hero_tagline', 'For every trek and adventure, there is Annapurna Region!')); ?></p>

            
            <?php
            $searchConfig = [
                'trekking' => [
                    'placeholder' => 'Trek name, keywords...',
                    'destLabel'   => 'Destination',
                    'route'       => route('trek-routes.index'),
                    'destinations'=> $activeTreks->take(10)->map(fn($t)=>['label'=>$t->name,'value'=>route('trek-routes.index').'?search='.urlencode($t->name)])->values()->toArray(),
                ],
                'hotels' => [
                    'placeholder' => 'Hotel name, keywords...',
                    'destLabel'   => 'Location',
                    'route'       => route('hotels.index'),
                    'destinations'=> $hotels->map(fn($h)=>['label'=>$h->name,'value'=>route('hotels.index').'?search='.urlencode($h->name)])->values()->toArray(),
                ],
                'travel' => [
                    'placeholder' => 'Activity, agency name...',
                    'destLabel'   => 'Category',
                    'route'       => route('travel-agencies.index'),
                    'destinations'=> $destinations->take(8)->map(fn($d)=>['label'=>$d->name,'value'=>route('destinations.show',$d->slug)])->values()->toArray(),
                ],
                'vehicle' => [
                    'placeholder' => 'Vehicle type, route...',
                    'destLabel'   => 'Pick-up Location',
                    'route'       => route('travel-agencies.index'),
                    'destinations'=> [['label'=>'Pokhara','value'=>route('travel-agencies.index').'?search=Pokhara'],['label'=>'Kathmandu','value'=>route('travel-agencies.index').'?search=Kathmandu'],['label'=>'Chitwan','value'=>route('travel-agencies.index').'?search=Chitwan']],
                ],
            ];
            ?>
            <div class="search-panel">
                <ul class="search-tabs">
                    <li class="active" data-search-type="trekking"><a href="#" onclick="return false;">Trekking</a></li>
                    <li data-search-type="vehicle"><a href="#" onclick="return false;">Vehicle Rentals</a></li>
                    <li data-search-type="travel"><a href="#" onclick="return false;">Travel &amp; Activities</a></li>
                    <li data-search-type="hotels"><a href="#" onclick="return false;">Hotels &amp; Stays</a></li>
                </ul>
                <div class="search-bar-wrap">
                    <div class="search-bar-field">
                        <label id="heroSearchLabel">Quick Search</label>
                        <input type="text" id="heroSearch" placeholder="Trek name, keywords...">
                    </div>
                    <div class="search-bar-field">
                        <label id="heroDestLabel">Destination</label>
                        <select id="heroDestination">
                            <option value="">Search Destination</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $activeTreks->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e(route('trek-routes.index')); ?>?search=<?php echo e(urlencode($t->name)); ?>"><?php echo e($t->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeTreks->isEmpty()): ?>
                            <option value="<?php echo e(route('trek-routes.index')); ?>?search=Annapurna+Circuit">Annapurna Circuit</option>
                            <option value="<?php echo e(route('trek-routes.index')); ?>?search=Annapurna+Base+Camp">Annapurna Base Camp</option>
                            <option value="<?php echo e(route('trek-routes.index')); ?>?search=Poon+Hill">Poon Hill</option>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>
                    <div class="search-bar-field">
                        <label>Travel Dates</label>
                        <input type="text" id="heroTravelDate" placeholder="When are you going?" readonly style="cursor:pointer;">
                    </div>
                    <div class="search-bar-field" style="max-width:130px;">
                        <label>Group Size</label>
                        <select id="heroGroupSize">
                            <option value="1">1 Person</option>
                            <option value="2">2 People</option>
                            <option value="5">3–5 People</option>
                            <option value="10">6–10 People</option>
                            <option value="11">10+ People</option>
                        </select>
                    </div>
                    <button class="search-btn" id="heroSearchBtn" title="Search"><i class="ti-search"></i></button>
                </div>
                <div class="cat-pills" id="heroPills">
                    <span>Popular:</span>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $popularTreks->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('trek-routes.index')); ?>?search=<?php echo e(urlencode($t->name)); ?>" class="cat-pill"><?php echo e($t->name); ?></a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($popularTreks->isEmpty()): ?>
                    <a href="<?php echo e(route('trek-routes.index')); ?>?search=Annapurna+Base+Camp" class="cat-pill">Annapurna Base Camp Trek</a>
                    <a href="<?php echo e(route('trek-routes.index')); ?>?search=Annapurna+Circuit" class="cat-pill">Annapurna Circuit Trek</a>
                    <a href="<?php echo e(route('trek-routes.index')); ?>?search=Pokhara" class="cat-pill">Pokhara City Tours</a>
                    <a href="<?php echo e(route('trek-routes.index')); ?>?search=Poon+Hill" class="cat-pill">Poon Hill Trek</a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>


<section style="padding: 28px 0 0;">
    <div class="container">
        <div class="stats-bar">
            <div class="row">
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <h4><?php echo e($statTrekCount > 0 ? $statTrekCount.'+' : \App\Helpers\Cms::setting('home_stat1_value', '500+')); ?></h4>
                        <p><?php echo e(\App\Helpers\Cms::setting('home_stat1_label', 'Trek Routes')); ?></p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <h4><?php echo e($statAgencyCount > 0 ? $statAgencyCount.'+' : \App\Helpers\Cms::setting('home_stat2_value', '200+')); ?></h4>
                        <p><?php echo e(\App\Helpers\Cms::setting('home_stat2_label', 'Travel Agencies')); ?></p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <h4><?php echo e($statHotelCount > 0 ? $statHotelCount.'+' : \App\Helpers\Cms::setting('home_stat3_value', '150+')); ?></h4>
                        <p><?php echo e(\App\Helpers\Cms::setting('home_stat3_label', 'Hotels & Lodges')); ?></p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <h4><?php echo e($statInquiryCount > 0 ? $statInquiryCount.'+' : \App\Helpers\Cms::setting('home_stat4_value', '50k+')); ?></h4>
                        <p><?php echo e(\App\Helpers\Cms::setting('home_stat4_label', 'Happy Trekkers')); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="filter-tabs-wrap">
    <div class="container">
        <div class="filter-tabs" id="categoryFilterTabs">
            <button class="filter-tab active" data-filter="all">
                <span class="tab-icon"><i class="ti-layout-grid2"></i></span>
                All
            </button>
            <button class="filter-tab" data-filter="trekking">
                <span class="tab-icon"><i class="ti-map-alt"></i></span>
                Trekking
            </button>
            <button class="filter-tab" data-filter="hotel">
                <span class="tab-icon"><i class="ti-home"></i></span>
                Hotel
            </button>
            <button class="filter-tab" data-filter="travel-agency">
                <span class="tab-icon"><i class="ti-car"></i></span>
                Travel Agency
            </button>
            <button class="filter-tab" data-filter="destinations">
                <span class="tab-icon"><i class="ti-location-pin"></i></span>
                Destinations
            </button>
            <button class="filter-tab" data-filter="restaurant">
                <span class="tab-icon"><i class="ti-cup"></i></span>
                Restaurant
            </button>
            <button class="filter-open-btn" id="openFilterDrawer">
                <i class="ti-settings"></i> Filters
            </button>
        </div>
    </div>
</section>


<div class="filter-overlay" id="filterOverlay"></div>
<div class="filter-drawer" id="filterDrawer">
    <div class="filter-drawer-head">
        <h5>Filters</h5>
        <div style="display:flex;align-items:center;gap:8px;">
            <button class="filter-reset-btn" id="filterReset" title="Reset filters"><i class="ti-reload"></i></button>
            <button class="filter-drawer-close" id="closeFilterDrawer">&times;</button>
        </div>
    </div>
    <div class="filter-drawer-body">

        
        <div class="filter-group">
            <div class="filter-group-title">Your Budget</div>
            <div class="budget-range-wrap">
                <input type="range" class="budget-slider" id="budgetSlider" min="0" max="10000" step="100" value="5000">
                <div class="budget-values">
                    <span>$0</span>
                    <span id="budgetVal">$5,000</span>
                </div>
            </div>
        </div>

        
        <div class="filter-group">
            <div class="filter-group-title">Star Rating</div>
            <div class="star-check-list">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [5,4,3,2,1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $star): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label class="star-check-item">
                    <input type="checkbox" name="star[]" value="<?php echo e($star); ?>">
                    <span class="stars"><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($s=0;$s<$star;$s++): ?>★<?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></span>
                    <span><?php echo e($star); ?> Star</span>
                </label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        
        <div class="filter-group">
            <div class="filter-group-title">Category</div>
            <div class="cat-check-list">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['Luxury','Standard','Budget','Eco Friendly','Community Based','Premium','Tented Camp','Environment Friendly','Cottage','Villa','Apartment']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label class="cat-check-item">
                    <input type="checkbox" name="category[]" value="<?php echo e(strtolower(str_replace(' ','-',$cat))); ?>">
                    <?php echo e($cat); ?>

                </label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

    </div>
    <div class="filter-drawer-footer">
        <button class="filter-show-btn" id="filterShowResults">Show Results</button>
    </div>
</div>


<section class="section-pad" id="dealsSection">
    <div class="container">
        <div class="sec-head">
            <div class="sec-head-left">
                <div class="sec-tag"><i class="ti-tag"></i> Featured Packages</div>
                <h3>Top Deals on <span>Annapurna Region</span></h3>
            </div>
            <div class="sec-nav">
                <a href="<?php echo e(route('search', ['type'=>'trekking'])); ?>" class="sec-view-all" id="dealsViewAll">View All <i class="ti-arrow-right"></i></a>
                <button class="sec-nav-btn" id="dealsLeft"><i class="ti-angle-left"></i></button>
                <span class="deals-page-info" id="dealsPageInfo">1 / 1</span>
                <button class="sec-nav-btn" id="dealsRight"><i class="ti-angle-right"></i></button>
            </div>
        </div>

        
        <div class="deals-panel active" id="panel-all">
            <div class="owl-carousel owl-theme">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $popularTreks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trek): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="deal-card">
                    <div class="deal-card-img">
                        <?php $img = $trek->featured_image ? (str_starts_with($trek->featured_image,'annapurna/') ? asset($trek->featured_image) : \App\Helpers\Cms::imageUrl($trek->featured_image)) : asset('annapurna/img/tours/annapurna-circuit.jpg'); ?>
                        <img src="<?php echo e($img); ?>" alt="<?php echo e($trek->name); ?>">
                        <span class="deal-badge verified">Verified</span>
                    </div>
                    <div class="deal-card-body">
                        <div class="deal-card-rating"><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><span>5.0</span></div>
                        <div class="deal-card-title"><a href="<?php echo e(route('trek-routes.show', $trek->slug)); ?>"><?php echo e($trek->name); ?></a></div>
                        <div class="deal-card-loc"><i class="ti-location-pin"></i> Gandaki Province, Nepal</div>
                        <div class="deal-card-footer"><div class="deal-card-price"><small>Starting From</small><strong><?php echo e($trek->price_range ?? 'On Request'); ?></strong></div></div>
                        <div class="deal-card-meta"><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($trek->duration_days): ?><span><i class="ti-time"></i> <?php echo e($trek->duration_days); ?> Days</span><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($trek->group_size_min): ?><span><i class="ti-user"></i> <?php echo e($trek->group_size_min); ?>+</span><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $hotels->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hotel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="deal-card">
                    <div class="deal-card-img">
                        <?php $img = $hotel->featured_image ? \App\Helpers\Cms::imageUrl($hotel->featured_image) : asset('annapurna/img/hotels/temple-tree-resort-annapurna-region1.jpg'); ?>
                        <img src="<?php echo e($img); ?>" alt="<?php echo e($hotel->name); ?>">
                        <span class="deal-badge verified">Hotel</span>
                    </div>
                    <div class="deal-card-body">
                        <div class="deal-card-rating"><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><span>5.0</span></div>
                        <div class="deal-card-title"><a href="<?php echo e(route('hotels.show', $hotel->slug)); ?>"><?php echo e($hotel->name); ?></a></div>
                        <div class="deal-card-loc"><i class="ti-location-pin"></i> <?php echo e($hotel->city ?? $hotel->address ?? 'Pokhara, Nepal'); ?></div>
                        <div class="deal-card-footer"><div class="deal-card-price"><small>Starting From</small><strong>On Request</strong></div></div>
                        <div class="deal-card-meta"><span><i class="ti-home"></i> Hotel</span></div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $destinations->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="deal-card">
                    <div class="deal-card-img">
                        <?php $img = $dest->featured_image ? \App\Helpers\Cms::imageUrl($dest->featured_image) : asset('annapurna/img/destination/pokhara-city-tours.png'); ?>
                        <img src="<?php echo e($img); ?>" alt="<?php echo e($dest->name); ?>">
                        <span class="deal-badge hot">Destination</span>
                    </div>
                    <div class="deal-card-body">
                        <div class="deal-card-rating"><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><span>5.0</span></div>
                        <div class="deal-card-title"><a href="<?php echo e(route('destinations.show', $dest->slug)); ?>"><?php echo e($dest->name); ?></a></div>
                        <div class="deal-card-loc"><i class="ti-location-pin"></i> Annapurna Region, Nepal</div>
                        <div class="deal-card-footer"><div class="deal-card-price"><small>Starting From</small><strong>On Request</strong></div></div>
                        <div class="deal-card-meta"><span><i class="ti-location-pin"></i> Destination</span></div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($popularTreks->isEmpty() && $hotels->isEmpty() && $destinations->isEmpty()): ?>
                <?php
                $staticDeals = [
                    ['title'=>'Annapurna Circuit Trek','price'=>'$1,500','days'=>'7–15','group'=>'10+','loc'=>'Gandaki Province, Nepal','img'=>asset('annapurna/img/destination/annapurna-circuit1.jpg'),'badge'=>'hot','badge_label'=>'HOT DEAL','url'=>route('trek-routes.index')],
                    ['title'=>'Annapurna Base Camp Trek','price'=>'$2,200','days'=>'10–14','group'=>'12+','loc'=>'Annapurna Region, Nepal','img'=>asset('annapurna/img/destination/annapurna-circuit.png'),'badge'=>'verified','badge_label'=>'Verified','url'=>route('trek-routes.index')],
                    ['title'=>'Ghorepani Poon Hill Trek','price'=>'$650','days'=>'4–7','group'=>'8+','loc'=>'Myagdi District, Nepal','img'=>asset('annapurna/img/destination/ghorepani-poon-hill.png'),'badge'=>'verified','badge_label'=>'Verified','url'=>route('trek-routes.index')],
                    ['title'=>'Pokhara City Tour','price'=>'$350','days'=>'3–5','group'=>'10+','loc'=>'Kaski District, Nepal','img'=>asset('annapurna/img/destination/pokhara-city-tours.png'),'badge'=>'new','badge_label'=>'NEW','url'=>route('trek-routes.index')],
                    ['title'=>'Mardi Himal Trek','price'=>'$800','days'=>'6–9','group'=>'6+','loc'=>'Kaski District, Nepal','img'=>asset('annapurna/img/destination/mardi-himal-trek.jpg'),'badge'=>'verified','badge_label'=>'Verified','url'=>route('trek-routes.index')],
                    ['title'=>'Upper Mustang Trek','price'=>'$3,200','days'=>'14–18','group'=>'8+','loc'=>'Mustang District, Nepal','img'=>asset('annapurna/img/destination/upper-mustang.png'),'badge'=>'hot','badge_label'=>'HOT DEAL','url'=>route('trek-routes.index')],
                ];
                ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $staticDeals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="deal-card">
                    <div class="deal-card-img"><img src="<?php echo e($d['img']); ?>" alt="<?php echo e($d['title']); ?>"><span class="deal-badge <?php echo e($d['badge']); ?>"><?php echo e($d['badge_label']); ?></span></div>
                    <div class="deal-card-body">
                        <div class="deal-card-rating"><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><span>5.0</span></div>
                        <div class="deal-card-title"><a href="<?php echo e($d['url']); ?>"><?php echo e($d['title']); ?></a></div>
                        <div class="deal-card-loc"><i class="ti-location-pin"></i> <?php echo e($d['loc']); ?></div>
                        <div class="deal-card-footer"><div class="deal-card-price"><small>Starting From</small><strong><?php echo e($d['price']); ?></strong></div></div>
                        <div class="deal-card-meta"><span><i class="ti-time"></i> <?php echo e($d['days']); ?> Days</span><span><i class="ti-user"></i> <?php echo e($d['group']); ?></span></div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        
        <div class="deals-panel" id="panel-trekking">
            <div class="owl-carousel owl-theme">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $popularTreks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trek): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="deal-card">
                    <div class="deal-card-img">
                        <?php $img = $trek->featured_image ? (str_starts_with($trek->featured_image,'annapurna/') ? asset($trek->featured_image) : \App\Helpers\Cms::imageUrl($trek->featured_image)) : asset('annapurna/img/tours/annapurna-circuit.jpg'); ?>
                        <img src="<?php echo e($img); ?>" alt="<?php echo e($trek->name); ?>">
                        <span class="deal-badge verified">Verified</span>
                    </div>
                    <div class="deal-card-body">
                        <div class="deal-card-rating"><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><span>5.0</span></div>
                        <div class="deal-card-title"><a href="<?php echo e(route('trek-routes.show', $trek->slug)); ?>"><?php echo e($trek->name); ?></a></div>
                        <div class="deal-card-loc"><i class="ti-location-pin"></i> Gandaki Province, Nepal</div>
                        <div class="deal-card-footer"><div class="deal-card-price"><small>Starting From</small><strong><?php echo e($trek->price_range ?? 'On Request'); ?></strong></div></div>
                        <div class="deal-card-meta"><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($trek->duration_days): ?><span><i class="ti-time"></i> <?php echo e($trek->duration_days); ?> Days</span><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($trek->group_size_min): ?><span><i class="ti-user"></i> <?php echo e($trek->group_size_min); ?>+</span><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="deal-card"><div class="deal-card-img"><img src="<?php echo e(asset('annapurna/img/destination/annapurna-circuit1.jpg')); ?>" alt="Annapurna Circuit Trek"><span class="deal-badge hot">HOT DEAL</span></div><div class="deal-card-body"><div class="deal-card-rating"><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><span>5.0</span></div><div class="deal-card-title"><a href="<?php echo e(route('trek-routes.index')); ?>">Annapurna Circuit Trek</a></div><div class="deal-card-loc"><i class="ti-location-pin"></i> Gandaki Province, Nepal</div><div class="deal-card-footer"><div class="deal-card-price"><small>Starting From</small><strong>$1,500</strong></div></div><div class="deal-card-meta"><span><i class="ti-time"></i> 7–15 Days</span><span><i class="ti-user"></i> 10+</span></div></div></div>
                <div class="deal-card"><div class="deal-card-img"><img src="<?php echo e(asset('annapurna/img/destination/ghorepani-poon-hill.png')); ?>" alt="Ghorepani Poon Hill"><span class="deal-badge verified">Verified</span></div><div class="deal-card-body"><div class="deal-card-rating"><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><span>5.0</span></div><div class="deal-card-title"><a href="<?php echo e(route('trek-routes.index')); ?>">Ghorepani Poon Hill Trek</a></div><div class="deal-card-loc"><i class="ti-location-pin"></i> Myagdi District, Nepal</div><div class="deal-card-footer"><div class="deal-card-price"><small>Starting From</small><strong>$650</strong></div></div><div class="deal-card-meta"><span><i class="ti-time"></i> 4–7 Days</span><span><i class="ti-user"></i> 8+</span></div></div></div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        
        <div class="deals-panel" id="panel-hotel">
            <div class="owl-carousel owl-theme">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $hotels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hotel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="deal-card">
                    <div class="deal-card-img">
                        <?php $img = $hotel->featured_image ? \App\Helpers\Cms::imageUrl($hotel->featured_image) : asset('annapurna/img/hotels/temple-tree-resort-annapurna-region1.jpg'); ?>
                        <img src="<?php echo e($img); ?>" alt="<?php echo e($hotel->name); ?>">
                        <span class="deal-badge verified">Hotel</span>
                    </div>
                    <div class="deal-card-body">
                        <div class="deal-card-rating"><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><span>5.0</span></div>
                        <div class="deal-card-title"><a href="<?php echo e(route('hotels.show', $hotel->slug)); ?>"><?php echo e($hotel->name); ?></a></div>
                        <div class="deal-card-loc"><i class="ti-location-pin"></i> <?php echo e($hotel->city ?? $hotel->address ?? 'Pokhara, Nepal'); ?></div>
                        <div class="deal-card-footer"><div class="deal-card-price"><small>Starting From</small><strong>On Request</strong></div></div>
                        <div class="deal-card-meta"><span><i class="ti-home"></i> Hotel</span></div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="deal-card"><div class="deal-card-img"><img src="<?php echo e(asset('annapurna/img/hotels/temple-tree-resort-annapurna-region1.jpg')); ?>" alt="Temple Tree Resort"><span class="deal-badge verified">Hotel</span></div><div class="deal-card-body"><div class="deal-card-rating"><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><span>5.0</span></div><div class="deal-card-title"><a href="<?php echo e(route('hotels.index')); ?>">Temple Tree Resort</a></div><div class="deal-card-loc"><i class="ti-location-pin"></i> Pokhara, Nepal</div><div class="deal-card-footer"><div class="deal-card-price"><small>Starting From</small><strong>On Request</strong></div></div><div class="deal-card-meta"><span><i class="ti-home"></i> Hotel</span></div></div></div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        
        <div class="deals-panel" id="panel-travel-agency">
            <div class="owl-carousel owl-theme">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $travelAgencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="deal-card">
                    <div class="deal-card-img">
                        <?php $img = $agency->featured_image ? \App\Helpers\Cms::imageUrl($agency->featured_image) : asset('annapurna/img/destination/pokhara-city-tours.png'); ?>
                        <img src="<?php echo e($img); ?>" alt="<?php echo e($agency->name); ?>">
                        <span class="deal-badge verified">Agency</span>
                    </div>
                    <div class="deal-card-body">
                        <div class="deal-card-rating"><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><span>5.0</span></div>
                        <div class="deal-card-title"><a href="<?php echo e(route('businesses.show', $agency->slug)); ?>"><?php echo e($agency->name); ?></a></div>
                        <div class="deal-card-loc"><i class="ti-location-pin"></i> <?php echo e($agency->city ?? $agency->address ?? 'Nepal'); ?></div>
                        <div class="deal-card-footer"><div class="deal-card-price"><small>Starting From</small><strong>On Request</strong></div></div>
                        <div class="deal-card-meta"><span><i class="ti-car"></i> Travel Agency</span></div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="deal-card"><div class="deal-card-img"><img src="<?php echo e(asset('annapurna/img/destination/pokhara-city-tours.png')); ?>" alt="Travel Agency"><span class="deal-badge verified">Agency</span></div><div class="deal-card-body"><div class="deal-card-rating"><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><span>5.0</span></div><div class="deal-card-title"><a href="<?php echo e(route('travel-agencies.index')); ?>">Explore Travel Agencies</a></div><div class="deal-card-loc"><i class="ti-location-pin"></i> Pokhara, Nepal</div><div class="deal-card-footer"><div class="deal-card-price"><small>Starting From</small><strong>On Request</strong></div></div><div class="deal-card-meta"><span><i class="ti-car"></i> Travel Agency</span></div></div></div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        
        <div class="deals-panel" id="panel-destinations">
            <div class="owl-carousel owl-theme">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $destinations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="deal-card">
                    <div class="deal-card-img">
                        <?php $img = $dest->featured_image ? \App\Helpers\Cms::imageUrl($dest->featured_image) : asset('annapurna/img/destination/pokhara-city-tours.png'); ?>
                        <img src="<?php echo e($img); ?>" alt="<?php echo e($dest->name); ?>">
                        <span class="deal-badge hot">Destination</span>
                    </div>
                    <div class="deal-card-body">
                        <div class="deal-card-rating"><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><span>5.0</span></div>
                        <div class="deal-card-title"><a href="<?php echo e(route('destinations.show', $dest->slug)); ?>"><?php echo e($dest->name); ?></a></div>
                        <div class="deal-card-loc"><i class="ti-location-pin"></i> Annapurna Region, Nepal</div>
                        <div class="deal-card-footer"><div class="deal-card-price"><small>Starting From</small><strong>On Request</strong></div></div>
                        <div class="deal-card-meta"><span><i class="ti-location-pin"></i> Destination</span></div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="deal-card"><div class="deal-card-img"><img src="<?php echo e(asset('annapurna/img/destination/pokhara-sightseeing.jpg')); ?>" alt="Pokhara"><span class="deal-badge hot">Destination</span></div><div class="deal-card-body"><div class="deal-card-rating"><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><span>5.0</span></div><div class="deal-card-title"><a href="<?php echo e(route('destinations.index')); ?>">Explore Destinations</a></div><div class="deal-card-loc"><i class="ti-location-pin"></i> Annapurna Region, Nepal</div><div class="deal-card-footer"><div class="deal-card-price"><small>Starting From</small><strong>On Request</strong></div></div><div class="deal-card-meta"><span><i class="ti-location-pin"></i> Destination</span></div></div></div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        
        <div class="deals-panel" id="panel-restaurant">
            <div class="owl-carousel owl-theme">
                <div class="deal-card"><div class="deal-card-img"><img src="<?php echo e(asset('annapurna/img/destination/pokhara-city-tours.png')); ?>" alt="Restaurants in Pokhara"><span class="deal-badge new" style="background:#e4a853;color:#0f2454;">Popular</span></div><div class="deal-card-body"><div class="deal-card-rating"><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><span>5.0</span></div><div class="deal-card-title"><a href="<?php echo e(route('restaurants.index')); ?>">Restaurants in Pokhara</a></div><div class="deal-card-loc"><i class="ti-location-pin"></i> Lakeside, Pokhara</div><div class="deal-card-footer"><div class="deal-card-price"><small>Starting From</small><strong>On Request</strong></div></div><div class="deal-card-meta"><span><i class="ti-cup"></i> Dining</span></div></div></div>
                <div class="deal-card"><div class="deal-card-img"><img src="<?php echo e(asset('annapurna/img/destination/paragliding-pokhara.jpg')); ?>" alt="Lakeside Dining"><span class="deal-badge verified">Verified</span></div><div class="deal-card-body"><div class="deal-card-rating"><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><span>5.0</span></div><div class="deal-card-title"><a href="<?php echo e(route('restaurants.index')); ?>">Lakeside Dining Experience</a></div><div class="deal-card-loc"><i class="ti-location-pin"></i> Phewa Lake, Pokhara</div><div class="deal-card-footer"><div class="deal-card-price"><small>Starting From</small><strong>On Request</strong></div></div><div class="deal-card-meta"><span><i class="ti-cup"></i> Restaurant</span></div></div></div>
            </div>
        </div>

    </div>
</section>


<section class="section-pad bg-light-gray">
    <div class="container">
        <div class="sec-head">
            <div class="sec-head-left">
                <div class="sec-tag"><i class="ti-bookmark-alt"></i> Categories</div>
                <h3>Browse by <span>Collections</span></h3>
            </div>
        </div>
        <div class="collection-grid">
            <a href="<?php echo e(route('trek-routes.index')); ?>" class="coll-card">
                <img src="<?php echo e(asset('annapurna/img/destination/annapurna-circuit1.jpg')); ?>" alt="Trekking Routes">
                <div class="coll-card-overlay"><h6>Trekking Routes</h6><span>12+ Routes</span></div>
            </a>
            <a href="<?php echo e(route('hotels.index')); ?>" class="coll-card">
                <img src="<?php echo e(asset('annapurna/img/hotels/temple-tree-resort-annapurna-region1.jpg')); ?>" alt="Luxury Stays">
                <div class="coll-card-overlay"><h6>Luxury Stays</h6><span>40+ Properties</span></div>
            </a>
            <a href="<?php echo e(route('destinations.index')); ?>" class="coll-card">
                <img src="<?php echo e(asset('annapurna/img/destination/paragliding-pokhara.jpg')); ?>" alt="Adventure Sports">
                <div class="coll-card-overlay"><h6>Adventure Sports</h6><span>8+ Activities</span></div>
            </a>
            <a href="<?php echo e(route('trek-routes.index')); ?>" class="coll-card">
                <img src="<?php echo e(asset('annapurna/img/destination/annapurna-base-camp-abc.png')); ?>" alt="Himalaya Treks">
                <div class="coll-card-overlay"><h6>Himalaya Treks</h6><span>7+ Destinations</span></div>
            </a>
            <a href="<?php echo e(route('destinations.index')); ?>" class="coll-card">
                <img src="<?php echo e(asset('annapurna/img/destination/ghandruk-village-annapurna.png')); ?>" alt="Cultural Heritage">
                <div class="coll-card-overlay"><h6>Cultural Heritage</h6><span>10+ Experiences</span></div>
            </a>
        </div>
    </div>
</section>


<section class="section-pad">
    <div class="container">
        <div class="sec-head">
            <div class="sec-head-left">
                <div class="sec-tag"><i class="ti-home"></i> Fresh Listings</div>
                <h3>Recently Added <span>Partners</span></h3>
            </div>
            <div class="sec-nav">
                <button class="sec-nav-btn" id="listedLeft"><i class="ti-angle-left"></i></button>
                <button class="sec-nav-btn" id="listedRight"><i class="ti-angle-right"></i></button>
            </div>
        </div>

        <div class="owl-carousel owl-theme" id="listedCarousel">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $hotels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hotel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="listed-card">
                <div class="listed-card-img">
                    <?php
                        $hImg = $hotel->cover_photo
                            ? \App\Helpers\Cms::imageUrl($hotel->cover_photo)
                            : asset('annapurna/img/hotels/hotel-barahi-annapurna-region1.jpg');
                    ?>
                    <img src="<?php echo e($hImg); ?>" alt="<?php echo e($hotel->name); ?>">
                    <span class="deal-badge verified" style="top:8px;left:8px;font-size:9px;">Verified</span>
                </div>
                <div class="listed-card-body">
                    <h6><a href="<?php echo e(route('hotels.show', $hotel->slug)); ?>"><?php echo e($hotel->name); ?></a></h6>
                    <div class="listed-card-loc"><i class="ti-location-pin"></i> <?php echo e($hotel->city ?? $hotel->location ?? 'Nepal'); ?></div>
                    <div class="listed-card-footer">
                        <div class="listed-card-meta"><i class="ti-star"></i> <?php echo e(number_format($hotel->ranking_score ?? 5, 1)); ?></div>
                        <div class="listed-card-price"><small>From</small> <strong>On Request</strong></div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <?php
            $listedItems = [
                ['name'=>'Temple Tree Resort & Spa','loc'=>'Lakeside, Pokhara','rating'=>'5.0','price'=>'$85/night','img'=>asset('annapurna/img/hotels/temple-tree-resort-annapurna-region1.jpg'),'url'=>route('hotels.index')],
                ['name'=>'Hotel Barahi','loc'=>'Lakeside 6, Pokhara','rating'=>'4.8','price'=>'$65/night','img'=>asset('annapurna/img/hotels/hotel-barahi-annapurna-region1.jpg'),'url'=>route('hotels.index')],
                ['name'=>'Himalayan Wonders Treks','loc'=>'Thamel, Kathmandu','rating'=>'4.9','price'=>'$850/trek','img'=>asset('annapurna/img/tours/annapurna-base-camp.jpg'),'url'=>route('travel-agencies.index')],
                ['name'=>'Snowland Hotel','loc'=>'Lakeside, Pokhara','rating'=>'4.6','price'=>'$40/night','img'=>asset('annapurna/img/hotels/snowland-annapurna-region1.jpg'),'url'=>route('hotels.index')],
                ['name'=>'Pokhara Valley Tours','loc'=>'Pokhara, Nepal','rating'=>'4.7','price'=>'$120/day','img'=>asset('annapurna/img/destination/pokhara-sightseeing.jpg'),'url'=>route('travel-agencies.index')],
            ];
            ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $listedItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="listed-card">
                <div class="listed-card-img">
                    <img src="<?php echo e($item['img']); ?>" alt="<?php echo e($item['name']); ?>">
                </div>
                <div class="listed-card-body">
                    <h6><a href="<?php echo e($item['url']); ?>"><?php echo e($item['name']); ?></a></h6>
                    <div class="listed-card-loc"><i class="ti-location-pin"></i> <?php echo e($item['loc']); ?></div>
                    <div class="listed-card-footer">
                        <div class="listed-card-meta"><i class="ti-star"></i> <?php echo e($item['rating']); ?></div>
                        <div class="listed-card-price"><small>From</small> <strong><?php echo e($item['price']); ?></strong></div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</section>


<section class="section-pad-sm">
    <div class="container">
        <div class="cta-banner">
            <div class="cta-banner-img">
                <img src="<?php echo e(asset('annapurna/img/destination/transport-annapurna-region.jpg')); ?>" alt="Transport Service">
            </div>
            <div class="cta-banner-body">
                <h3>Transport &amp; Transfer Services<br>made easier with <span>Annapurna Region</span></h3>
                <div class="cta-features">
                    <div class="cta-feature"><div class="cta-feature-icon"><i class="ti-check"></i></div> Easy Booking</div>
                    <div class="cta-feature"><div class="cta-feature-icon"><i class="ti-map-alt"></i></div> Trekking Transfers</div>
                    <div class="cta-feature"><div class="cta-feature-icon"><i class="ti-location-arrow"></i></div> Airport Pickup &amp; Drop</div>
                    <div class="cta-feature"><div class="cta-feature-icon"><i class="ti-money"></i></div> Best Deals</div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="section-pad bg-light-gray">
    <div class="container">
        <div class="sec-head">
            <div class="sec-head-left">
                <div class="sec-tag"><i class="ti-heart"></i> Experiences</div>
                <h3>Popular <span>Activities</span></h3>
            </div>
        </div>

        <div class="activity-tabs">
            <button class="act-tab active" data-content="trek-content">Trekking</button>
            <button class="act-tab" data-content="sight-content">Sightseeing</button>
            <button class="act-tab" data-content="mount-content">Mountaineering</button>
        </div>

        
        <div class="act-tab-content active" id="trek-content">
            <div class="row">
                <div class="col-md-5">
                    <div class="country country1">
                        <div class="section-title2"><?php echo e(\App\Helpers\Cms::setting('home_trekking_title', 'Trekking in Nepal')); ?></div>
                        <p>The Annapurna Region is a <b>heaven for trekkers</b> — from Himalayan peaks to subtropical forests, alpine meadows, and high mountain deserts.</p>
                        <div class="row tour-list">
                            <div class="col-md-6">
                                <ul>
                                    <?php $treksLeft = $activeTreks->take(3); ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $treksLeft; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <li><i class="ti-location-pin"></i> <a href="<?php echo e(route('trek-routes.show', $t->slug)); ?>" class="link-btn"><?php echo e($t->name); ?></a></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <li><i class="ti-location-pin"></i> <a href="<?php echo e(route('trek-routes.index')); ?>" class="link-btn">Annapurna Circuit Trek</a></li>
                                    <li><i class="ti-location-pin"></i> <a href="<?php echo e(route('trek-routes.index')); ?>" class="link-btn">Annapurna Base Camp</a></li>
                                    <li><i class="ti-location-pin"></i> <a href="<?php echo e(route('trek-routes.index')); ?>" class="link-btn">Tilicho Lake Trek</a></li>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul>
                                    <?php $treksRight = $activeTreks->skip(3)->take(3); ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $treksRight; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <li><i class="ti-location-pin"></i> <a href="<?php echo e(route('trek-routes.show', $t->slug)); ?>" class="link-btn"><?php echo e($t->name); ?></a></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <li><i class="ti-location-pin"></i> <a href="<?php echo e(route('trek-routes.index')); ?>" class="link-btn">Ghorepani Poon Hill</a></li>
                                    <li><i class="ti-location-pin"></i> <a href="<?php echo e(route('trek-routes.index')); ?>" class="link-btn">Mardi Himal Trek</a></li>
                                    <li><i class="ti-location-pin"></i> <a href="<?php echo e(route('trek-routes.index')); ?>" class="link-btn">Jomsom – Muktinath</a></li>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="butn-dark mt-30 mb-30"><a href="<?php echo e(route('trek-routes.index')); ?>"><span>Explore All Treks <i class="ti-arrow-right"></i></span></a></div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="owl-carousel owl-theme">
                        <div class="item">
                            <div class="position-re o-hidden"><img src="<?php echo e(asset('annapurna/img/destination/annapurna-circuit1.jpg')); ?>" alt="Annapurna Circuit"></div>
                            <span class="category"><a href="<?php echo e(route('trek-routes.index')); ?>">$1,500–$3,000</a></span>
                            <div class="con"><h5><a href="<?php echo e(route('trek-routes.index')); ?>">Annapurna Circuit</a></h5><div class="line"></div><div class="row facilities"><div class="col col-md-12"><ul><li><i class="ti-time"></i> 7-15 Days</li><li><i class="ti-user"></i> 10+</li><li><i class="ti-location-pin"></i> Nepal</li></ul></div></div></div>
                        </div>
                        <div class="item">
                            <div class="position-re o-hidden"><img src="<?php echo e(asset('annapurna/img/destination/ghorepani-hill-trek.jpg')); ?>" alt="Ghorepani Hill Trek"></div>
                            <span class="category"><a href="<?php echo e(route('trek-routes.index')); ?>">$300–$1,300</a></span>
                            <div class="con"><h5><a href="<?php echo e(route('trek-routes.index')); ?>">Ghorepani Hill Trek</a></h5><div class="line"></div><div class="row facilities"><div class="col col-md-12"><ul><li><i class="ti-time"></i> 4-15 Days</li><li><i class="ti-user"></i> 8+</li><li><i class="ti-location-pin"></i> Nepal</li></ul></div></div></div>
                        </div>
                        <div class="item">
                            <div class="position-re o-hidden"><img src="<?php echo e(asset('annapurna/img/destination/mardi-himal-trek.jpg')); ?>" alt="Mardi Himal Trek"></div>
                            <span class="category"><a href="<?php echo e(route('trek-routes.index')); ?>">$800–$1,500</a></span>
                            <div class="con"><h5><a href="<?php echo e(route('trek-routes.index')); ?>">Mardi Himal Trek</a></h5><div class="line"></div><div class="row facilities"><div class="col col-md-12"><ul><li><i class="ti-time"></i> 6-9 Days</li><li><i class="ti-user"></i> 6+</li><li><i class="ti-location-pin"></i> Nepal</li></ul></div></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="act-tab-content" id="sight-content">
            <div class="row">
                <div class="col-md-5">
                    <div class="country country1">
                        <div class="section-title2">Sightseeing in Pokhara</div>
                        <p><b>Pokhara is the vibrant gateway to the Annapurna Region.</b> Enjoy paragliding, boating on Phewa Lake, and sunrise views at Sarangkot.</p>
                        <div class="row tour-list">
                            <div class="col-md-6"><ul>
                                <li><i class="ti-location-pin"></i> <a href="<?php echo e(route('destinations.index')); ?>" class="link-btn">Phewa Lake Boating</a></li>
                                <li><i class="ti-location-pin"></i> <a href="<?php echo e(route('destinations.index')); ?>" class="link-btn">Paragliding</a></li>
                                <li><i class="ti-location-pin"></i> <a href="<?php echo e(route('destinations.index')); ?>" class="link-btn">Sarangkot Sunrise</a></li>
                            </ul></div>
                            <div class="col-md-6"><ul>
                                <li><i class="ti-location-pin"></i> <a href="<?php echo e(route('destinations.index')); ?>" class="link-btn">World Peace Pagoda</a></li>
                                <li><i class="ti-location-pin"></i> <a href="<?php echo e(route('destinations.index')); ?>" class="link-btn">Mountain Museum</a></li>
                                <li><i class="ti-location-pin"></i> <a href="<?php echo e(route('destinations.index')); ?>" class="link-btn">Devi's Falls</a></li>
                            </ul></div>
                        </div>
                        <div class="butn-dark mt-30 mb-30"><a href="<?php echo e(route('destinations.index')); ?>"><span>Explore Pokhara <i class="ti-arrow-right"></i></span></a></div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="owl-carousel owl-theme">
                        <div class="item">
                            <div class="position-re o-hidden"><img src="<?php echo e(asset('annapurna/img/destination/pokhara-sightseeing.jpg')); ?>" alt="Pokhara Sightseeing"></div>
                            <span class="category"><a href="<?php echo e(route('destinations.index')); ?>">$350–$800</a></span>
                            <div class="con"><h5><a href="<?php echo e(route('destinations.index')); ?>">Pokhara Sightseeing</a></h5><div class="line"></div><div class="row facilities"><div class="col col-md-12"><ul><li><i class="ti-time"></i> 3-5 Days</li><li><i class="ti-user"></i> 10+</li><li><i class="ti-location-pin"></i> Nepal</li></ul></div></div></div>
                        </div>
                        <div class="item">
                            <div class="position-re o-hidden"><img src="<?php echo e(asset('annapurna/img/destination/paragliding-pokhara.jpg')); ?>" alt="Paragliding Pokhara"></div>
                            <span class="category"><a href="<?php echo e(route('destinations.index')); ?>">$120–$250</a></span>
                            <div class="con"><h5><a href="<?php echo e(route('destinations.index')); ?>">Paragliding in Pokhara</a></h5><div class="line"></div><div class="row facilities"><div class="col col-md-12"><ul><li><i class="ti-time"></i> 1-2 Days</li><li><i class="ti-user"></i> 2+</li><li><i class="ti-location-pin"></i> Nepal</li></ul></div></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="act-tab-content" id="mount-content">
            <div class="row">
                <div class="col-md-5">
                    <div class="country country1">
                        <div class="section-title2">Mountaineering &amp; Expedition</div>
                        <p><b>Annapurna I (8,091 m)</b> was the first 8,000-meter peak ever summited. The region offers both technical expeditions and accessible peaks.</p>
                        <div class="row tour-list">
                            <div class="col-md-6"><ul>
                                <li><i class="ti-location-pin"></i> <a href="<?php echo e(route('destinations.index')); ?>" class="link-btn">Annapurna I (8,091m)</a></li>
                                <li><i class="ti-location-pin"></i> <a href="<?php echo e(route('destinations.index')); ?>" class="link-btn">Machapuchare (6,993m)</a></li>
                                <li><i class="ti-location-pin"></i> <a href="<?php echo e(route('destinations.index')); ?>" class="link-btn">Tent Peak (5,695m)</a></li>
                            </ul></div>
                            <div class="col-md-6"><ul>
                                <li><i class="ti-location-pin"></i> <a href="<?php echo e(route('destinations.index')); ?>" class="link-btn">Singu Chuli (6,501m)</a></li>
                                <li><i class="ti-location-pin"></i> <a href="<?php echo e(route('destinations.index')); ?>" class="link-btn">Pisang Peak (6,091m)</a></li>
                                <li><i class="ti-location-pin"></i> <a href="<?php echo e(route('destinations.index')); ?>" class="link-btn">Annapurna South</a></li>
                            </ul></div>
                        </div>
                        <div class="butn-dark mt-30 mb-30"><a href="<?php echo e(route('destinations.index')); ?>"><span>All Expeditions <i class="ti-arrow-right"></i></span></a></div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="owl-carousel owl-theme">
                        <div class="item">
                            <div class="position-re o-hidden"><img src="<?php echo e(asset('annapurna/img/destination/machhapuchree-expedition.jpg')); ?>" alt="Machapuchare"></div>
                            <span class="category"><a href="<?php echo e(route('destinations.index')); ?>">$1,250–$2,500</a></span>
                            <div class="con"><h5><a href="<?php echo e(route('destinations.index')); ?>">Machapuchare Trek</a></h5><div class="line"></div><div class="row facilities"><div class="col col-md-12"><ul><li><i class="ti-time"></i> 7-14 Days</li><li><i class="ti-user"></i> 12+</li><li><i class="ti-location-pin"></i> Nepal</li></ul></div></div></div>
                        </div>
                        <div class="item">
                            <div class="position-re o-hidden"><img src="<?php echo e(asset('annapurna/img/destination/pisang-peak.jpg')); ?>" alt="Pisang Peak"></div>
                            <span class="category"><a href="<?php echo e(route('destinations.index')); ?>">$1,500–$2,500</a></span>
                            <div class="con"><h5><a href="<?php echo e(route('destinations.index')); ?>">Pisang Peak Trek</a></h5><div class="line"></div><div class="row facilities"><div class="col col-md-12"><ul><li><i class="ti-time"></i> 4-7 Days</li><li><i class="ti-user"></i> 6+</li><li><i class="ti-location-pin"></i> Nepal</li></ul></div></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="section-pad">
    <div class="container">
        <div class="partner-cta">
            <div class="partner-cta-left">
                <h3>List Your Business on <span>Annapurna Region</span></h3>
                <p>Reach thousands of trekkers &amp; travelers. List your travel agency, hotel, or adventure service.</p>
                <div class="partner-feats">
                    <div class="partner-feat"><i class="ti-user"></i> Verified Listings</div>
                    <div class="partner-feat"><i class="ti-stats-up"></i> Analytics Dashboard</div>
                    <div class="partner-feat"><i class="ti-shopping-cart"></i> Direct Bookings</div>
                    <div class="partner-feat"><i class="ti-check-box"></i> Premium Visibility</div>
                </div>
            </div>
            <div class="partner-cta-right">
                <a href="<?php echo e(route('contact')); ?>" class="btn-partner btn-partner-primary">Partner with Us</a>
                <a href="<?php echo e(route('about')); ?>" class="btn-partner btn-partner-outline">Learn More</a>
            </div>
        </div>
    </div>
</section>


<?php $heroPhone = \App\Helpers\Cms::contactInfo()['phone']; ?>
<section class="testimonials">
    <div class="background bg-img bg-fixed section-padding pb-0" data-background="<?php echo e(asset('annapurna/img/slider/panaromic.jpg')); ?>" data-overlay-dark="5">
        <div class="container">
            <div class="row">
                <div class="col-md-5 mb-30 mt-30">
                    <p><i class="star-rating"></i><i class="star-rating"></i><i class="star-rating"></i><i class="star-rating"></i><i class="star-rating"></i></p>
                    <h5><?php echo e(\App\Helpers\Cms::setting('home_testimonials_heading', 'Reflections on the Majesty of Annapurna from Legends and Explorers')); ?></h5>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($heroPhone): ?>
                    <div class="phone-call mb-10">
                        <div class="icon color-1"><span class="flaticon-phone-call"></span></div>
                        <div class="text">
                            <p class="color-1">Call Now</p>
                            <a class="color-1" href="tel:<?php echo e($heroPhone); ?>"><?php echo e($heroPhone); ?></a>
                        </div>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <p><i class="ti-check"></i><small>Contact us to list your business, packages &amp; itineraries.</small></p>
                    <div class="butn-light mt-20 mb-10"><a href="<?php echo e(route('contact')); ?>"><span>Get In Touch <i class="ti-arrow-right"></i></span></a></div>
                </div>
                <div class="col-md-5 offset-md-2">
                    <div class="testimonials-box">
                        <div class="head-box">
                            <h6>Testimonials</h6>
                            <h4>Travelers Reviews</h4>
                        </div>
                        <div class="owl-carousel owl-theme">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="item">
                                <p>"<?php echo e($testimonial->content); ?>"</p>
                                <div class="info">
                                    <div class="author-img">
                                        <img src="<?php echo e($testimonial->image ? \App\Helpers\Cms::imageUrl($testimonial->image) : asset('annapurna/img/team/08.png')); ?>" alt="<?php echo e($testimonial->name); ?>">
                                    </div>
                                    <div class="cont">
                                        <div class="rating"><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i=0;$i<5;$i++): ?><i class="star <?php echo e($i<($testimonial->rating??5)?'active':''); ?>"></i><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></div>
                                        <h6><?php echo e($testimonial->name); ?></h6>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($testimonial->position ?? null): ?><span><?php echo e($testimonial->position); ?></span><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="item">
                                <p>"It's not about conquering mountains, but about the journey and the experiences along the way."</p>
                                <div class="info"><div class="author-img"><img src="<?php echo e(asset('annapurna/img/team/08.png')); ?>" alt="Jimmy Chin"></div><div class="cont"><div class="rating"><i class="star active"></i><i class="star active"></i><i class="star active"></i><i class="star active"></i><i class="star active"></i></div><h6>Jimmy Chin</h6><span>Renowned climber &amp; filmmaker</span></div></div>
                            </div>
                            <div class="item">
                                <p>"Annapurna, to which we had gone empty-handed, was a treasure on which we should live the rest of our days."</p>
                                <div class="info"><div class="author-img"><img src="<?php echo e(asset('annapurna/img/team/07.png')); ?>" alt="Maurice Herzog"></div><div class="cont"><div class="rating"><i class="star active"></i><i class="star active"></i><i class="star active"></i><i class="star active"></i><i class="star active"></i></div><h6>Maurice Herzog</h6><span>First Conquest of an 8,000-Meter Peak</span></div></div>
                            </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="clients">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="owl-carousel owl-theme">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $partners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="clients-logo">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($partner->url ?? null): ?>
                            <a href="<?php echo e($partner->url); ?>" target="_blank" rel="noopener noreferrer"><img src="<?php echo e(\App\Helpers\Cms::imageUrl($partner->logo)); ?>" alt="<?php echo e($partner->name); ?>"></a>
                        <?php else: ?>
                            <img src="<?php echo e(\App\Helpers\Cms::imageUrl($partner->logo)); ?>" alt="<?php echo e($partner->name); ?>">
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="clients-logo"><a href="#"><img src="<?php echo e(asset('annapurna/img/clients/1.png')); ?>" alt="Partner"></a></div>
                    <div class="clients-logo"><a href="#"><img src="<?php echo e(asset('annapurna/img/clients/2.png')); ?>" alt="Partner"></a></div>
                    <div class="clients-logo"><a href="#"><img src="<?php echo e(asset('annapurna/img/clients/3.png')); ?>" alt="Partner"></a></div>
                    <div class="clients-logo"><a href="#"><img src="<?php echo e(asset('annapurna/img/clients/4.png')); ?>" alt="Partner"></a></div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function () {

    /* ----- Vegas hero slider ----- */
    var sliderImages = [
        <?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($slider->image): ?>
        { src: "<?php echo e(\App\Helpers\Cms::imageUrl($slider->image)); ?>" },
        <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php if($sliders->isEmpty()): ?>
        { src: "<?php echo e(asset('annapurna/img/slider/annapurna-region.png')); ?>" },
        { src: "<?php echo e(asset('annapurna/img/slider/panaromic.jpg')); ?>" }
        <?php endif; ?>
    ];
    if (sliderImages.length && typeof $.fn.vegas !== 'undefined') {
        $('#kenburnsSliderContainer').vegas({
            slides: sliderImages,
            overlay: true,
            transition: 'fade2',
            animation: 'kenburnsUpRight',
            transitionDuration: 1000,
            delay: 8000,
            animationDuration: 20000
        });
    }

    /* ----- Search config per type ----- */
    var searchConfig = <?php echo json_encode($searchConfig, 15, 512) ?>;

    var staticPills = {
        trekking: [
            <?php $__currentLoopData = $popularTreks->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            { label: '<?php echo e($t->name); ?>', url: '<?php echo e(route("trek-routes.index")); ?>?search=<?php echo e(urlencode($t->name)); ?>' },
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if($popularTreks->isEmpty()): ?>
            { label: 'Annapurna Base Camp Trek', url: '<?php echo e(route("trek-routes.index")); ?>?search=Annapurna+Base+Camp' },
            { label: 'Annapurna Circuit Trek',   url: '<?php echo e(route("trek-routes.index")); ?>?search=Annapurna+Circuit' },
            { label: 'Pokhara City Tours',       url: '<?php echo e(route("trek-routes.index")); ?>?search=Pokhara' },
            { label: 'Poon Hill Trek',           url: '<?php echo e(route("trek-routes.index")); ?>?search=Poon+Hill' },
            <?php endif; ?>
        ],
        hotels: [
            { label: 'Luxury Hotels',    url: '<?php echo e(route("hotels.index")); ?>?category=luxury' },
            { label: 'Budget Stays',     url: '<?php echo e(route("hotels.index")); ?>?category=budget' },
            { label: 'Pokhara Resorts',  url: '<?php echo e(route("hotels.index")); ?>?search=Pokhara' },
            { label: 'Lakeside Hotels',  url: '<?php echo e(route("hotels.index")); ?>?search=Lakeside' },
        ],
        travel: [
            { label: 'Day Tours',        url: '<?php echo e(route("travel-agencies.index")); ?>?search=day+tour' },
            { label: 'Adventure Sports', url: '<?php echo e(route("destinations.index")); ?>' },
            { label: 'Cultural Tours',   url: '<?php echo e(route("travel-agencies.index")); ?>?search=cultural' },
            { label: 'Paragliding',      url: '<?php echo e(route("destinations.index")); ?>?search=paragliding' },
        ],
        vehicle: [
            { label: 'Jeep Rental',      url: '<?php echo e(route("travel-agencies.index")); ?>?search=jeep' },
            { label: 'Bus Transfer',     url: '<?php echo e(route("travel-agencies.index")); ?>?search=bus' },
            { label: 'Private Car',      url: '<?php echo e(route("travel-agencies.index")); ?>?search=car' },
            { label: 'Airport Transfer', url: '<?php echo e(route("travel-agencies.index")); ?>?search=airport' },
        ],
    };

    function updateSearchUI(type) {
        var cfg = searchConfig[type];
        if (!cfg) return;
        $('#heroSearch').attr('placeholder', cfg.placeholder);
        $('#heroDestLabel').text(cfg.destLabel);

        // rebuild destination dropdown
        var $sel = $('#heroDestination');
        $sel.empty().append('<option value="">Search Destination</option>');
        $.each(cfg.destinations, function (i, d) { $sel.append($('<option>').val(d.value).text(d.label)); });

        // rebuild pills
        var pills = staticPills[type] || [];
        var html = '<span>Popular:</span>';
        $.each(pills, function (i, p) { html += '<a href="' + p.url + '" class="cat-pill">' + p.label + '</a>'; });
        $('#heroPills').html(html);
    }

    /* ----- Search tabs ----- */
    $('.search-tabs li').on('click', function () {
        $('.search-tabs li').removeClass('active');
        $(this).addClass('active');
        updateSearchUI($(this).data('search-type'));
    });

    /* ----- Hero search button → /search -----*/
    var searchBase = '<?php echo e(route("search")); ?>';

    $('#heroSearchBtn').on('click', function () {
        var type = $('.search-tabs li.active').data('search-type') || 'trekking';
        var q    = $('#heroSearch').val().trim();
        var dest = $('#heroDestination').val();

        if (dest) {
            // destination option already carries a pre-built URL
            window.location.href = dest;
            return;
        }

        var params = { type: type };
        if (q) params.search = q;
        window.location.href = searchBase + '?' + $.param(params);
    });

    /* Enter key in search input */
    $('#heroSearch').on('keydown', function (e) {
        if (e.key === 'Enter') $('#heroSearchBtn').trigger('click');
    });

    /* ----- Deals grid paginator (2 rows × N cols) ----- */
    var dealsState = {}; // { panelId: { page, pages } }

    var typeRoutes = {
        'all':          '<?php echo e(route("search", ["type"=>"trekking"])); ?>',
        'trekking':     '<?php echo e(route("search", ["type"=>"trekking"])); ?>',
        'hotel':        '<?php echo e(route("search", ["type"=>"hotel"])); ?>',
        'travel-agency':'<?php echo e(route("search", ["type"=>"travel"])); ?>',
        'destinations': '<?php echo e(route("search", ["type"=>"destinations"])); ?>',
        'restaurant':   '<?php echo e(route("search", ["type"=>"restaurant"])); ?>',
    };

    function getDealsPerPage() {
        var w = $(window).width();
        if (w >= 1200) return 8; // 4 cols × 2 rows
        if (w >= 992)  return 6; // 3 cols × 2 rows
        return 4;                // 2 cols × 2 rows
    }

    function initDealsGrid(panelId) {
        if (dealsState[panelId]) return;
        showDealsPage(panelId, 0);
    }

    function showDealsPage(panelId, page) {
        var perPage = getDealsPerPage();
        var $cards  = $('#' + panelId + ' .owl-carousel .deal-card');
        var total   = $cards.length;
        var pages   = Math.max(1, Math.ceil(total / perPage));
        page = Math.max(0, Math.min(page, pages - 1));
        dealsState[panelId] = { page: page, pages: pages };

        $cards.hide().removeClass('d-show');
        $cards.slice(page * perPage, (page + 1) * perPage).addClass('d-show').show();

        // update nav UI for the currently visible panel
        if ($('#' + panelId).hasClass('active')) {
            $('#dealsPageInfo').text((page + 1) + ' / ' + pages);
            $('#dealsLeft').prop('disabled', page === 0).toggleClass('disabled', page === 0);
            $('#dealsRight').prop('disabled', page >= pages - 1).toggleClass('disabled', page >= pages - 1);
        }
    }

    // init the default "all" panel immediately
    initDealsGrid('panel-all');

    $('#dealsLeft').on('click', function () {
        var panelId = $('.deals-panel.active').attr('id');
        if (!panelId || !dealsState[panelId]) return;
        showDealsPage(panelId, dealsState[panelId].page - 1);
    });

    $('#dealsRight').on('click', function () {
        var panelId = $('.deals-panel.active').attr('id');
        if (!panelId || !dealsState[panelId]) return;
        showDealsPage(panelId, dealsState[panelId].page + 1);
    });

    // re-calc on resize
    $(window).on('resize', function () {
        var panelId = $('.deals-panel.active').attr('id');
        if (panelId && dealsState[panelId]) {
            showDealsPage(panelId, dealsState[panelId].page);
        }
    });

    $('#categoryFilterTabs').on('click', '.filter-tab', function () {
        var filter  = $(this).data('filter');
        var panelId = 'panel-' + filter;

        $('#categoryFilterTabs .filter-tab').removeClass('active');
        $(this).addClass('active');

        $('.deals-panel').removeClass('active');
        $('#' + panelId).addClass('active');

        // update "View All" link
        $('#dealsViewAll').attr('href', typeRoutes[filter] || typeRoutes['all']);

        // lazy-init grid for this panel
        initDealsGrid(panelId);

        // refresh nav for newly shown panel
        var s = dealsState[panelId];
        if (s) {
            $('#dealsPageInfo').text((s.page + 1) + ' / ' + s.pages);
            $('#dealsLeft').prop('disabled', s.page === 0).toggleClass('disabled', s.page === 0);
            $('#dealsRight').prop('disabled', s.page >= s.pages - 1).toggleClass('disabled', s.page >= s.pages - 1);
        }
    });

    /* ----- Recently Added carousel ----- */
    var $listed = $('#listedCarousel').owlCarousel({
        loop: true, margin: 20, nav: false, dots: false,
        responsive: { 0:{items:1}, 576:{items:2}, 768:{items:3}, 992:{items:4} }
    });
    $('#listedLeft').on('click', function () { $listed.trigger('prev.owl.carousel'); });
    $('#listedRight').on('click', function () { $listed.trigger('next.owl.carousel'); });

    /* ----- Filter drawer ----- */
    var categoryRoutes = {
        'all':            '<?php echo e(route("trek-routes.index")); ?>',
        'trekking':       '<?php echo e(route("trek-routes.index")); ?>',
        'hotel':          '<?php echo e(route("hotels.index")); ?>',
        'travel-agency':  '<?php echo e(route("travel-agencies.index")); ?>',
        'destinations':   '<?php echo e(route("destinations.index")); ?>',
        'restaurant':     '<?php echo e(route("restaurants.index")); ?>'
    };

    function openDrawer() {
        $('#filterDrawer, #filterOverlay').addClass('open');
        $('body').css('overflow', 'hidden');
    }
    function closeDrawer() {
        $('#filterDrawer, #filterOverlay').removeClass('open');
        $('body').css('overflow', '');
    }

    $('#openFilterDrawer').on('click', openDrawer);
    $('#closeFilterDrawer, #filterOverlay').on('click', closeDrawer);

    // Budget slider label
    $('#budgetSlider').on('input', function () {
        var v = parseInt($(this).val());
        $('#budgetVal').text('$' + v.toLocaleString());
        var pct = ((v / 10000) * 100) + '%';
        $(this).css('--val', pct);
        this.style.background = 'linear-gradient(to right, #2095AE 0%, #2095AE ' + pct + ', #e2e6ea ' + pct + ', #e2e6ea 100%)';
    });

    // Reset filters
    $('#filterReset').on('click', function () {
        $('#budgetSlider').val(10000).trigger('input');
        $('.filter-drawer input[type="checkbox"]').prop('checked', false);
    });

    // Show Results → redirect to /search with type + filters
    var filterTypeMap = {
        'all':           'trekking',
        'trekking':      'trekking',
        'hotel':         'hotel',
        'travel-agency': 'travel',
        'destinations':  'destinations',
        'restaurant':    'restaurant',
    };

    $('#filterShowResults').on('click', function () {
        var activeFilter = $('#categoryFilterTabs .filter-tab.active').data('filter') || 'all';
        var searchType   = filterTypeMap[activeFilter] || 'trekking';
        var params       = { type: searchType };

        var budget = parseInt($('#budgetSlider').val());
        if (budget < 10000) params.budget_max = budget;

        var stars = [];
        $('.filter-drawer input[name="star[]"]:checked').each(function () { stars.push($(this).val()); });
        if (stars.length) params['star[]'] = stars;

        var cats = [];
        $('.filter-drawer input[name="category[]"]:checked').each(function () { cats.push($(this).val()); });
        if (cats.length) params['category[]'] = cats;

        window.location.href = searchBase + '?' + $.param(params);
    });

    /* ----- Activity tabs ----- */
    $('.act-tab').on('click', function () {
        var target = $(this).data('content');
        $('.act-tab').removeClass('active');
        $('.act-tab-content').removeClass('active');
        $(this).addClass('active');
        $('#' + target).addClass('active');
        $('#' + target + ' .owl-carousel').trigger('refresh.owl.carousel');
    });

});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/frontend/home.blade.php ENDPATH**/ ?>