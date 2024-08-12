<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function create()
    {
        return view('canvolt-form.gallery-canvolt');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'photos.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        try {
            $gallery = new Gallery();
            $gallery->title = $request->title;

            if ($request->hasFile('photos')) {
                $photos = [];
                foreach ($request->file('photos') as $photo) {
                    $path = $photo->store('gallery_photos', 'public');
                    $photos[] = $path;
                }
                $gallery->photos = json_encode($photos);
            }

            $gallery->save();

            return redirect()->route('gallery.create')->with('success', 'Imágenes añadidas a la galería');
        } catch (\Exception $e) {
            return redirect()->route('gallery.create')->with('error', 'Hubo un problema al añadir las imágenes: ' . $e->getMessage());
        }
    }
}
