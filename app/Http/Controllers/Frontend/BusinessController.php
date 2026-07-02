<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessProfileView;
use App\Models\Package;
use App\Models\ProfileClick;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class BusinessController extends Controller
{
    public function hotels(): View
    {
        $query = Business::active()->ofType('hotel')
            ->withMin('packages as min_price', 'price');

        if (request()->filled('budget_max')) {
            $query->whereHas('packages', fn ($q) => $q->where('price', '<=', request('budget_max')))
                  ->orWhereDoesntHave('packages');
        }

        $businesses = $query->paginate(12)->withQueryString();

        $sponsoredPackages = Package::active()->sponsored()
            ->whereHas('business', fn ($q) => $q->where('type', 'hotel'))
            ->with('business')->limit(4)->get();

        return view('frontend.businesses.hotels', compact('businesses', 'sponsoredPackages'));
    }

    public function restaurants(): View
    {
        $search = request('search');
        $businesses = Business::active()->ofType('restaurant')
            ->withMin('packages as min_price', 'price')
            ->when($search, fn ($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('address', 'like', "%{$search}%")
                ->orWhere('short_description', 'like', "%{$search}%"))
            ->paginate(12)->withQueryString();

        $sponsoredPackages = Package::active()->sponsored()
            ->whereHas('business', fn ($q) => $q->where('type', 'restaurant'))
            ->with('business')->limit(4)->get();

        return view('frontend.businesses.restaurants', compact('businesses', 'sponsoredPackages', 'search'));
    }

    public function travelAgencies(): View
    {
        $search = request('search');
        $businesses = Business::active()->ofType('travel_agency')
            ->withMin('packages as min_price', 'price')
            ->when($search, fn ($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('address', 'like', "%{$search}%")
                ->orWhere('short_description', 'like', "%{$search}%"))
            ->paginate(12)->withQueryString();

        $sponsoredPackages = Package::active()->sponsored()
            ->whereHas('business', fn ($q) => $q->where('type', 'travel_agency'))
            ->with('business')->limit(4)->get();

        return view('frontend.businesses.travel-agencies', compact('businesses', 'sponsoredPackages', 'search'));
    }

    public function hotelShow(string $slug): View
    {
        $business = Business::where('slug', $slug)
            ->where('type', 'hotel')
            ->where('is_active', true)
            ->firstOrFail();

        BusinessProfileView::insertOrIgnore([
            'business_id' => $business->id,
            'user_id'     => auth()->id(),
            'ip_address'  => request()->ip(),
            'viewed_on'   => Carbon::today()->toDateString(),
            'created_at'  => Carbon::now(),
        ]);

        $packages      = $business->packages()->where('is_active', true)->orderBy('order')->get();
        $reviews       = $business->approvedReviews()->with('user')->latest()->get();
        $userReview    = auth()->check()
            ? $business->reviews()->where('user_id', auth()->id())->first()
            : null;
        $relatedHotels = Business::active()->ofType('hotel')
            ->where('id', '!=', $business->id)->limit(3)->get();

        return view('frontend.businesses.hotel-show', compact(
            'business', 'packages', 'reviews', 'userReview', 'relatedHotels'
        ));
    }

    public function restaurantShow(string $slug): View
    {
        $business = Business::where('slug', $slug)
            ->where('type', 'restaurant')
            ->where('is_active', true)
            ->firstOrFail();

        BusinessProfileView::insertOrIgnore([
            'business_id' => $business->id,
            'user_id'     => auth()->id(),
            'ip_address'  => request()->ip(),
            'viewed_on'   => Carbon::today()->toDateString(),
            'created_at'  => Carbon::now(),
        ]);

        $packages          = $business->packages()->where('is_active', true)->orderBy('order')->get();
        $reviews           = $business->approvedReviews()->with('user')->latest()->get();
        $userReview        = auth()->check()
            ? $business->reviews()->where('user_id', auth()->id())->first()
            : null;
        $relatedRestaurants = Business::active()->ofType('restaurant')
            ->where('id', '!=', $business->id)->limit(3)->get();

        return view('frontend.businesses.restaurant-show', compact(
            'business', 'packages', 'reviews', 'userReview', 'relatedRestaurants'
        ));
    }

    public function show(string $slug): View
    {
        $business = Business::where('slug', $slug)->where('is_active', true)->firstOrFail();

        // Track profile view — deduplicated per IP per day
        BusinessProfileView::insertOrIgnore([
            'business_id' => $business->id,
            'user_id'     => auth()->id(),
            'ip_address'  => request()->ip(),
            'viewed_on'   => Carbon::today()->toDateString(),
            'created_at'  => Carbon::now(),
        ]);

        // Track intentional profile click (every visit = a click-through)
        ProfileClick::insert([
            'business_id' => $business->id,
            'user_id'     => auth()->id(),
            'ip_address'  => request()->ip(),
            'source'      => request()->query('src', 'direct'),
            'created_at'  => Carbon::now(),
        ]);

        $packages = $business->packages()->where('is_active', true)->orderBy('order')->get();

        $reviews = $business->approvedReviews()->with('user')->latest()->get();

        $userReview = auth()->check()
            ? $business->reviews()->where('user_id', auth()->id())->first()
            : null;

        $relatedBusinesses = Business::active()
            ->ofType($business->type)
            ->where('id', '!=', $business->id)
            ->limit(3)
            ->get();

        return view('frontend.businesses.show', compact(
            'business', 'packages', 'reviews', 'userReview', 'relatedBusinesses'
        ));
    }
}
