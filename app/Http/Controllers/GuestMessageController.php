<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuestMessageRequest;
use App\Models\GuestMessage;
use Illuminate\Http\JsonResponse;

class GuestMessageController extends Controller
{
    /**
     * Store a guest message in the guestbook (libro de firmas).
     */
    public function store(GuestMessageRequest $request): JsonResponse
    {
        try {
            $message = GuestMessage::create([
                'guest_name' => strip_tags($request->input('guest_name')),
                'message' => strip_tags($request->input('message')),
                'status' => 'pending' // Requiere aprobación admin
            ]);

            return response()->json([
                'success' => true,
                'message' => '¡Dedicatoria enviada con éxito! Aparecerá en el muro una vez aprobada.',
                'message_data' => $message
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al enviar tu dedicatoria. Inténtalo nuevamente.'
            ], 500);
        }
    }
}
