@extends('ggf.layouts.app')

@section('title', ($page->meta_title ?: $page->title) . ' | ' . \App\Helpers\Cms::setting('ggf_site_name', 'Guru Goraksanatha Foundation'))
@section('meta_description', $page->meta_description ?: '')

@section('header')
    <header class="header-image ken-burn-center" data-parallax="true" data-natural-height="500" data-natural-width="1920" data-bleed="0"
        data-image-src="{{ $page->featured_image ? \App\Helpers\Cms::imageUrl($page->featured_image) : asset('ggf/media/hd-1.jpg') }}"
        data-offset="0">
        <div class="container">
            <h1>{{ $page->title }}</h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('ggf.home') }}">Home</a></li>
                <li>{{ $page->title }}</li>
            </ol>
        </div>
    </header>
@endsection

@section('content')
<section class="section-base">
    <div class="container">
        @if($page->content)
            {!! $page->content !!}
        @endif
    </div>
</section>
@endsection
