<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessPost;
use App\Models\BusinessPostLike;
use App\Models\BusinessPostComment;
use App\Models\BusinessReview;
use App\Models\PostEngagement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BusinessEngagementController extends Controller
{
    // ─── Reviews ────────────────────────────────────────────────────────────

    public function storeReview(Request $request, Business $business): RedirectResponse
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title'  => 'nullable|string|max:120',
            'body'   => 'nullable|string|max:2000',
        ]);

        BusinessReview::updateOrCreate(
            ['business_id' => $business->id, 'user_id' => auth()->id()],
            [
                'rating'      => $request->rating,
                'title'       => $request->title,
                'body'        => $request->body,
                'is_approved' => false,
            ]
        );

        return back()->with('success', 'Your review has been submitted and is pending approval. Thank you!');
    }

    // ─── Post Likes ─────────────────────────────────────────────────────────

    public function toggleLike(BusinessPost $post): \Illuminate\Http\JsonResponse
    {
        $userId   = auth()->id();
        $existing = BusinessPostLike::where('business_post_id', $post->id)
                        ->where('user_id', $userId)
                        ->first();

        if ($existing) {
            $existing->delete();
            $liked  = false;
            $action = 'unlike';
        } else {
            BusinessPostLike::create([
                'business_post_id' => $post->id,
                'user_id'          => $userId,
            ]);
            $liked  = true;
            $action = 'like';
        }

        // Mirror to unified engagement log
        PostEngagement::insert([
            'post_id'    => $post->id,
            'post_type'  => 'business_post',
            'action'     => $action,
            'user_id'    => $userId,
            'ip_address' => request()->ip(),
            'created_at' => Carbon::now(),
        ]);

        $count = $post->likes()->count();

        return response()->json(['liked' => $liked, 'count' => $count]);
    }

    // ─── Post Comments ───────────────────────────────────────────────────────

    public function storeComment(Request $request, BusinessPost $post): RedirectResponse
    {
        $isAuth = auth()->check();

        $rules = ['body' => 'required|string|max:1000'];
        if (! $isAuth) {
            $rules['guest_name']  = 'required|string|max:80';
            $rules['guest_email'] = 'required|email|max:120';
        }

        $request->validate($rules);

        BusinessPostComment::create([
            'business_post_id' => $post->id,
            'user_id'          => $isAuth ? auth()->id() : null,
            'guest_name'       => $isAuth ? null : $request->guest_name,
            'guest_email'      => $isAuth ? null : $request->guest_email,
            'body'             => $request->body,
            'is_approved'      => false,
        ]);

        // Mirror to unified engagement log
        PostEngagement::insert([
            'post_id'    => $post->id,
            'post_type'  => 'business_post',
            'action'     => 'comment',
            'user_id'    => $isAuth ? auth()->id() : null,
            'ip_address' => $request->ip(),
            'created_at' => Carbon::now(),
        ]);

        return back()->with('success', 'Your comment has been submitted and is pending approval.');
    }
}
