<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessMember;
use App\Models\User;
use Illuminate\Http\Request;

class BusinessMemberController extends Controller
{
    protected function authorizeOwner(Business $business): void
    {
        abort_if($business->user_id !== auth()->id(), 403, 'Only the business owner can manage members.');
    }

    public function index(Business $business)
    {
        $userId = auth()->id();

        $isMember = $business->members()->where('user_id', $userId)->exists();
        abort_if(!$isMember && $business->user_id !== $userId, 403);

        $members = $business->members()->with('user')->get();

        return view('dashboard.businesses.members.index', compact('business', 'members'));
    }

    public function store(Request $request, Business $business)
    {
        $this->authorizeOwner($business);

        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'role'  => ['required', 'in:owner,manager,staff'],
        ]);

        $user = User::where('email', $request->email)->firstOrFail();

        $existing = $business->members()->where('user_id', $user->id)->exists();

        if ($existing) {
            return back()->withErrors(['email' => 'This user is already a member of this business.']);
        }

        BusinessMember::create([
            'business_id' => $business->id,
            'user_id'     => $user->id,
            'role'        => $request->role,
        ]);

        return back()->with('success', 'Member added successfully!');
    }

    public function update(Request $request, Business $business, BusinessMember $member)
    {
        $this->authorizeOwner($business);

        $request->validate([
            'role' => ['required', 'in:owner,manager,staff'],
        ]);

        $member->update(['role' => $request->role]);

        return back()->with('success', 'Member role updated!');
    }

    public function destroy(Business $business, BusinessMember $member)
    {
        $this->authorizeOwner($business);

        $member->delete();

        return back()->with('success', 'Member removed!');
    }
}
