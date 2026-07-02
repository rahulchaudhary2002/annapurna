<x-filament-panels::page>

    {{-- Formula preview --}}
    <div style="background:#f8f9fa;border:1px solid #e9ecef;border-radius:8px;padding:20px;margin-bottom:24px;font-family:monospace;font-size:13px;line-height:1.8;">
        <div style="font-weight:700;font-size:14px;margin-bottom:8px;font-family:sans-serif;">Ranking Formula</div>
        <div>
            <strong>Score</strong> =
            (ProfileCompleteness × <strong>W₁</strong>)
            + (RecentPosts × <strong>W₂</strong>)
            + (ProfileClicks × <strong>W₃</strong>)
            + (AvgRating × ReviewCount × <strong>W₄</strong>)
            + (Engagement × <strong>W₅</strong>)
        </div>
        <div style="margin-top:12px;font-size:12px;color:#6c757d;font-family:sans-serif;">
            Businesses are sorted highest score first. Profile completeness is fixed at listing creation and never recomputed on updates.
        </div>
    </div>

    <form wire:submit.prevent="saveWeights">
        {{ $this->form }}
    </form>

</x-filament-panels::page>
