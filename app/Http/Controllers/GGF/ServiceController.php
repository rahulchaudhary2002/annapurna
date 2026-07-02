<?php

namespace App\Http\Controllers\GGF;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = Service::active()->where('order', '>=', 100)->with('category')->get();

        return view('ggf.services.index', compact('services'));
    }

    public function show(string $slug): View
    {
        $service       = Service::where('slug', $slug)->where('is_active', true)->where('order', '>=', 100)->firstOrFail();
        $otherServices = Service::active()->where('order', '>=', 100)->where('id', '!=', $service->id)->limit(8)->get();

        return view('ggf.services.show', compact('service', 'otherServices'));
    }
}
