<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Package;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BusinessPackageController extends Controller
{
    protected function authorizeMember(Business $business): void
    {
        $userId = auth()->id();
        $isMember = $business->members()->where('user_id', $userId)->exists();
        abort_if(!$isMember && $business->user_id !== $userId, 403);
    }

    public function index(Business $business): View
    {
        $this->authorizeMember($business);

        $packages = $business->packages()->latest()->paginate(15);

        return view('dashboard.packages.index', compact('business', 'packages'));
    }

    public function create(Business $business): View
    {
        $this->authorizeMember($business);

        return view('dashboard.packages.create', compact('business'));
    }

    public function store(Request $request, Business $business): RedirectResponse
    {
        $this->authorizeMember($business);

        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'price'         => ['required', 'numeric', 'min:0'],
            'duration'      => ['required', 'string', 'max:100'],
            'duration_days' => ['required', 'integer', 'min:1'],
            'highlights'    => ['nullable', 'string'],
            'itinerary'     => ['nullable', 'string'],
            'photos.*'      => ['nullable', 'image', 'max:5120'],
            'video_url'     => ['nullable', 'url', 'max:500'],
            'faqs'          => ['nullable', 'string'],
            'map_embed'     => ['nullable', 'string'],
            'listing_type'  => ['required', 'in:free,paid'],
            'paid_from'     => ['nullable', 'required_if:listing_type,paid', 'date'],
            'paid_until'    => ['nullable', 'required_if:listing_type,paid', 'date', 'after:paid_from'],
            'daily_rate'    => ['nullable', 'numeric', 'min:0'],
            'is_active'     => ['boolean'],
            'meta_title'    => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ]);

        $data = [
            'business_id'      => $business->id,
            'name'             => $validated['name'],
            'price'            => $validated['price'],
            'duration'         => $validated['duration'],
            'duration_days'    => $validated['duration_days'],
            'video_url'        => $validated['video_url'] ?? null,
            'map_embed'        => $validated['map_embed'] ?? null,
            'listing_type'     => $validated['listing_type'],
            'paid_from'        => $validated['listing_type'] === 'paid' ? $validated['paid_from'] : null,
            'paid_until'       => $validated['listing_type'] === 'paid' ? $validated['paid_until'] : null,
            'daily_rate'       => $validated['daily_rate'] ?? null,
            'is_active'        => $request->boolean('is_active', true),
            'meta_title'       => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'highlights'       => $this->parseLines($request->highlights),
            'faqs'             => $this->parseFaqs($request->faqs),
            'itinerary'        => $this->parseItinerary($request->itinerary),
        ];

        // Handle photo uploads
        if ($request->hasFile('photos')) {
            $paths = [];
            foreach ($request->file('photos') as $photo) {
                $paths[] = $photo->store('packages', 'public');
            }
            $data['photos'] = $paths;
        }

        Package::create($data);

        return redirect()->route('dashboard.businesses.packages.index', $business)
            ->with('success', 'Package created successfully!');
    }

    public function edit(Business $business, Package $package): View
    {
        $this->authorizeMember($business);
        abort_if($package->business_id !== $business->id, 404);

        return view('dashboard.packages.edit', compact('business', 'package'));
    }

    public function update(Request $request, Business $business, Package $package): RedirectResponse
    {
        $this->authorizeMember($business);
        abort_if($package->business_id !== $business->id, 404);

        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'price'         => ['required', 'numeric', 'min:0'],
            'duration'      => ['required', 'string', 'max:100'],
            'duration_days' => ['required', 'integer', 'min:1'],
            'highlights'    => ['nullable', 'string'],
            'itinerary'     => ['nullable', 'string'],
            'photos.*'      => ['nullable', 'image', 'max:5120'],
            'video_url'     => ['nullable', 'url', 'max:500'],
            'faqs'          => ['nullable', 'string'],
            'map_embed'     => ['nullable', 'string'],
            'listing_type'  => ['required', 'in:free,paid'],
            'paid_from'     => ['nullable', 'required_if:listing_type,paid', 'date'],
            'paid_until'    => ['nullable', 'required_if:listing_type,paid', 'date', 'after:paid_from'],
            'daily_rate'    => ['nullable', 'numeric', 'min:0'],
            'is_active'     => ['boolean'],
            'meta_title'    => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ]);

        $data = [
            'name'             => $validated['name'],
            'price'            => $validated['price'],
            'duration'         => $validated['duration'],
            'duration_days'    => $validated['duration_days'],
            'video_url'        => $validated['video_url'] ?? null,
            'map_embed'        => $validated['map_embed'] ?? null,
            'listing_type'     => $validated['listing_type'],
            'paid_from'        => $validated['listing_type'] === 'paid' ? $validated['paid_from'] : null,
            'paid_until'       => $validated['listing_type'] === 'paid' ? $validated['paid_until'] : null,
            'daily_rate'       => $validated['daily_rate'] ?? null,
            'is_active'        => $request->boolean('is_active', true),
            'meta_title'       => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'highlights'       => $this->parseLines($request->highlights),
            'faqs'             => $this->parseFaqs($request->faqs),
            'itinerary'        => $this->parseItinerary($request->itinerary),
        ];

        // Handle new photo uploads
        if ($request->hasFile('photos')) {
            // Delete old photos
            if ($package->photos) {
                foreach ($package->photos as $old) {
                    Storage::disk('public')->delete($old);
                }
            }
            $paths = [];
            foreach ($request->file('photos') as $photo) {
                $paths[] = $photo->store('packages', 'public');
            }
            $data['photos'] = $paths;
        }

        $package->update($data);

        return redirect()->route('dashboard.businesses.packages.index', $business)
            ->with('success', 'Package updated successfully!');
    }

    public function destroy(Business $business, Package $package): RedirectResponse
    {
        $this->authorizeMember($business);
        abort_if($package->business_id !== $business->id, 404);

        if ($package->photos) {
            foreach ($package->photos as $path) {
                Storage::disk('public')->delete($path);
            }
        }

        $package->delete();

        return back()->with('success', 'Package deleted.');
    }

    private function parseLines(?string $input): ?array
    {
        if (blank($input)) {
            return null;
        }
        return array_values(array_filter(array_map('trim', explode("\n", $input))));
    }

    private function parseFaqs(?string $input): ?array
    {
        if (blank($input)) {
            return null;
        }
        $faqs = [];
        $blocks = preg_split('/\n{2,}/', trim($input));
        foreach ($blocks as $block) {
            $lines = array_filter(array_map('trim', explode("\n", $block)));
            $lines = array_values($lines);
            if (count($lines) >= 2) {
                $faqs[] = ['question' => $lines[0], 'answer' => implode(' ', array_slice($lines, 1))];
            } elseif (count($lines) === 1) {
                $faqs[] = ['question' => $lines[0], 'answer' => ''];
            }
        }
        return $faqs ?: null;
    }

    private function parseItinerary(?string $input): ?array
    {
        if (blank($input)) {
            return null;
        }
        $days = [];
        $blocks = preg_split('/\n{2,}/', trim($input));
        $dayNum = 1;
        foreach ($blocks as $block) {
            $lines = array_filter(array_map('trim', explode("\n", $block)));
            $lines = array_values($lines);
            if (empty($lines)) {
                continue;
            }
            $days[] = [
                'day'         => $dayNum++,
                'title'       => $lines[0],
                'description' => implode(' ', array_slice($lines, 1)),
            ];
        }
        return $days ?: null;
    }
}
