<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Business;
use App\Models\Package;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // ── Hotel Booking ──────────────────────────────────────────────────────

    public function storeHotel(Request $request, Business $business): RedirectResponse
    {
        abort_unless($business->is_active && $business->type === 'hotel', 404);

        $data = $request->validate([
            'guest_name'      => ['required', 'string', 'max:255'],
            'guest_email'     => ['required', 'email', 'max:255'],
            'guest_phone'     => ['nullable', 'string', 'max:30'],
            'check_in'        => ['required', 'date', 'after_or_equal:today'],
            'check_out'       => ['required', 'date', 'after:check_in'],
            'rooms'           => ['required', 'integer', 'min:1', 'max:20'],
            'guests'          => ['required', 'integer', 'min:1', 'max:50'],
            'special_requests'=> ['nullable', 'string', 'max:1000'],
        ]);

        Booking::create([
            ...$data,
            'bookable_type' => Business::class,
            'bookable_id'   => $business->id,
            'user_id'       => auth()->id(),
            'ip_address'    => $request->ip(),
        ]);

        return back()->with('booking_success',
            'Your booking request has been received! We will confirm your reservation shortly.'
        );
    }

    // ── Package Booking ────────────────────────────────────────────────────

    public function storePackage(Request $request, Package $package): RedirectResponse
    {
        abort_unless($package->is_active, 404);

        $data = $request->validate([
            'guest_name'      => ['required', 'string', 'max:255'],
            'guest_email'     => ['required', 'email', 'max:255'],
            'guest_phone'     => ['nullable', 'string', 'max:30'],
            'travel_date'     => ['required', 'date', 'after_or_equal:today'],
            'guests'          => ['required', 'integer', 'min:1', 'max:50'],
            'special_requests'=> ['nullable', 'string', 'max:1000'],
        ]);

        Booking::create([
            ...$data,
            'bookable_type' => Package::class,
            'bookable_id'   => $package->id,
            'user_id'       => auth()->id(),
            'ip_address'    => $request->ip(),
        ]);

        return back()->with('booking_success',
            'Your booking request has been received! The team will contact you shortly to confirm your trip.'
        );
    }
}
