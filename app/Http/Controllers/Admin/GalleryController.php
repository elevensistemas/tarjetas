<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of official gallery photos.
     */
    public function index()
    {
        $photos = GalleryPhoto::orderBy('order', 'asc')->get();
        return view('admin.gallery', compact('photos'));
    }

    /**
     * Store new official photos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'photos' => 'required|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,webp|max:8192', // Max 8MB por foto
        ], [
            'photos.required' => 'Debes seleccionar al menos una foto para subir.',
            'photos.*.image' => 'El archivo debe ser una imagen válida.',
            'photos.*.mimes' => 'Solo se permiten imágenes JPG, JPEG, PNG o WEBP.',
            'photos.*.max' => 'Ninguna foto debe superar los 8 Megabytes (8MB).',
        ]);

        if ($request->hasFile('photos')) {
            $lastOrder = GalleryPhoto::max('order') ?? 0;

            foreach ($request->file('photos') as $file) {
                $lastOrder++;
                $filePath = $file->store('gallery', 'public');

                GalleryPhoto::create([
                    'file_path' => $filePath,
                    'order' => $lastOrder,
                    'is_featured' => false
                ]);
            }
        }

        return redirect()->route('admin.gallery')->with('success', 'Fotos cargadas a la galería correctamente.');
    }

    /**
     * Update photo order.
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*' => 'integer',
        ]);

        foreach ($request->input('orders') as $id => $order) {
            $photo = GalleryPhoto::find($id);
            if ($photo) {
                $photo->update(['order' => $order]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Orden de la galería actualizado.']);
    }

    /**
     * Set a photo as featured.
     */
    public function highlight($id)
    {
        $photo = GalleryPhoto::findOrFail($id);

        // Desactivar destacado de todas las demás fotos
        GalleryPhoto::where('id', '!=', $id)->update(['is_featured' => false]);

        // Alternar el destacado de esta foto
        $photo->update(['is_featured' => !$photo->is_featured]);

        return redirect()->route('admin.gallery')->with('success', 'Imagen destacada actualizada.');
    }

    /**
     * Delete an official gallery photo.
     */
    public function destroy($id)
    {
        $photo = GalleryPhoto::findOrFail($id);

        // Eliminar del almacenamiento físico
        if ($photo->file_path) {
            Storage::disk('public')->delete($photo->file_path);
        }

        $photo->delete();

        return redirect()->route('admin.gallery')->with('success', 'Foto eliminada de la galería.');
    }
}
