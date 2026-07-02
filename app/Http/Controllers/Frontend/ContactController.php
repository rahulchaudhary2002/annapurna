<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use App\Models\Page;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        $services = Service::active()->pluck('title', 'id');

        // Load the CMS page so admins can edit the intro text via Admin → Pages
        $page = Page::where('slug', 'contact')->published()->first();

        return view('frontend.contact', compact('services', 'page'));
    }

    public function submit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'phone'      => 'nullable|string|max:30',
            'subject'    => 'nullable|string|max:255',
            'service_id' => 'nullable|exists:services,id',
            'message'    => 'nullable|string|max:5000',
        ]);

        ContactSubmission::create([
            ...$validated,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', 'Thank you for your message! We will get back to you shortly.');
    }
}
