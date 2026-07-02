<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Dashboard\BusinessDashboardController;
use App\Http\Controllers\Dashboard\BusinessMemberController;
use App\Http\Controllers\Dashboard\BusinessPackageController;
use App\Http\Controllers\Dashboard\BusinessPostController;
use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\UserBusinessController;
use App\Http\Controllers\Dashboard\UserDashboardController;
use App\Http\Controllers\Frontend\BusinessController;
use App\Http\Controllers\Frontend\BusinessEngagementController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\DestinationController;
use App\Http\Controllers\Frontend\FaqController;
use App\Http\Controllers\Frontend\GalleryController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\PackageController;
use App\Http\Controllers\Frontend\ActivityController;
use App\Http\Controllers\Frontend\AttractionController;
use App\Http\Controllers\Frontend\BookingController;
use App\Http\Controllers\Frontend\GuideController;
use App\Http\Controllers\Frontend\TrekRouteController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// About
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Search
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Packages
Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
Route::get('/packages/{slug}', [PackageController::class, 'show'])->name('packages.show');
Route::post('/packages/{package}/inquire', [PackageController::class, 'inquire'])->name('packages.inquire');

// Trek Routes
Route::get('/trek-routes', [TrekRouteController::class, 'index'])->name('trek-routes.index');
Route::get('/trek-routes/{slug}', [TrekRouteController::class, 'show'])->name('trek-routes.show');

// Bookings (hotel & package)
Route::post('/bookings/hotel/{business}', [BookingController::class, 'storeHotel'])->name('bookings.hotel.store');
Route::post('/bookings/package/{package}', [BookingController::class, 'storePackage'])->name('bookings.package.store');

// Guides
Route::get('/guides', [GuideController::class, 'index'])->name('guides.index');
Route::get('/guides/{slug}', [GuideController::class, 'show'])->name('guides.show');

// Businesses
Route::get('/hotels', [BusinessController::class, 'hotels'])->name('hotels.index');
Route::get('/hotels/{slug}', [BusinessController::class, 'hotelShow'])->name('hotels.show');
Route::get('/restaurants', [BusinessController::class, 'restaurants'])->name('restaurants.index');
Route::get('/restaurants/{slug}', [BusinessController::class, 'restaurantShow'])->name('restaurants.show');
Route::get('/travel-agencies', [BusinessController::class, 'travelAgencies'])->name('travel-agencies.index');
Route::get('/businesses/{slug}', [BusinessController::class, 'show'])->name('businesses.show');

// Business Engagement (reviews, post likes, post comments)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/businesses/{business}/reviews', [BusinessEngagementController::class, 'storeReview'])->name('businesses.reviews.store');
    Route::post('/business-posts/{post}/like', [BusinessEngagementController::class, 'toggleLike'])->name('business-posts.like');
});
Route::post('/business-posts/{post}/comments', [BusinessEngagementController::class, 'storeComment'])->name('business-posts.comments.store');

// Destinations
Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');
Route::get('/destinations/{slug}', [DestinationController::class, 'show'])->name('destinations.show');

