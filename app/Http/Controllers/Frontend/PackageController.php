<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageInquiry;
use App\Models\PackageView;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class PackageController extends Controller
{
    public function index(Request $request): View
    {
        $query = Package::active()->with('business');

        // Sponsored packages first, then active free packages
        $sponsored = Package::active()->sponsored()->with('business')->get();

        $packages = Package::active()
            ->with('business')
            ->when($request->filled('type'), fn ($q) =>
                $q->whereHas('business', fn ($b) => $b->where('type', $request->type))
            )
            ->when($request->filled('min_price'), fn ($q) =>
                $q->where('price', '>=', $request->min_price)
            )
            ->when($request->filled('max_price'), fn ($q) =>
                $q->where('price', '<=', $request->max_price)
            )
            ->when($request->filled('duration'), fn ($q) =>
                $q->where('duration_days', '<=', $request->duration)
            )
            ->paginate(12)
            ->withQueryString();

        return view('packages.index', compact('packages', 'sponsored'));
    }

    public function show(string $slug): View
    {
        $package = Package::where('slug', $slug)
            ->where('is_active', true)
            ->with('business')
            ->firstOrFail();

        $related = Package::active()
            ->where('id', '!=', $package->id)
            ->where('business_id', $package->business_id)
            ->limit(3)
            ->get();

        // Track package view — deduplicated per IP per day
        PackageView::insertOrIgnore([
            'package_id'  => $package->id,
            'business_id' => $package->business_id,
            'user_id'     => auth()->id(),
            'ip_address'  => request()->ip(),
            'source'      => request()->query('src', 'direct'),
            'viewed_on'   => Carbon::today()->toDateString(),
            'created_at'  => Carbon::now(),
        ]);

        return view('packages.show', compact('package', 'related'));
    }

    public function inquire(Request $request, Package $package): RedirectResponse
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'email', 'max:255'],
            'phone'       => ['nullable', 'string', 'max:30'],
            'travel_date' => ['nullable', 'date', 'after_or_equal:today'],
            'group_size'  => ['nullable', 'integer', 'min:1', 'max:100'],
            'message'     => ['nullable', 'string', 'max:2000'],
        ]);

        PackageInquiry::create([
            'package_id'  => $package->id,
            'name'        => $request->name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'travel_date' => $request->travel_date,
            'group_size'  => $request->group_size,
            'message'     => $request->message,
            'ip_address'  => $request->ip(),
        ]);

        return back()->with('inquiry_success', 'Your inquiry has been sent! We will contact you shortly.');
    }
}
