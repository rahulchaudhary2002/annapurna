<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Business;

class BusinessDashboardController extends Controller
{
    public function show(Business $business)
    {
        $userId = auth()->id();

        $isMember = $business->members()
            ->where('user_id', $userId)
            ->exists();

        abort_if(!$isMember && $business->user_id !== $userId, 403);

        $business->load([
            'businessPosts' => fn ($q) => $q->latest()->take(10),
            'members.user',
        ]);

        $userRole = $business->members()
            ->where('user_id', $userId)
            ->value('role') ?? 'owner';

        return view('dashboard.businesses.show', compact('business', 'userRole'));
    }
}
