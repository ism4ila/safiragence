<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $images = GalleryImage::orderBy('sort_order', 'asc')
                              ->orderBy('created_at', 'desc')
                              ->get();
        return view('admin.gallery.index', compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'images' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'is_featured' => 'boolean',
        ]);

        $uploadedCount = 0;
        
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('gallery', 'public');
                
                GalleryImage::create([
                    'title' => $request->title . ($index > 0 ? ' (' . ($index + 1) . ')' : ''),
                    'description' => $request->description,
                    'image_path' => $path,
                    'category' => $request->category,
                    'is_featured' => $request->boolean('is_featured') && $index === 0,
                    'sort_order' => GalleryImage::max('sort_order') + 1,
                    'created_by' => auth()->id(),
                ]);
                
                $uploadedCount++;
            }
        }

        return redirect()->route('admin.gallery.index')
                        ->with('success', $uploadedCount . ' image(s) ajoutée(s) avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(GalleryImage $galleryImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GalleryImage $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GalleryImage $gallery)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'required|string|in:general,services,equipe,evenements,projets,formations',
            'is_featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'is_featured' => $request->boolean('is_featured'),
            'sort_order' => $request->sort_order ?? $gallery->sort_order,
        ];

        if ($request->hasFile('image')) {
            try {
                // Supprimer l'ancienne image
                if ($gallery->image_path && Storage::disk('public')->exists($gallery->image_path)) {
                    Storage::disk('public')->delete($gallery->image_path);
                }
                
                $data['image_path'] = $request->file('image')->store('gallery', 'public');
            } catch (\Exception $e) {
                return back()->withErrors(['image' => 'Erreur lors du téléchargement de l\'image.'])
                            ->withInput();
            }
        }

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')
                        ->with('success', 'Image mise à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GalleryImage $gallery)
    {
        // Supprimer le fichier image
        if ($gallery->image_path && Storage::disk('public')->exists($gallery->image_path)) {
            Storage::disk('public')->delete($gallery->image_path);
        }
        
        $gallery->delete();
        
        return redirect()->route('admin.gallery.index')
                        ->with('success', 'Image supprimée avec succès !');
    }
}
