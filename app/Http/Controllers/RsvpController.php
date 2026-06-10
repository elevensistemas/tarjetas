<?php

namespace App\Http\Controllers;

use App\Http\Requests\RsvpRequest;
use App\Models\Guest;
use Illuminate\Http\JsonResponse;

class RsvpController extends Controller
{
    /**
     * Store a newly created guest RSVP confirmation.
     */
    public function store(RsvpRequest $request): JsonResponse
    {
        try {
            $guest = Guest::create($request->validated());

            return response()->json([
                'success' => true,
                'message' => '¡Asistencia confirmada con éxito!',
                'guest' => $guest
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al procesar tu confirmación. Inténtalo nuevamente.'
            ], 500);
        }
    }
}
