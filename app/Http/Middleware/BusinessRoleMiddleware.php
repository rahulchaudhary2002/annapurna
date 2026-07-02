<?php

namespace App\Http\Middleware;

use App\Models\BusinessMember;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BusinessRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Usage: business.role:owner  OR  business.role:owner,manager
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $business = $request->route('business');

        if (!$business) {
            abort(404);
        }

        $userId = auth()->id();

        $member = BusinessMember::where('business_id', $business->id)
            ->where('user_id', $userId)
            ->first();

        if (!$member || !in_array($member->role, $roles)) {
            abort(403, 'You do not have the required role for this action.');
        }

        return $next($request);
    }
}
