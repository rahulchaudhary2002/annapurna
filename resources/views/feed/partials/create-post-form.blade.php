@php $selectedType = request('type', 'text'); @endphp

<div style="background:#fff;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.06);overflow:hidden;">
    {{-- Post Type Tabs --}}
    <div style="display:flex;border-bottom:2px solid #f0f0f0;overflow-x:auto;" id="post-type-tabs">
        @foreach([
            'text'         => ['icon' => 'ti-pencil',       'label' => 'Text'],
            'photo'        => ['icon' => 'ti-image',        'label' => 'Photo', 'color' => '#3498db'],
            'video'        => ['icon' => 'ti-video-camera', 'label' => 'Video', 'color' => '#9b59b6'],
            'link'         => ['icon' => 'ti-link',         'label' => 'Link',  'color' => '#16a085'],
            'announcement' => ['icon' => 'ti-announcement', 'label' => 'Announcement', 'color' => '#e67e22'],
            'offer'        => ['icon' => 'ti-tag',          'label' => 'Offer', 'color' => '#27ae60'],
        ] as $typeKey => $typeInfo)
            <button type="button"
                    class="post-type-tab"
                    data-type="{{ $typeKey }}"
                    style="padding:14px 18px;border:none;background:transparent;cursor:pointer;font-size:13px;font-family:'Poppins',sans-serif;white-space:nowrap;color:{{ $selectedType === $typeKey ? ($typeInfo['color'] ?? '#c8a96e') : '#666' }};border-bottom:{{ $selectedType === $typeKey ? '3px solid ' . ($typeInfo['color'] ?? '#c8a96e') : '3px solid transparent' }};font-weight:{{ $selectedType === $typeKey ? '600' : '400' }};display:flex;align-items:center;gap:6px;transition:all 0.2s;"
                    onclick="selectPostType('{{ $typeKey }}')">
                <i class="{{ $typeInfo['icon'] }}"></i> {{ $typeInfo['label'] }}
            </button>
        @endforeach
    </div>

    {{-- Form --}}
    <form method="POST" action="{{ route('feed.store') }}" enctype="multipart/form-data" id="create-post-form" style="padding:24px;">
        @csrf
        <input type="hidden" name="type" id="post-type-input" value="{{ $selectedType }}">

        {{-- Errors --}}
        @if($errors->any())
            <div style="background:#f8d7da;color:#721c24;border:1px solid #f5c6cb;padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:13px;">
                <ul style="margin:0;padding-left:18px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Post as (if user has businesses) --}}
        @if(isset($postableBusinesses) && $postableBusinesses->count() > 0)
            <div style="margin-bottom:20px;">
                <label style="font-size:13px;font-weight:600;color:#444;display:block;margin-bottom:6px;">Post As</label>
                <select name="business_id" style="width:100%;padding:10px 14px;border:1px solid #ddd;border-radius:8px;font-size:14px;font-family:'Poppins',sans-serif;color:#333;background:#fff;cursor:pointer;outline:none;" onfocus="this.style.borderColor='#c8a96e'" onblur="this.style.borderColor='#ddd'">
                    <option value="">My Personal Account</option>
                    @foreach($postableBusinesses as $biz)
                        <option value="{{ $biz->id }}" {{ (isset($selectedBusiness) && $selectedBusiness && $selectedBusiness->id === $biz->id) ? 'selected' : '' }}>
                            {{ $biz->name }} ({{ ucfirst(str_replace('_', ' ', $biz->type)) }})
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

        {{-- Title (shown for announcement, offer; optional for others) --}}
        <div id="field-title" style="margin-bottom:18px;{{ !in_array($selectedType, ['announcement', 'offer', 'text', 'link']) ? 'display:none;' : '' }}">
            <label style="font-size:13px;font-weight:600;color:#444;display:block;margin-bottom:6px;">
                Title <span id="title-required-indicator" style="{{ in_array($selectedType, ['announcement', 'offer']) ? '' : 'display:none;' }}color:#e74c3c;">*</span>
            </label>
            <input type="text" name="title" value="{{ old('title') }}"
                   placeholder="Enter a title..."
                   style="width:100%;padding:10px 14px;border:1px solid #ddd;border-radius:8px;font-size:14px;font-family:'Poppins',sans-serif;color:#333;outline:none;"
                   onfocus="this.style.borderColor='#c8a96e'" onblur="this.style.borderColor='#ddd'">
        </div>

        {{-- Content textarea --}}
        <div style="margin-bottom:18px;">
            <label style="font-size:13px;font-weight:600;color:#444;display:block;margin-bottom:6px;">
                <span id="content-label">What's on your mind?</span>
            </label>
            <textarea name="content" rows="4" id="content-textarea"
                      placeholder="Share your thoughts, travel tips, or updates with the community..."
                      style="width:100%;padding:12px 14px;border:1px solid #ddd;border-radius:8px;font-size:14px;font-family:'Poppins',sans-serif;color:#333;resize:vertical;outline:none;line-height:1.6;"
                      onfocus="this.style.borderColor='#c8a96e'" onblur="this.style.borderColor='#ddd'">{{ old('content') }}</textarea>
        </div>

        {{-- Photo upload --}}
        <div id="field-photo" style="{{ $selectedType === 'photo' ? '' : 'display:none;' }}margin-bottom:18px;">
            <label style="font-size:13px;font-weight:600;color:#444;display:block;margin-bottom:6px;">
                Photos <span style="color:#e74c3c;">*</span>
            </label>
            <div style="border:2px dashed #ddd;border-radius:8px;padding:24px;text-align:center;cursor:pointer;transition:border-color 0.2s;"
                 onclick="document.getElementById('photo-input').click()"
                 ondragover="this.style.borderColor='#c8a96e'" ondragleave="this.style.borderColor='#ddd'">
                <i class="ti-image" style="font-size:32px;color:#ddd;display:block;margin-bottom:8px;"></i>
                <div style="font-size:14px;color:#888;">Click to select photos or drag &amp; drop</div>
                <div style="font-size:12px;color:#bbb;margin-top:4px;">PNG, JPG, GIF up to 5MB each</div>
                <input type="file" id="photo-input" name="media[]" multiple accept="image/*" style="display:none;" onchange="previewPhotos(this)">
            </div>
            <div id="photo-previews" style="display:flex;flex-wrap:wrap;gap:8px;margin-top:12px;"></div>
        </div>

        {{-- Video --}}
        <div id="field-video" style="{{ $selectedType === 'video' ? '' : 'display:none;' }}margin-bottom:18px;">
            <label style="font-size:13px;font-weight:600;color:#444;display:block;margin-bottom:6px;">Video</label>
            <div style="margin-bottom:12px;">
                <div style="display:flex;gap:8px;margin-bottom:10px;">
                    <button type="button" id="video-url-tab" class="video-source-tab active"
                            style="padding:7px 16px;border-radius:6px;border:2px solid #c8a96e;background:#c8a96e;color:#fff;font-size:13px;cursor:pointer;font-family:'Poppins',sans-serif;"
                            onclick="switchVideoSource('url')">YouTube URL</button>
                    <button type="button" id="video-file-tab" class="video-source-tab"
                            style="padding:7px 16px;border-radius:6px;border:2px solid #ddd;background:#fff;color:#555;font-size:13px;cursor:pointer;font-family:'Poppins',sans-serif;"
                            onclick="switchVideoSource('file')">Upload File</button>
                </div>
                <div id="video-url-field">
                    <input type="url" name="video_url" value="{{ old('video_url') }}"
                           placeholder="https://www.youtube.com/watch?v=..."
                           style="width:100%;padding:10px 14px;border:1px solid #ddd;border-radius:8px;font-size:14px;font-family:'Poppins',sans-serif;color:#333;outline:none;"
                           onfocus="this.style.borderColor='#c8a96e'" onblur="this.style.borderColor='#ddd'">
                </div>
                <div id="video-file-field" style="display:none;">
                    <input type="file" name="video_file" accept="video/mp4,video/webm,video/ogg"
                           style="width:100%;padding:10px 14px;border:1px solid #ddd;border-radius:8px;font-size:14px;font-family:'Poppins',sans-serif;color:#333;">
                    <div style="font-size:12px;color:#aaa;margin-top:4px;">MP4, WebM, OGG up to 50MB</div>
                </div>
            </div>
        </div>

        {{-- Link --}}
        <div id="field-link" style="{{ $selectedType === 'link' ? '' : 'display:none;' }}margin-bottom:18px;">
            <label style="font-size:13px;font-weight:600;color:#444;display:block;margin-bottom:6px;">
                URL <span style="color:#e74c3c;">*</span>
            </label>
            <input type="url" name="link_url" value="{{ old('link_url') }}"
                   placeholder="https://example.com"
                   style="width:100%;padding:10px 14px;border:1px solid #ddd;border-radius:8px;font-size:14px;font-family:'Poppins',sans-serif;color:#333;outline:none;margin-bottom:12px;"
                   onfocus="this.style.borderColor='#c8a96e'" onblur="this.style.borderColor='#ddd'">
            <input type="text" name="link_title" value="{{ old('link_title') }}"
                   placeholder="Link title (optional)"
                   style="width:100%;padding:10px 14px;border:1px solid #ddd;border-radius:8px;font-size:14px;font-family:'Poppins',sans-serif;color:#333;outline:none;margin-bottom:12px;"
                   onfocus="this.style.borderColor='#c8a96e'" onblur="this.style.borderColor='#ddd'">
            <textarea name="link_description" rows="2"
                      placeholder="Brief description (optional)"
                      style="width:100%;padding:10px 14px;border:1px solid #ddd;border-radius:8px;font-size:14px;font-family:'Poppins',sans-serif;color:#333;resize:none;outline:none;"
                      onfocus="this.style.borderColor='#c8a96e'" onblur="this.style.borderColor='#ddd'">{{ old('link_description') }}</textarea>
        </div>

        {{-- Submit --}}
        <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:8px;">
            <a href="{{ route('feed.index') }}" style="padding:10px 20px;border-radius:8px;border:1px solid #ddd;background:#fff;color:#555;font-size:14px;text-decoration:none;font-family:'Poppins',sans-serif;">
                Cancel
            </a>
            <button type="submit" style="background:#c8a96e;color:#fff;border:none;padding:10px 28px;border-radius:8px;font-size:14px;font-family:'Poppins',sans-serif;cursor:pointer;font-weight:600;transition:background 0.2s;"
                    onmouseover="this.style.background='#b8924a'" onmouseout="this.style.background='#c8a96e'">
                <i class="ti-check" style="margin-right:6px;"></i> Publish Post
            </button>
        </div>
    </form>
