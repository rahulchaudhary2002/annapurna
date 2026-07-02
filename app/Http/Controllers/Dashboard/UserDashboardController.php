<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load(['ownedBusinesses', 'businessMemberships.business']);

        $recentPosts = $user->posts()
            ->latest()
            ->take(5)
            ->get();

        $recentBusinesses = $user->ownedBusinesses()
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'businesses' => $user->ownedBusinesses()->count(),
            'posts'      => $user->posts()->count(),
            'memberships'=> $user->businessMemberships()->count(),
        ];

        return view('dashboard.index', compact(
            'user', 'recentPosts', 'recentBusinesses', 'stats'
        ));
    }
}
