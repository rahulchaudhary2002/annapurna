<?php

namespace App\Http\Controllers\GGF;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function index(): View
    {
        $teamMembers = TeamMember::active()->where('order', '>=', 100)->orderBy('order')->get();

        return view('ggf.team', compact('teamMembers'));
    }

    public function show(string $slug): View
    {
        $member = TeamMember::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return view('ggf.team-show', compact('member'));
    }
}
