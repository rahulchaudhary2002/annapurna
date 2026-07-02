@extends('layouts.dashboard')

@section('page_title', 'New Post — ' . $business->name)

@section('content')

    <div class="d-flex align-items-center mb-3" style="gap: 12px;">
        <a href="{{ route('dashboard.businesses.posts.index', $business) }}" class="btn-dash-secondary btn-dash-sm">
            <i class="ti-arrow-left"></i> Back
        </a>
        <div>
            <h2 style="font-size: 18px; color: #1a1a2e; margin: 0;">Create Post — {{ $business->name }}</h2>
        </div>
    </div>

    @if($errors->any())
    <div class="dash-alert dash-alert-error">
        <ul style="margin: 0; padding-left: 18px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div style="max-width: 700px;">
        <div class="dash-card">
            <h3 class="dash-card-title">Post Details</h3>

            <form method="POST" action="{{ route('dashboard.businesses.posts.store', $business) }}" enctype="multipart/form-data">
                @csrf

                <div class="dash-form-group">
                    <label>Post Type <span style="color: #e74c3c;">*</span></label>
                    <select name="type" class="dash-form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" required id="postType">
                        <option value="text" {{ old('type', 'text') == 'text' ? 'selected' : '' }}>Text Update</option>
                        <option value="photo" {{ old('type') == 'photo' ? 'selected' : '' }}>Photo</option>
                        <option value="link" {{ old('type') == 'link' ? 'selected' : '' }}>Link / Announcement</option>
                        <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>Video</option>
                    </select>
                    @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="dash-form-group">
                    <label>Title <small class="text-muted">(optional)</small></label>
                    <input type="text" name="title" value="{{ old('title') }}"
                           class="dash-form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                           placeholder="Post title or headline">
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="dash-form-group">
                    <label>Content</label>
                    <textarea name="content" class="dash-form-control {{ $errors->has('content') ? 'is-invalid' : '' }}"
                              rows="6" placeholder="Write your post content here...">{{ old('content') }}</textarea>
                    @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="dash-form-group" id="mediaGroup">
                    <label>Photo / Media</label>
                    <input type="file" name="media" accept="image/*"
                           class="dash-form-control {{ $errors->has('media') ? 'is-invalid' : '' }}">
                    <small class="text-muted">Max 4MB. JPG, PNG, GIF.</small>
                    @error('media') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="dash-form-group" id="linkGroup">
                    <label>URL / Link</label>
                    <input type="url" name="link" value="{{ old('link') }}"
                           class="dash-form-control {{ $errors->has('link') ? 'is-invalid' : '' }}"
                           placeholder="https://...">
                    @error('link') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div style="display: flex; gap: 12px; margin-top: 8px;">
                    <button type="submit" class="btn-dash-primary">
                        <i class="ti-check"></i> Publish Post
                    </button>
                    <a href="{{ route('dashboard.businesses.posts.index', $business) }}" class="btn-dash-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection
