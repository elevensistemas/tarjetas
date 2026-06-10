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
            $code = $request->input('code');
            if ($code) {
                $guest = Guest::where('code', $code)->first();
                if ($guest) {
                    $guest->update([
                        'phone' => $request->input('phone'),
                        'assistants_count' => $request->input('is_attending') ? $request->input('assistants_count') : 0,
                        'is_attending' => $request->input('is_attending'),
                        'dietary_restrictions' => $request->input('dietary_restrictions'),
                        'comments' => $request->input('comments'),
                        'is_confirmed' => true,
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => '¡Asistencia confirmada con éxito!',
                        'guest' => $guest
                    ], 200);
                }
            }

            $validatedData = $request->validated();
            $validatedData['is_confirmed'] = true;
            $guest = Guest::create($validatedData);

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
