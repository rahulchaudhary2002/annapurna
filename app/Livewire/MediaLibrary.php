<?php

namespace App\Livewire;

use App\Models\GalleryAlbum;
use App\Models\GalleryImage;
use Livewire\Component;
use Livewire\WithFileUploads;

class MediaLibrary extends Component
{
    use WithFileUploads;

    public string $statePath;
    public bool $showModal = false;
    public string $activeTab = 'library';
    public string $search = '';
    public int $currentPage = 1;
    public string $filterAlbum = 'all';
    public string $sortBy = 'newest';

    public ?string $selectedPath = null;
    public ?string $selectedTitle = null;

    public $newFile = null;
    public string $newTitle = '';
    public string $newAlt = '';

    public function mount(string $statePath): void
    {
        $this->statePath = $statePath;
    }

    public function openModal(): void
    {
        $this->showModal = true;
        $this->activeTab = 'library';
        $this->currentPage = 1;
        $this->selectedPath = null;
        $this->selectedTitle = null;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['newFile', 'newTitle', 'newAlt', 'search', 'selectedPath', 'selectedTitle']);
        $this->currentPage = 1;
        $this->filterAlbum = 'all';
    }

    public function updatedSearch(): void
    {
        $this->currentPage = 1;
    }

    public function updatedFilterAlbum(): void
    {
        $this->currentPage = 1;
    }

    public function nextPage(): void
    {
        $this->currentPage++;
    }

    public function previousPage(): void
    {
        if ($this->currentPage > 1) {
            $this->currentPage--;
        }
    }

    public function pickImage(string $path, ?string $title): void
    {
        $this->selectedPath = $this->selectedPath === $path ? null : $path;
        $this->selectedTitle = $this->selectedPath ? $title : null;
    }

    public function insertImage(): void
    {
        if ($this->selectedPath) {
            $this->dispatch('image-selected', statePath: $this->statePath, path: $this->selectedPath);
            $this->closeModal();
        }
    }

    public function submitUpload(): void
    {
        $this->validate([
            'newFile' => ['required', 'file', 'max:20480', 'mimes:jpg,jpeg,png,gif,webp,svg'],
        ]);

        // Capture original name BEFORE store() moves the temp file
        $originalName = pathinfo($this->newFile->getClientOriginalName(), PATHINFO_FILENAME);

        try {
            $path = $this->newFile->store('gallery/images', 'public');

            GalleryImage::create([
                'image'     => $path,
                'title'     => $this->newTitle ?: $originalName,
                'alt_text'  => $this->newAlt,
                'type'      => 'image',
                'order'     => 0,
                'is_active' => true,
            ]);

            $this->dispatch('image-selected', statePath: $this->statePath, path: $path);
            $this->closeModal();
        } catch (\Throwable $e) {
            $this->addError('newFile', 'Upload failed: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $images = null;
        $albums = collect();
        $totalCount = 0;

        if ($this->showModal && $this->activeTab === 'library') {
            $query = GalleryImage::query()
                ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%")
                    ->orWhere('alt_text', 'like', "%{$this->search}%"))
                ->when($this->filterAlbum !== 'all', fn($q) => $q->where('album_id', $this->filterAlbum))
                ->when($this->sortBy === 'newest', fn($q) => $q->latest())
                ->when($this->sortBy === 'oldest', fn($q) => $q->oldest('created_at'));

            $totalCount = GalleryImage::count();
            $images = $query->paginate(20, ['*'], 'page', $this->currentPage);
            $albums = GalleryAlbum::withCount('images')
                ->having('images_count', '>', 0)
                ->orderBy('name')
                ->get();
        }

        return view('livewire.media-library', compact('images', 'albums', 'totalCount'));
    }
}
