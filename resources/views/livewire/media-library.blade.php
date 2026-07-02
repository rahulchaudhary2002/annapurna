<div>
    {{-- Trigger --}}
    <x-filament::button type="button" wire:click="openModal" icon="heroicon-m-photo" color="gray" size="sm">
        Select from Gallery
    </x-filament::button>

    @if($showModal)
    <style>
        .ml-backdrop {
            position: fixed; inset: 0; z-index: 9990;
            background: rgba(0,0,0,.45);
            backdrop-filter: blur(3px);
            animation: ml-fade .18s ease;
        }
        .ml-wrap {
            position: fixed; inset: 0; z-index: 9995;
            display: flex; align-items: center; justify-content: center;
            padding: 24px; pointer-events: none;
        }
        .ml-dialog {
            pointer-events: auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 24px 64px rgba(0,0,0,.18), 0 4px 16px rgba(0,0,0,.08);
            width: 100%; max-width: 780px;
            max-height: 88vh;
            display: flex; flex-direction: column;
            overflow: hidden;
            animation: ml-pop .22s cubic-bezier(.34,1.56,.64,1);
        }
        .dark .ml-dialog { background: #1a1a2e; }

        /* Header */
        .ml-header {
            display: flex; align-items: flex-start; justify-content: space-between;
            padding: 24px 28px 16px;
            flex-shrink: 0;
        }
        .ml-title { font-size: 17px; font-weight: 700; color: #111827; margin: 0; line-height: 1.3; }
        .dark .ml-title { color: #f9fafb; }
        .ml-subtitle { font-size: 13px; color: #9ca3af; margin: 3px 0 0; }
        .ml-close {
            width: 32px; height: 32px; border-radius: 50%; border: none; background: transparent;
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            color: #9ca3af; transition: background .15s, color .15s; flex-shrink: 0; margin-left: 12px;
        }
        .ml-close:hover { background: #f3f4f6; color: #374151; }

        /* Tabs */
        .ml-tabs {
            display: flex; gap: 0; border-bottom: 1px solid #e5e7eb;
            padding: 0 28px; flex-shrink: 0;
        }
        .dark .ml-tabs { border-color: rgba(255,255,255,.1); }
        .ml-tab {
            display: flex; align-items: center; gap: 7px;
            padding: 0 4px 13px; margin-right: 28px;
            font-size: 13.5px; font-weight: 500; color: #6b7280;
            background: transparent; border: none; border-bottom: 2px solid transparent;
            cursor: pointer; transition: color .15s, border-color .15s; margin-bottom: -1px;
        }
        .ml-tab:hover { color: #374151; }
        .ml-tab.active { color: #f59e0b; border-bottom-color: #f59e0b; }
        .ml-tab-count {
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 20px; height: 20px; padding: 0 6px;
            border-radius: 10px; font-size: 11px; font-weight: 600;
        }
        .ml-tab.active .ml-tab-count { background: #f59e0b; color: #fff; }
        .ml-tab:not(.active) .ml-tab-count { background: #f3f4f6; color: #6b7280; }

        /* Body */
        .ml-body { display: flex; flex-direction: column; flex: 1; min-height: 0; overflow: hidden; background: #f9fafb; }
        .dark .ml-body { background: #111827; }

        /* Toolbar (search + sort) */
        .ml-toolbar { display: flex; gap: 10px; padding: 14px 28px 10px; flex-shrink: 0; background: #fff; border-bottom: 1px solid #f3f4f6; }
        .dark .ml-toolbar { background: #1a1a2e; border-color: rgba(255,255,255,.07); }
        .ml-search-wrap { position: relative; flex: 1; }
        .ml-search-icon { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); color: #9ca3af; pointer-events: none; }
        .ml-search {
            width: 100%; padding: 8px 12px 8px 34px; border-radius: 9px;
            border: 1.5px solid #e5e7eb; background: #f9fafb;
            font-size: 13px; color: #111827; outline: none; transition: border .15s, background .15s;
            box-sizing: border-box;
        }
        .ml-search:focus { border-color: #f59e0b; background: #fff; box-shadow: 0 0 0 3px rgba(245,158,11,.12); }
        .ml-sort {
            padding: 8px 12px; border-radius: 9px; border: 1.5px solid #e5e7eb;
            background: #f9fafb; font-size: 13px; color: #374151;
            cursor: pointer; outline: none; white-space: nowrap;
        }
        .ml-sort:focus { border-color: #f59e0b; }

        /* Chips */
        .ml-chips { display: flex; flex-wrap: wrap; gap: 7px; padding: 10px 28px 12px; flex-shrink: 0; background: #fff; }
        .dark .ml-chips { background: #1a1a2e; }
        .ml-chip {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;
            cursor: pointer; border: none; transition: background .15s, color .15s;
            background: #f3f4f6; color: #4b5563;
        }
        .ml-chip:hover { background: #e5e7eb; }
        .ml-chip.active { background: #111827; color: #fff; }
        .ml-chip-count { opacity: .65; }

        /* Grid */
        .ml-grid-wrap { flex: 1; overflow-y: auto; padding: 20px 28px; }
        .ml-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; }
        .ml-card {
            display: flex; flex-direction: column; cursor: pointer;
            border: none; background: transparent; padding: 0; text-align: left;
            border-radius: 10px; outline: none;
        }
        .ml-img-wrap {
            position: relative; aspect-ratio: 1; width: 100%;
            border-radius: 10px; overflow: hidden;
            background: #e5e7eb;
            border: 2px solid transparent;
            transition: border-color .15s, box-shadow .15s;
        }
        .ml-card:hover .ml-img-wrap { border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245,158,11,.15); }
        .ml-card.selected .ml-img-wrap { border-color: #f59e0b; box-shadow: 0 0 0 4px rgba(245,158,11,.2); }
        .ml-img-wrap img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .2s; }
        .ml-card:hover .ml-img-wrap img { transform: scale(1.04); }
        .ml-check {
            position: absolute; top: 8px; right: 8px;
            width: 24px; height: 24px; border-radius: 50%;
            background: #f59e0b; display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 6px rgba(0,0,0,.25);
        }
        .ml-unavailable {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            height: 100%; gap: 6px; color: #d1d5db; font-size: 11px;
        }
        .ml-caption { margin-top: 7px; padding: 0 2px; }
        .ml-caption-title { font-size: 12.5px; font-weight: 600; color: #111827; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .ml-card.selected .ml-caption-title { color: #d97706; }
        .ml-caption-alt { font-size: 11px; color: #9ca3af; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-top: 1px; }
        .dark .ml-caption-title { color: #f3f4f6; }
        .dark .ml-card.selected .ml-caption-title { color: #fbbf24; }

        /* Empty state */
        .ml-empty { display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 64px 24px; text-align: center; }
        .ml-empty-icon { width: 60px; height: 60px; border-radius: 14px; background: #f3f4f6; display: flex; align-items: center; justify-content: center; margin-bottom: 14px; }
        .ml-empty-title { font-size: 14px; font-weight: 600; color: #374151; margin: 0 0 4px; }
        .ml-empty-sub { font-size: 12.5px; color: #9ca3af; margin: 0 0 14px; }
        .ml-empty-btn { display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 8px; background: #fff7ed; color: #b45309; font-size: 12.5px; font-weight: 600; border: none; cursor: pointer; transition: background .15s; }
        .ml-empty-btn:hover { background: #fef3c7; }

        /* Pagination */
        .ml-page { display: flex; align-items: center; justify-content: space-between; padding: 10px 28px; border-top: 1px solid #e5e7eb; background: #fff; flex-shrink: 0; }
        .dark .ml-page { background: #1a1a2e; border-color: rgba(255,255,255,.1); }
        .ml-page-info { font-size: 12px; color: #9ca3af; }
        .ml-page-btns { display: flex; align-items: center; gap: 8px; }
        .ml-page-btn { padding: 5px 12px; border-radius: 7px; border: 1.5px solid #e5e7eb; background: #fff; font-size: 12px; color: #374151; cursor: pointer; transition: background .15s; }
        .ml-page-btn:hover:not(:disabled) { background: #f9fafb; }
        .ml-page-btn:disabled { opacity: .4; cursor: not-allowed; }
        .ml-page-num { font-size: 12px; color: #6b7280; padding: 0 4px; }

        /* Footer */
        .ml-footer { display: flex; align-items: center; justify-content: space-between; padding: 14px 28px; border-top: 1px solid #e5e7eb; background: #fff; flex-shrink: 0; }
        .dark .ml-footer { background: #1a1a2e; border-color: rgba(255,255,255,.1); }
        .ml-selected-label { font-size: 13.5px; color: #6b7280; }
        .ml-selected-name { font-weight: 700; color: #111827; }
        .dark .ml-selected-name { color: #f9fafb; }
        .ml-footer-btns { display: flex; gap: 10px; }
        .ml-btn-cancel { padding: 8px 18px; border-radius: 9px; border: 1.5px solid #e5e7eb; background: #fff; font-size: 13.5px; font-weight: 500; color: #374151; cursor: pointer; transition: background .15s; }
        .ml-btn-cancel:hover { background: #f9fafb; }
        .ml-btn-insert { padding: 8px 18px; border-radius: 9px; border: none; background: #f59e0b; font-size: 13.5px; font-weight: 600; color: #fff; cursor: pointer; transition: background .15s, opacity .15s; }
        .ml-btn-insert:hover:not(:disabled) { background: #d97706; }
        .ml-btn-insert:disabled { opacity: .45; cursor: not-allowed; }

        /* Upload tab */
        .ml-upload-body { flex: 1; overflow-y: auto; padding: 28px; background: #f9fafb; }
        .dark .ml-upload-body { background: #111827; }
        .ml-upload-inner { max-width: 440px; margin: 0 auto; }
        .ml-field-label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px; }
        .dark .ml-field-label { color: #d1d5db; }
        .ml-dropzone {
            display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px;
            padding: 36px 24px; border-radius: 12px;
            border: 2px dashed #d1d5db; background: #fff;
            cursor: pointer; transition: border .15s, background .15s; text-align: center;
        }
        .ml-dropzone:hover { border-color: #f59e0b; background: #fffbeb; }
        .ml-dropzone-icon { width: 44px; height: 44px; border-radius: 10px; background: #fff7ed; display: flex; align-items: center; justify-content: center; color: #f59e0b; }
        .ml-dropzone-title { font-size: 13.5px; font-weight: 600; color: #374151; margin: 0; }
        .ml-dropzone-sub { font-size: 12px; color: #9ca3af; margin: 0; }
        .ml-preview-wrap { border-radius: 12px; overflow: hidden; border: 2px solid #f59e0b; background: #f9fafb; }
        .ml-preview-img { width: 100%; max-height: 200px; object-fit: contain; padding: 12px; display: block; box-sizing: border-box; }
        .ml-preview-bar { display: flex; align-items: center; justify-content: space-between; padding: 8px 14px; border-top: 1px solid #e5e7eb; background: rgba(255,255,255,.8); }
        .ml-preview-name { font-size: 12px; color: #6b7280; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .ml-remove-btn { font-size: 12px; color: #ef4444; background: none; border: none; cursor: pointer; flex-shrink: 0; margin-left: 10px; }
        .ml-error { font-size: 12px; color: #ef4444; margin-top: 6px; }
        .ml-meta-card { border-radius: 10px; border: 1.5px solid #e5e7eb; background: #fff; padding: 18px; margin-top: 18px; }
        .dark .ml-meta-card { border-color: rgba(255,255,255,.1); background: rgba(255,255,255,.05); }
        .ml-meta-label { font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: #9ca3af; margin: 0 0 14px; }
        .ml-input {
            width: 100%; padding: 8px 12px; border-radius: 8px;
            border: 1.5px solid #e5e7eb; background: #f9fafb;
            font-size: 13px; color: #111827; outline: none;
            transition: border .15s, background .15s; box-sizing: border-box; margin-bottom: 12px;
        }
        .ml-input:focus { border-color: #f59e0b; background: #fff; box-shadow: 0 0 0 3px rgba(245,158,11,.12); }
        .ml-input::placeholder { color: #d1d5db; }
        .ml-input-label { display: block; font-size: 12px; font-weight: 500; color: #6b7280; margin-bottom: 4px; }
        .ml-submit { width: 100%; padding: 10px; border-radius: 9px; border: none; background: #f59e0b; color: #fff; font-size: 14px; font-weight: 600; cursor: pointer; transition: background .15s; margin-top: 18px; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .ml-submit:hover:not(:disabled) { background: #d97706; }
        .ml-submit:disabled { opacity: .5; cursor: not-allowed; }

        @keyframes ml-fade { from { opacity:0 } to { opacity:1 } }
        @keyframes ml-pop  { from { opacity:0; transform:scale(.96) translateY(8px) } to { opacity:1; transform:scale(1) translateY(0) } }
    </style>

    {{-- Backdrop --}}
    <div class="ml-backdrop" wire:click="closeModal"></div>

    {{-- Dialog --}}
    <div class="ml-wrap">
        <div class="ml-dialog">

            {{-- Header --}}
            <div class="ml-header">
                <div>
                    <p class="ml-title">Select an image</p>
                    <p class="ml-subtitle">Choose from your library or upload a new image</p>
                </div>
                <button class="ml-close" type="button" wire:click="closeModal">
                    <x-heroicon-s-x-mark style="width:18px;height:18px;" />
                </button>
            </div>

            {{-- Tabs --}}
            <div class="ml-tabs">
                <button type="button" wire:click="$set('activeTab','library')" class="ml-tab {{ $activeTab==='library' ? 'active' : '' }}">
                    <x-heroicon-m-squares-2x2 style="width:15px;height:15px;" />
                    Library
                    @if($totalCount > 0)
                        <span class="ml-tab-count">{{ $totalCount }}</span>
                    @endif
                </button>
                <button type="button" wire:click="$set('activeTab','upload')" class="ml-tab {{ $activeTab==='upload' ? 'active' : '' }}">
                    <x-heroicon-m-arrow-up-tray style="width:15px;height:15px;" />
                    Upload
                </button>
            </div>

            {{-- ═══ LIBRARY TAB ═══════════════════════════════════════ --}}
            @if($activeTab === 'library')
                <div class="ml-body">

                    {{-- Search + Sort --}}
                    <div class="ml-toolbar">
                        <div class="ml-search-wrap">
                            <span class="ml-search-icon">
                                <x-heroicon-m-magnifying-glass style="width:15px;height:15px;" />
                            </span>
                            <input
                                type="text"
                                class="ml-search"
                                wire:model.live.debounce.300ms="search"
                                placeholder="Search by title or alt text"
                            />
                        </div>
                        <select class="ml-sort" wire:model.live="sortBy">
                            <option value="newest">⬇ Newest</option>
                            <option value="oldest">⬆ Oldest</option>
                        </select>
                    </div>

                    {{-- Album chips --}}
                    @if($albums->isNotEmpty())
                        <div class="ml-chips">
                            <button type="button" wire:click="$set('filterAlbum','all')"
                                class="ml-chip {{ $filterAlbum==='all' ? 'active' : '' }}">
                                All <span class="ml-chip-count">{{ $totalCount }}</span>
                            </button>
                            @foreach($albums as $album)
                                <button type="button" wire:click="$set('filterAlbum','{{ $album->id }}')"
                                    class="ml-chip {{ $filterAlbum == $album->id ? 'active' : '' }}">
                                    {{ $album->name }}
                                    <span class="ml-chip-count">{{ $album->images_count }}</span>
                                </button>
                            @endforeach
                        </div>
                    @endif

                    {{-- Image grid --}}
                    <div class="ml-grid-wrap">
                        @if($images && $images->count())
                            <div class="ml-grid">
                                @foreach($images as $image)
                                    @php $isSel = $selectedPath === $image->image; @endphp
                                    <button
                                        type="button"
                                        wire:click="pickImage('{{ addslashes($image->image) }}','{{ addslashes($image->title ?? $image->alt_text ?? '') }}')"
                                        wire:key="img-{{ $image->id }}"
                                        class="ml-card {{ $isSel ? 'selected' : '' }}"
                                    >
                                        <div class="ml-img-wrap">
                                            <img
                                                src="{{ asset('storage/'.$image->image) }}"
                                                alt="{{ $image->alt_text ?? $image->title ?? '' }}"
                                                loading="lazy"
                                                onerror="this.style.display='none';this.nextElementSibling.style.display='flex';"
                                            />
                                            <div class="ml-unavailable" style="display:none;">
                                                <x-heroicon-o-photo style="width:28px;height:28px;" />
                                                <span>Image unavailable</span>
                                            </div>
                                            @if($isSel)
                                                <div class="ml-check">
                                                    <x-heroicon-s-check style="width:13px;height:13px;color:#fff;" />
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-caption">
                                            <div class="ml-caption-title">{{ $image->title ?: '—' }}</div>
                                            @if($image->alt_text)
                                                <div class="ml-caption-alt">{{ $image->alt_text }}</div>
                                            @endif
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        @else
                            <div class="ml-empty">
                                <div class="ml-empty-icon">
                                    <x-heroicon-o-photo style="width:28px;height:28px;color:#9ca3af;" />
                                </div>
                                <p class="ml-empty-title">
                                    @if($search) No results for "{{ $search }}"
                                    @elseif($filterAlbum !== 'all') No images in this album
                                    @else No images yet
                                    @endif
                                </p>
                                <p class="ml-empty-sub">Switch to the Upload tab to add your first image</p>
                                <button type="button" wire:click="$set('activeTab','upload')" class="ml-empty-btn">
                                    <x-heroicon-m-arrow-up-tray style="width:14px;height:14px;" /> Upload image
                                </button>
                            </div>
                        @endif
                    </div>

                    {{-- Pagination --}}
                    @if($images && $images->hasPages())
                        <div class="ml-page">
                            <span class="ml-page-info">{{ $images->firstItem() }}–{{ $images->lastItem() }} of {{ $images->total() }}</span>
                            <div class="ml-page-btns">
                                <button type="button" wire:click="previousPage" class="ml-page-btn" @disabled($images->onFirstPage())>← Prev</button>
                                <span class="ml-page-num">{{ $currentPage }} / {{ $images->lastPage() }}</span>
                                <button type="button" wire:click="nextPage" class="ml-page-btn" @disabled(!$images->hasMorePages())>Next →</button>
                            </div>
                        </div>
                    @endif

                </div>

                {{-- Footer --}}
                <div class="ml-footer">
                    <span class="ml-selected-label">
                        @if($selectedTitle)
                            Selected: <span class="ml-selected-name">{{ $selectedTitle }}</span>
                        @else
                            <span style="color:#d1d5db;">No image selected</span>
                        @endif
                    </span>
                    <div class="ml-footer-btns">
                        <button type="button" wire:click="closeModal" class="ml-btn-cancel">Cancel</button>
                        <button type="button" wire:click="insertImage" class="ml-btn-insert" @disabled(!$selectedPath)>Insert image</button>
                    </div>
                </div>

            @endif

            {{-- ═══ UPLOAD TAB ════════════════════════════════════════ --}}
            @if($activeTab === 'upload')
                <div class="ml-upload-body">
                    <div class="ml-upload-inner">

                        <label class="ml-field-label">Image <span style="color:#ef4444;">*</span></label>

                        @if($newFile)
                            <div class="ml-preview-wrap" wire:loading.class="opacity-50" wire:target="newFile">
                                <img src="{{ $newFile->temporaryUrl() }}" class="ml-preview-img" alt="Preview" />
                                <div class="ml-preview-bar">
                                    <span class="ml-preview-name">{{ $newFile->getClientOriginalName() }}</span>
                                    <button type="button" wire:click="$set('newFile',null)" class="ml-remove-btn">Remove</button>
                                </div>
                            </div>
                        @else
                            <label class="ml-dropzone">
                                <div class="ml-dropzone-icon">
                                    <x-heroicon-m-arrow-up-tray style="width:22px;height:22px;" />
                                </div>
                                <p class="ml-dropzone-title">Click to browse</p>
                                <p class="ml-dropzone-sub">PNG, JPG, GIF, WEBP &middot; max 10 MB</p>
                                <input type="file" wire:model="newFile" accept="image/*" style="display:none;" />
                            </label>
                        @endif

                        @error('newFile')
                            <p class="ml-error">{{ $message }}</p>
                        @enderror

                        <div class="ml-meta-card">
                            <p class="ml-meta-label">Details (optional)</p>
                            <label class="ml-input-label">Title</label>
                            <input type="text" wire:model="newTitle" placeholder="e.g. Hero banner image" class="ml-input" />
                            <label class="ml-input-label">Alt Text</label>
                            <input type="text" wire:model="newAlt" placeholder="Describe the image for accessibility" class="ml-input" style="margin-bottom:0;" />
                        </div>

                        <button
                            type="button"
                            wire:click="submitUpload"
                            wire:loading.attr="disabled"
                            wire:target="submitUpload,newFile"
                            class="ml-submit"
                        >
                            <x-heroicon-m-arrow-up-tray style="width:16px;height:16px;" />
                            <span wire:loading.remove wire:target="submitUpload">Upload &amp; Select</span>
                            <span wire:loading wire:target="submitUpload">Uploading…</span>
                        </button>

                    </div>
                </div>
            @endif

        </div>
    </div>
    @endif
</div>
