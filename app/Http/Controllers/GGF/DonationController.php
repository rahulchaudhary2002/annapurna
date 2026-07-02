<?php

namespace App\Http\Controllers\GGF;

use App\Http\Controllers\Controller;
use App\Models\GGFDonationSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DonationController extends Controller
{
    public function index(): View
    {
        return view('ggf.donation');
    }

    public function submit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'phone'      => 'required|string|max:50',
            'amount'     => 'required|numeric|min:1',
            'screenshot' => 'required|file|mimes:jpg,jpeg,png,gif,webp,pdf|max:5120',
        ]);

        $screenshotPath = $request->file('screenshot')
            ->store('ggf/donations', 'public');

        GGFDonationSubmission::create([
            'name'       => $validated['name'],
            'phone'      => $validated['phone'],
            'amount'     => $validated['amount'],
            'screenshot' => $screenshotPath,
            'ip_address' => $request->ip(),
        ]);

        return back()->with('donation_success', \App\Helpers\Cms::setting(
            'ggf_donation_success_message',
            'Thank you! Your donation details were submitted successfully.'
        ));
    }
}
