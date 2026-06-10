<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuestPhotoRequest;
use App\Models\UploadedPhoto;
use Illuminate\Http\JsonResponse;

class GuestPhotoController extends Controller
{
    /**
     * Store a guest uploaded photo.
     */
    public function store(GuestPhotoRequest $request): JsonResponse
    {
        try {
            if ($request->hasFile('photo')) {
                // Guardar la foto en storage/app/public/guest_uploads
                $filePath = $request->file('photo')->store('guest_uploads', 'public');

                $photo = UploadedPhoto::create([
                    'guest_name' => strip_tags($request->input('guest_name')),
                    'file_path' => $filePath,
                    'comment' => strip_tags($request->input('comment')),
                    'status' => 'pending' // Requiere aprobación admin
                ]);

                return response()->json([
                    'success' => true,
                    'message' => '¡Foto subida con éxito! Estará visible cuando el administrador la apruebe.',
                    'photo' => $photo
                ], 201);
            }

            return response()->json([
                'success' => false,
                'message' => 'No se detectó ningún archivo de imagen.'
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al subir la foto: ' . $e->getMessage()
            ], 500);
        }
    }
}
