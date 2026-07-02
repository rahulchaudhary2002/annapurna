<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserBusinessController extends Controller
{
    public function index()
    {
        $businesses = auth()->user()->ownedBusinesses()->latest()->paginate(10);
        return view('dashboard.businesses.index', compact('businesses'));
    }

    public function create()
    {
        return view('dashboard.businesses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'type'              => ['required', 'string', 'in:hotel,restaurant,travel_agency,guide,porter'],
            'phone'             => ['nullable', 'string', 'max:30'],
            'email'             => ['nullable', 'email', 'max:255'],
            'address'           => ['nullable', 'string', 'max:500'],
            'website'           => ['nullable', 'url', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description'       => ['nullable', 'string'],
            'opening_hours'     => ['nullable', 'string', 'max:255'],
            'cover_photo'       => ['nullable', 'image', 'max:4096'],
            'logo'              => ['nullable', 'image', 'max:2048'],
        ]);

        $data = $request->only([
            'name', 'type', 'phone', 'email', 'address', 'website',
            'short_description', 'description', 'opening_hours', 'map_embed',
        ]);

        $data['user_id'] = auth()->id();
        $data['is_active'] = true;

        if ($request->hasFile('cover_photo')) {
            $data['cover_photo'] = $request->file('cover_photo')->store('businesses', 'public');
        }

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('businesses/logos', 'public');
        }

        $business = Business::create($data);

        BusinessMember::create([
            'business_id' => $business->id,
            'user_id'     => auth()->id(),
            'role'        => 'owner',
        ]);

        return redirect()->route('dashboard.businesses.index')
            ->with('success', 'Business created successfully!');
    }

    public function edit(Business $business)
    {
        abort_if($business->user_id !== auth()->id(), 403);

        return view('dashboard.businesses.edit', compact('business'));
    }

    public function update(Request $request, Business $business)
    {
        abort_if($business->user_id !== auth()->id(), 403);

        $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'type'              => ['required', 'string', 'in:hotel,restaurant,travel_agency,guide,porter'],
            'phone'             => ['nullable', 'string', 'max:30'],
            'email'             => ['nullable', 'email', 'max:255'],
            'address'           => ['nullable', 'string', 'max:500'],
            'website'           => ['nullable', 'url', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description'       => ['nullable', 'string'],
            'opening_hours'     => ['nullable', 'string', 'max:255'],
            'cover_photo'       => ['nullable', 'image', 'max:4096'],
            'logo'              => ['nullable', 'image', 'max:2048'],
        ]);

        $data = $request->only([
            'name', 'type', 'phone', 'email', 'address', 'website',
            'short_description', 'description', 'opening_hours', 'map_embed',
        ]);

        if ($request->hasFile('cover_photo')) {
            if ($business->cover_photo) {
                Storage::disk('public')->delete($business->cover_photo);
            }
            $data['cover_photo'] = $request->file('cover_photo')->store('businesses', 'public');
        }

        if ($request->hasFile('logo')) {
            if ($business->logo) {
                Storage::disk('public')->delete($business->logo);
            }
            $data['logo'] = $request->file('logo')->store('businesses/logos', 'public');
        }

        $business->update($data);

        return back()->with('success', 'Business updated successfully!');
    }

    public function destroy(Business $business)
    {
        abort_if($business->user_id !== auth()->id(), 403);

        if ($business->cover_photo) {
            Storage::disk('public')->delete($business->cover_photo);
        }
        if ($business->logo) {
            Storage::disk('public')->delete($business->logo);
        }

        $business->delete();

        return redirect()->route('dashboard.businesses.index')
            ->with('success', 'Business deleted successfully!');
    }
}