// Blog
Route::get('/blog', [PostController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [PostController::class, 'show'])->name('blog.show');
Route::post('/blog/{slug}/report', [PostController::class, 'report'])->name('posts.report');

// Gallery
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/gallery/{slug}', [GalleryController::class, 'album'])->name('gallery.album');

// FAQ
Route::get('/faq', [FaqController::class, 'index'])->name('faq');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Sitemap
Route::get('/sitemap.xml', function () {
    $pages = \App\Models\Page::published()->where('show_in_sitemap', true)->get();
    $posts = \App\Models\Post::published()->get();
    $trekRoutes = \App\Models\TrekRoute::where('is_active', true)->get();
    $businesses = \App\Models\Business::where('is_active', true)->get();

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n"
        . view('sitemap', compact('pages', 'posts', 'trekRoutes', 'businesses'))->render();

    return response($xml)->header('Content-Type', 'application/xml');
})->name('sitemap');

// ─── Auth Routes ────────────────────────────────────────────────────────────

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// Email Verification
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [VerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
        ->middleware('signed')
        ->name('verification.verify');
    Route::post('/email/verification-notification', [VerificationController::class, 'resend'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});

// ─── Social Feed ────────────────────────────────────────────────────────────
use App\Http\Controllers\Feed\FeedController;
use App\Http\Controllers\Feed\EngagementController;
use App\Http\Controllers\Feed\CommentController;

Route::get('/feed', [FeedController::class, 'index'])->name('feed.index');
Route::get('/feed/create', [FeedController::class, 'create'])->middleware('auth')->name('feed.create');
Route::get('/feed/{post}', [FeedController::class, 'show'])->name('feed.show');

Route::middleware('auth')->group(function () {
    Route::post('/feed', [FeedController::class, 'store'])->name('feed.store');
    Route::get('/feed/{post}/edit', [FeedController::class, 'edit'])->name('feed.edit');
    Route::put('/feed/{post}', [FeedController::class, 'update'])->name('feed.update');
    Route::delete('/feed/{post}', [FeedController::class, 'destroy'])->name('feed.destroy');

    // Engagement (AJAX)
    Route::post('/feed/{post}/like', [EngagementController::class, 'toggleLike'])->name('feed.like');
    Route::post('/feed/{post}/save', [EngagementController::class, 'toggleSave'])->name('feed.save');
    Route::post('/feed/{post}/share', [EngagementController::class, 'trackShare'])->name('feed.share');

    // Comments
    Route::get('/feed/{post}/comments', [CommentController::class, 'index'])->name('feed.comments.index');
    Route::post('/feed/{post}/comments', [CommentController::class, 'store'])->name('feed.comments.store');
    Route::delete('/feed/{post}/comments/{comment}', [CommentController::class, 'destroy'])->name('feed.comments.destroy');

    // Follow business
    Route::post('/businesses/{business}/follow', [EngagementController::class, 'toggleFollow'])->name('business.follow');
});

// View tracking (no auth needed)
Route::post('/feed/{post}/view', [EngagementController::class, 'trackView'])->name('feed.view');

// ─── User Dashboard ──────────────────────────────────────────────────────────

Route::middleware(['auth', 'verified'])->prefix('dashboard')->name('dashboard.')->group(function () {

    // Main dashboard
    Route::get('/', [UserDashboardController::class, 'index'])->name('index');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // User's businesses (CRUD, no show — show is the business dashboard below)
    Route::resource('businesses', UserBusinessController::class)->except(['show']);

    // Business dashboard (overview)
    Route::get('businesses/{business}/dashboard', [BusinessDashboardController::class, 'show'])
        ->name('businesses.dashboard');

    // Business posts
    Route::resource('businesses.posts', BusinessPostController::class)
        ->except(['show', 'edit', 'update']);

    // Business packages
    Route::get('businesses/{business}/packages', [BusinessPackageController::class, 'index'])
        ->name('businesses.packages.index');
    Route::get('businesses/{business}/packages/create', [BusinessPackageController::class, 'create'])
        ->name('businesses.packages.create');
    Route::post('businesses/{business}/packages', [BusinessPackageController::class, 'store'])
        ->name('businesses.packages.store');
    Route::get('businesses/{business}/packages/{package}/edit', [BusinessPackageController::class, 'edit'])
        ->name('businesses.packages.edit');
    Route::put('businesses/{business}/packages/{package}', [BusinessPackageController::class, 'update'])
        ->name('businesses.packages.update');
    Route::delete('businesses/{business}/packages/{package}', [BusinessPackageController::class, 'destroy'])
        ->name('businesses.packages.destroy');

    // Business members
    Route::get('businesses/{business}/members', [BusinessMemberController::class, 'index'])
        ->name('businesses.members.index');
    Route::post('businesses/{business}/members', [BusinessMemberController::class, 'store'])
        ->name('businesses.members.store');
    Route::put('businesses/{business}/members/{member}', [BusinessMemberController::class, 'update'])
        ->name('businesses.members.update');
    Route::delete('businesses/{business}/members/{member}', [BusinessMemberController::class, 'destroy'])
        ->name('businesses.members.destroy');

    // Feed Posts
    Route::get('/feed', [App\Http\Controllers\Dashboard\UserFeedController::class, 'index'])->name('feed.index');
    Route::delete('/feed/{post}', [App\Http\Controllers\Dashboard\UserFeedController::class, 'destroy'])->name('feed.destroy');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
});

// Attractions
Route::get('/attractions', [AttractionController::class, 'index'])->name('attractions.index');
Route::get('/attractions/{slug}', [AttractionController::class, 'show'])->name('attractions.show');

// Activities
Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
Route::get('/activities/{slug}', [ActivityController::class, 'show'])->name('activities.show');

// ─── Admin Exports (requires admin auth guard) ────────────────────────────────
Route::get('/admin/bookings/export-csv', function () {
    if (! auth('admin')->check()) {
        abort(403);
    }

    $bookings = \App\Models\Booking::with('bookable')->orderByDesc('created_at')->get();

    $filename = 'bookings-' . now()->format('Y-m-d') . '.csv';
    $headers  = [
        'Content-Type'        => 'text/csv; charset=UTF-8',
        'Content-Disposition' => "attachment; filename=\"{$filename}\"",
    ];

    return response()->streamDownload(function () use ($bookings) {
        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['Booking #', 'Type', 'Property/Package', 'Guest Name', 'Guest Email', 'Guest Phone', 'Guests', 'Check-in', 'Check-out', 'Travel Date', 'Rooms', 'Status', 'Total Price', 'Received']);
        foreach ($bookings as $b) {
            fputcsv($handle, [
                $b->booking_number,
                $b->getTypeLabel(),
                $b->bookable?->name ?? '—',
                $b->guest_name,
                $b->guest_email,
                $b->guest_phone ?? '',
                $b->guests,
                $b->check_in?->format('Y-m-d') ?? '',
                $b->check_out?->format('Y-m-d') ?? '',
                $b->travel_date?->format('Y-m-d') ?? '',
                $b->rooms ?? '',
                $b->status,
                $b->total_price ?? '',
                $b->created_at->format('Y-m-d H:i'),
            ]);
        }
        fclose($handle);
    }, $filename, $headers);
})->name('admin.bookings.export');

// ─── Dynamic pages (must be LAST) ────────────────────────────────────────────
Route::get('/{slug}', [PageController::class, 'show'])
    ->where('slug', '[a-zA-Z0-9\-\/]+')
    ->name('page.show');
