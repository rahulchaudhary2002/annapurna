<?php

namespace App\Services;

use App\Models\Business;
use App\Models\BusinessPostComment;
use App\Models\BusinessPostLike;
use App\Models\PostEngagement;
use App\Models\ProfileClick;
use App\Models\Setting;
use Illuminate\Support\Carbon;

/**
 * Score = (ProfileCompleteness × W1) + (RecentPosts × W2)
 *       + (ProfileClicks × W3) + (AvgRating × ReviewCount × W4)
 *       + (Engagement × W5)
 *
 * Weights are configurable by admin via the Ranking Formula page.
 * ProfileCompleteness is calculated once on business creation and never
 * recomputed — updating a profile does not improve ranking.
 */
class BusinessRankingService
{
    private function weights(): array
    {
        return [
            'completeness' => (float) Setting::get('ranking_weight_completeness', 0.10),
            'posts'        => (float) Setting::get('ranking_weight_posts',        0.20),
            'clicks'       => (float) Setting::get('ranking_weight_clicks',       0.30),
            'rating'       => (float) Setting::get('ranking_weight_rating',       0.25),
            'engagement'   => (float) Setting::get('ranking_weight_engagement',   0.15),
        ];
    }

    public function recalculate(Business $business): void
    {
        // Admin override takes precedence — skip formula recalculation entirely
        if ($business->ranking_override !== null) {
            return;
        }

        $w = $this->weights();

        // Use stored completeness — never recompute (prevents gaming via profile edits)
        $completeness = (float) $business->profile_completeness_score;
        $posts        = $this->recentPostsScore($business);
        $clicks       = $this->profileClicksScore($business);
        $rating       = $this->ratingScore($business);
        $engagement   = $this->engagementScore($business);

        $score = ($completeness * $w['completeness'])
               + ($posts        * $w['posts'])
               + ($clicks       * $w['clicks'])
               + ($rating       * $w['rating'])
               + ($engagement   * $w['engagement']);

        $business->updateQuietly(['ranking_score' => round($score, 4)]);
    }

    public function recalculateAll(): void
    {
        Business::where('is_active', true)
            ->lazy()
            ->each(fn (Business $b) => $this->recalculate($b));
    }

    /**
     * Called once when a business is first created.
     * Returns 0–100.
     */
    public function computeProfileCompleteness(Business $business): int
    {
        $score = 0;
        if ($business->logo)                                     $score += 15;
        if ($business->cover_photo)                              $score += 10;
        if (strlen((string) $business->description) > 100)      $score += 20;
        if (strlen((string) $business->short_description) > 30) $score += 10;
        if ($business->phone)                                    $score += 10;
        if ($business->email)                                    $score += 10;
        if ($business->website)                                  $score += 5;
        if ($business->address)                                  $score += 10;
        if (!empty($business->gallery))                          $score += 10;

        return min($score, 100);
    }

    // ─── Dynamic components ────────────────────────────────────────────────

    /** Number of published posts in the last 30 days. */
    public function recentPostsScore(Business $business): int
    {
        return (int) $business->businessPosts()
            ->where('is_published', true)
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->count();
    }

    /** Intentional profile click-throughs in the last 30 days (from profile_clicks table). */
    public function profileClicksScore(Business $business): int
    {
        return (int) ProfileClick::where('business_id', $business->id)
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->count();
    }

    /** avg_rating × approved_review_count. */
    public function ratingScore(Business $business): float
    {
        $reviews = $business->approvedReviews();
        $count   = $reviews->count();
        if ($count === 0) return 0;

        $avg = (float) $reviews->avg('rating');
        return round($avg * $count, 4);
    }

    /** Engagement events (likes + comments + shares) on business posts in the last 30 days.
     *  Reads from post_engagement for the unified log; falls back to dedicated tables if empty. */
    public function engagementScore(Business $business): int
    {
        $since   = Carbon::now()->subDays(30);
        $postIds = $business->businessPosts()->pluck('id');

        if ($postIds->isEmpty()) return 0;

        // Primary: unified engagement log
        $fromLog = PostEngagement::where('post_type', 'business_post')
            ->whereIn('post_id', $postIds)
            ->whereIn('action', ['like', 'comment'])
            ->where('created_at', '>=', $since)
            ->count();

        if ($fromLog > 0) return $fromLog;

        // Fallback: dedicated tables (for data before post_engagement existed)
        $likes    = BusinessPostLike::whereIn('business_post_id', $postIds)
                        ->where('created_at', '>=', $since)
                        ->count();
        $comments = BusinessPostComment::whereIn('business_post_id', $postIds)
                        ->where('is_approved', true)
                        ->where('created_at', '>=', $since)
                        ->count();

        return $likes + $comments;
    }
}
