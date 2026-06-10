<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MusicSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MusicController extends Controller
{
    /**
     * Display the music management view.
     */
    public function index()
    {
        $music = MusicSetting::firstOrCreate(['id' => 1], [
            'file_path' => null,
            'is_active' => true,
            'autoplay' => false,
        ]);

        return view('admin.music', compact('music'));
    }

    /**
     * Update the music configuration or upload a new song.
     */
    public function update(Request $request)
    {
        $music = MusicSetting::findOrFail(1);

        $request->validate([
            'music_file' => 'nullable|file|mimes:mp3|max:15360', // Max 15MB
            'is_active' => 'nullable|boolean',
            'autoplay' => 'nullable|boolean',
        ], [
            'music_file.mimes' => 'El archivo de música debe estar en formato MP3.',
            'music_file.max' => 'El archivo de música no debe superar los 15 Megabytes (15MB).',
        ]);

        $music->is_active = $request->has('is_active');
        $music->autoplay = $request->has('autoplay');

        if ($request->hasFile('music_file')) {
            // Eliminar archivo anterior si existe
            if ($music->file_path) {
                Storage::disk('public')->delete($music->file_path);
            }

            // Guardar el nuevo MP3 en storage/app/public/music
            $filePath = $request->file('music_file')->store('music', 'public');
            $music->file_path = $filePath;
        }

        $music->save();

        return redirect()->route('admin.music')->with('success', 'Configuración de música actualizada correctamente.');
    }

    /**
     * Delete the uploaded music file.
     */
    public function destroy()
    {
        $music = MusicSetting::findOrFail(1);

        if ($music->file_path) {
            Storage::disk('public')->delete($music->file_path);
            $music->file_path = null;
            $music->save();
        }

        return redirect()->route('admin.music')->with('success', 'Archivo de música eliminado con éxito.');
    }
}
