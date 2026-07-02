@extends('layouts.app')

@section('meta_title', 'Create Post - Community Feed - ' . \App\Helpers\Cms::siteName())

@push('styles')
<style>
    .feed-create-page {
        background: #f4f6f9;
        min-height: 100vh;
        padding: 40px 0 60px;
    }
    .feed-create-layout {
        max-width: 700px;
        margin: 0 auto;
    }
    .feed-create-page-header {
        margin-bottom: 24px;
    }
    .feed-create-page-header h1 {
        font-size: 24px;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0 0 4px;
    }
    .feed-create-page-header p {
        color: #888;
        font-size: 14px;
        margin: 0;
    }
</style>
@endpush

@section('content')
    @include('partials.breadcrumb', ['title' => 'Create Post', 'items' => [
        ['label' => 'Feed', 'url' => route('feed.index')],
        ['label' => 'Create Post']
    ]])

    <div class="feed-create-page">
        <div class="container">
            <div class="feed-create-layout">
                <div class="feed-create-page-header">
                    <h1>Create a Post</h1>
                    <p>Share your travel stories, tips, offers, or announcements with the community.</p>
                </div>

                @include('feed.partials.create-post-form', [
                    'postableBusinesses' => $postableBusinesses,
                    'selectedBusiness'   => $selectedBusiness ?? null,
                ])
            </div>
        </div>
    </div>
@endsection
