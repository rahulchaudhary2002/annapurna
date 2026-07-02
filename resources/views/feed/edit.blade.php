@extends('layouts.app')

@section('meta_title', 'Edit Post - ' . \App\Helpers\Cms::siteName())

@section('content')
    @include('partials.breadcrumb', ['title' => 'Edit Post', 'items' => [
        ['label' => 'Feed', 'url' => route('feed.index')],
        ['label' => 'Post', 'url' => route('feed.show', $post->id)],
        ['label' => 'Edit']
    ]])

    <div style="background:#f4f6f9;min-height:100vh;padding:40px 0 60px;">
        <div class="container">
            <div style="max-width:700px;margin:0 auto;">
                <div style="margin-bottom:24px;">
                    <h1 style="font-size:24px;font-weight:700;color:#1a1a2e;margin:0 0 4px;">Edit Post</h1>
                    <p style="color:#888;font-size:14px;margin:0;">Update your post content.</p>
                </div>

                <div style="background:#fff;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.06);padding:28px;">
                    @if($errors->any())
                        <div style="background:#f8d7da;color:#721c24;border:1px solid #f5c6cb;padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:13px;">
                            <ul style="margin:0;padding-left:18px;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('feed.update', $post->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Post Type (read-only) --}}
                        <div style="margin-bottom:20px;">
                            <label style="font-size:13px;font-weight:600;color:#444;display:block;margin-bottom:6px;">Post Type</label>
                            @php
                                $typeBadges = [
                                    'text' => '#666', 'photo' => '#3498db', 'video' => '#9b59b6',
                                    'link' => '#16a085', 'announcement' => '#e67e22', 'offer' => '#27ae60',
                                ];
                            @endphp
                            <span style="background:{{ $typeBadges[$post->type] ?? '#666' }};color:#fff;padding:5px 14px;border-radius:20px;font-size:12px;font-weight:600;text-transform:uppercase;">
                                {{ ucfirst($post->type) }}
                            </span>
                        </div>

                        {{-- Title --}}
                        @if(in_array($post->type, ['text', 'link', 'announcement', 'offer']))
                            <div style="margin-bottom:18px;">
                                <label style="font-size:13px;font-weight:600;color:#444;display:block;margin-bottom:6px;">Title</label>
                                <input type="text" name="title" value="{{ old('title', $post->title) }}"
                                       placeholder="Enter title..."
                                       style="width:100%;padding:10px 14px;border:1px solid #ddd;border-radius:8px;font-size:14px;font-family:'Poppins',sans-serif;color:#333;outline:none;"
                                       onfocus="this.style.borderColor='#c8a96e'" onblur="this.style.borderColor='#ddd'">
                            </div>
                        @endif

                        {{-- Content --}}
                        <div style="margin-bottom:18px;">
                            <label style="font-size:13px;font-weight:600;color:#444;display:block;margin-bottom:6px;">Content</label>
                            <textarea name="content" rows="5"
                                      style="width:100%;padding:12px 14px;border:1px solid #ddd;border-radius:8px;font-size:14px;font-family:'Poppins',sans-serif;color:#333;resize:vertical;outline:none;line-height:1.6;"
                                      onfocus="this.style.borderColor='#c8a96e'" onblur="this.style.borderColor='#ddd'">{{ old('content', $post->content) }}</textarea>
                        </div>

                        {{-- Video URL --}}
                        @if($post->type === 'video')
                            <div style="margin-bottom:18px;">
                                <label style="font-size:13px;font-weight:600;color:#444;display:block;margin-bottom:6px;">Video URL</label>
                                <input type="url" name="video_url" value="{{ old('video_url', $post->video_url) }}"
                                       placeholder="https://www.youtube.com/watch?v=..."
                                       style="width:100%;padding:10px 14px;border:1px solid #ddd;border-radius:8px;font-size:14px;font-family:'Poppins',sans-serif;color:#333;outline:none;"
                                       onfocus="this.style.borderColor='#c8a96e'" onblur="this.style.borderColor='#ddd'">
                            </div>
                        @endif

                        {{-- Link fields --}}
                        @if($post->type === 'link')
                            <div style="margin-bottom:18px;">
                                <label style="font-size:13px;font-weight:600;color:#444;display:block;margin-bottom:6px;">URL</label>
                                <input type="url" name="link_url" value="{{ old('link_url', $post->link_url) }}"
                                       style="width:100%;padding:10px 14px;border:1px solid #ddd;border-radius:8px;font-size:14px;font-family:'Poppins',sans-serif;color:#333;outline:none;"
                                       onfocus="this.style.borderColor='#c8a96e'" onblur="this.style.borderColor='#ddd'">
                            </div>
                            <div style="margin-bottom:18px;">
                                <label style="font-size:13px;font-weight:600;color:#444;display:block;margin-bottom:6px;">Link Title</label>
                                <input type="text" name="link_title" value="{{ old('link_title', $post->link_title) }}"
                                       style="width:100%;padding:10px 14px;border:1px solid #ddd;border-radius:8px;font-size:14px;font-family:'Poppins',sans-serif;color:#333;outline:none;"
                                       onfocus="this.style.borderColor='#c8a96e'" onblur="this.style.borderColor='#ddd'">
                            </div>
                            <div style="margin-bottom:18px;">
                                <label style="font-size:13px;font-weight:600;color:#444;display:block;margin-bottom:6px;">Link Description</label>
                                <textarea name="link_description" rows="2"
                                          style="width:100%;padding:10px 14px;border:1px solid #ddd;border-radius:8px;font-size:14px;font-family:'Poppins',sans-serif;color:#333;resize:none;outline:none;"
                                          onfocus="this.style.borderColor='#c8a96e'" onblur="this.style.borderColor='#ddd'">{{ old('link_description', $post->link_description) }}</textarea>
                            </div>
                        @endif

                        {{-- Additional photos --}}
                        @if($post->type === 'photo')
                            @if(!empty($post->media))
                                <div style="margin-bottom:18px;">
                                    <label style="font-size:13px;font-weight:600;color:#444;display:block;margin-bottom:8px;">Current Photos</label>
                                    <div style="display:flex;flex-wrap:wrap;gap:8px;">
                                        @foreach($post->media as $photo)
                                            <img src="{{ asset('storage/' . $photo) }}" alt="" style="width:80px;height:80px;border-radius:6px;object-fit:cover;">
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <div style="margin-bottom:18px;">
                                <label style="font-size:13px;font-weight:600;color:#444;display:block;margin-bottom:6px;">Add More Photos</label>
                                <input type="file" name="media[]" multiple accept="image/*"
                                       style="width:100%;padding:10px;border:1px dashed #ddd;border-radius:8px;font-size:13px;color:#666;">
                            </div>
                        @endif

                        <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:8px;">
                            <a href="{{ route('feed.show', $post->id) }}" style="padding:10px 20px;border-radius:8px;border:1px solid #ddd;background:#fff;color:#555;font-size:14px;text-decoration:none;">
                                Cancel
                            </a>
                            <button type="submit" style="background:#c8a96e;color:#fff;border:none;padding:10px 28px;border-radius:8px;font-size:14px;cursor:pointer;font-weight:600;">
                                <i class="ti-check" style="margin-right:6px;"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
