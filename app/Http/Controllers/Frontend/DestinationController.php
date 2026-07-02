<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\View\View;

class DestinationController extends Controller
{
    public function index(): View
    {
        $destinations = Destination::active()->paginate(12);
        return view('frontend.destinations.index', compact('destinations'));
    }

    public function show(string $slug): View
    {
        $destination = Destination::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('frontend.destinations.show', compact('destination'));
    }
}