</div>

<script>
var currentType = '{{ $selectedType }}';

function selectPostType(type) {
    currentType = type;
    document.getElementById('post-type-input').value = type;

    // Update tabs
    document.querySelectorAll('.post-type-tab').forEach(function(tab) {
        const isActive = tab.dataset.type === type;
        const colors = {
            'text': '#c8a96e', 'photo': '#3498db', 'video': '#9b59b6',
            'link': '#16a085', 'announcement': '#e67e22', 'offer': '#27ae60'
        };
        const color = colors[tab.dataset.type] || '#c8a96e';
        tab.style.color = isActive ? color : '#666';
        tab.style.borderBottom = isActive ? ('3px solid ' + color) : '3px solid transparent';
        tab.style.fontWeight = isActive ? '600' : '400';
    });

    // Show/hide fields
    document.getElementById('field-photo').style.display = type === 'photo' ? 'block' : 'none';
    document.getElementById('field-video').style.display = type === 'video' ? 'block' : 'none';
    document.getElementById('field-link').style.display = type === 'link' ? 'block' : 'none';

    const showTitle = ['text', 'link', 'announcement', 'offer'].includes(type);
    document.getElementById('field-title').style.display = showTitle ? 'block' : 'none';
    document.getElementById('title-required-indicator').style.display = ['announcement', 'offer'].includes(type) ? 'inline' : 'none';

    // Update content label
    const labels = {
        'text': "What's on your mind?",
        'photo': 'Caption (optional)',
        'video': 'Video description',
        'link': 'Your thoughts on this link',
        'announcement': 'Announcement details',
        'offer': 'Offer description & terms'
    };
    document.getElementById('content-label').textContent = labels[type] || "What's on your mind?";
}

