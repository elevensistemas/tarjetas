<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RsvpController extends Controller
{
    /**
     * Display a listing of RSVP guests.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $attendance = $request->input('attendance');

        $query = Guest::query()->where(function($q) {
            $q->where('is_confirmed', true)
              ->orWhereNotNull('phone');
        });

        // Aplicar búsqueda por nombre o teléfono
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Aplicar filtro por estado de asistencia
        if ($attendance !== null && $attendance !== '') {
            $query->where('is_attending', $attendance);
        }

        $guests = $query->latest()->paginate(15)->withQueryString();

        // Obtener listado de invitaciones generadas (pendientes o confirmadas con link)
        $invitations = Guest::whereNotNull('code')->orderBy('name', 'asc')->get();

        // Obtener configuración del evento
        $event = \App\Models\EventSetting::first();

        // Totales rápidos para la cabecera (basado en confirmados)
        $totals = [
            'total_registered' => Guest::where(function($q) {
                $q->where('is_confirmed', true)->orWhereNotNull('phone');
            })->count(),
            'attending' => Guest::where('is_attending', true)->where(function($q) {
                $q->where('is_confirmed', true)->orWhereNotNull('phone');
            })->count(),
            'total_people' => Guest::where('is_attending', true)->where(function($q) {
                $q->where('is_confirmed', true)->orWhereNotNull('phone');
            })->sum('assistants_count'),
            'not_attending' => Guest::where('is_attending', false)->where(function($q) {
                $q->where('is_confirmed', true)->orWhereNotNull('phone');
            })->count(),
        ];

        return view('admin.rsvp', compact('guests', 'invitations', 'event', 'totals', 'search', 'attendance'));
    }

    /**
     * Store a new pre-invited guest (generate code and link).
     */
    public function storeInvite(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'max_passes' => 'required|integer|min:1|max:20',
        ]);

        // Generar código único legible
        $slug = \Illuminate\Support\Str::slug($validated['name']);
        if (empty($slug)) {
            $slug = 'invitado';
        }
        
        $code = $slug;
        $counter = 1;
        while (Guest::where('code', $code)->exists()) {
            $code = $slug . '-' . $counter;
            $counter++;
        }

        Guest::create([
            'name' => $validated['name'],
            'max_passes' => $validated['max_passes'],
            'code' => $code,
            'is_confirmed' => false,
            'is_attending' => false,
            'assistants_count' => 1,
        ]);

        return redirect()->route('admin.rsvp')->with('success', 'Invitación y enlace creados correctamente.');
    }

    /**
     * Update the specified guest registration.
     */
    public function update(Request $request, $id)
    {
        $guest = Guest::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50|unique:guests,phone,' . $guest->id,
            'assistants_count' => 'required|integer|min:0|max:20',
            'is_attending' => 'required|boolean',
            'dietary_restrictions' => 'nullable|string|max:1000',
            'comments' => 'nullable|string|max:1000',
        ]);

        $guest->update($validated);

        return redirect()->route('admin.rsvp')->with('success', 'Registro de invitado actualizado correctamente.');
    }

    /**
     * Remove the specified guest registration.
     */
    public function destroy($id)
    {
        $guest = Guest::findOrFail($id);
        $guest->delete();

        return redirect()->route('admin.rsvp')->with('success', 'Invitado eliminado con éxito.');
    }

    /**
     * Export the RSVP list as a premium Excel-compatible CSV.
     */
    public function exportCsv()
    {
        $headers = [
            'Content-type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename=invitados_rsvp_bianca15.csv',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $guests = Guest::orderBy('name', 'asc')->get();

        $callback = function() use ($guests) {
            $file = fopen('php://output', 'w');
            
            // Añadir el BOM de UTF-8 para compatibilidad absoluta con MS Excel en español
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Cabeceras de columnas del CSV
            fputcsv($file, [
                'Nombre y Apellido',
                'Teléfono',
                'Cantidad de Asistentes',
                '¿Confirma Asistencia?',
                'Restricciones Alimenticias',
                'Comentarios',
                'Fecha de Registro'
            ], ';');

            foreach ($guests as $guest) {
                fputcsv($file, [
                    $guest->name,
                    $guest->phone,
                    $guest->is_attending ? $guest->assistants_count : 0,
                    $guest->is_attending ? 'SÍ' : 'NO',
                    $guest->dietary_restrictions ?? 'Ninguna',
                    $guest->comments ?? 'Sin comentarios',
                    $guest->created_at->format('d/m/Y H:i')
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
