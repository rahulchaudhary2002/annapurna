<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\PricingPlan;
use Illuminate\View\View;

class PricingController extends Controller
{
    public function index(): View
    {
        $plans = PricingPlan::active()->get();
        $faqs = Faq::active()->featured()->limit(8)->get();

        return view('frontend.pricing', compact('plans', 'faqs'));
    }
}
