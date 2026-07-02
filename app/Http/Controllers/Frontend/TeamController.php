<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function index(): View
    {
        $teamMembers = TeamMember::active()->get();
        $departments = TeamMember::where('is_active', true)->whereNotNull('department')
            ->distinct()->orderBy('department')->pluck('department');

        return view('frontend.team.index', compact('teamMembers', 'departments'));
    }

    public function show(string $slug): View
    {
        $member = TeamMember::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $otherMembers = TeamMember::active()->where('id', '!=', $member->id)->limit(4)->get();

        return view('frontend.team.show', compact('member', 'otherMembers'));
    }
}