function switchVideoSource(source) {
    if (source === 'url') {
        document.getElementById('video-url-field').style.display = 'block';
        document.getElementById('video-file-field').style.display = 'none';
        document.getElementById('video-url-tab').style.background = '#c8a96e';
        document.getElementById('video-url-tab').style.color = '#fff';
        document.getElementById('video-url-tab').style.borderColor = '#c8a96e';
        document.getElementById('video-file-tab').style.background = '#fff';
        document.getElementById('video-file-tab').style.color = '#555';
        document.getElementById('video-file-tab').style.borderColor = '#ddd';
    } else {
        document.getElementById('video-url-field').style.display = 'none';
        document.getElementById('video-file-field').style.display = 'block';
        document.getElementById('video-file-tab').style.background = '#c8a96e';
        document.getElementById('video-file-tab').style.color = '#fff';
        document.getElementById('video-file-tab').style.borderColor = '#c8a96e';
        document.getElementById('video-url-tab').style.background = '#fff';
        document.getElementById('video-url-tab').style.color = '#555';
        document.getElementById('video-url-tab').style.borderColor = '#ddd';
    }
}

function previewPhotos(input) {
    const previews = document.getElementById('photo-previews');
    previews.innerHTML = '';
    const files = Array.from(input.files);
    files.forEach(function(file) {
        if (!file.type.startsWith('image/')) return;
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.style.cssText = 'position:relative;width:80px;height:80px;border-radius:6px;overflow:hidden;';
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.cssText = 'width:100%;height:100%;object-fit:cover;';
            div.appendChild(img);
            previews.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
}
</script>
