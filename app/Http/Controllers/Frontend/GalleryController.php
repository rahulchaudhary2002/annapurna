<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use App\Models\GalleryImage;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        $albums = GalleryAlbum::active()->withCount('activeImages')->get();
        $allImages = GalleryImage::active()->with('album')->paginate(24);

        return view('frontend.gallery.index', compact('albums', 'allImages'));
    }

    public function album(string $slug): View
    {
        $album = GalleryAlbum::where('slug', $slug)->where('is_active', true)
            ->with('activeImages')
            ->firstOrFail();

        $otherAlbums = GalleryAlbum::active()
            ->where('id', '!=', $album->id)
            ->withCount('activeImages')
            ->get();

        return view('frontend.gallery.album', compact('album', 'otherAlbums'));
    }
}
