<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\GuestMessage;
use App\Models\UploadedPhoto;

class DashboardController extends Controller
{
    /**
     * Display the admin panel dashboard.
     */
    public function index()
    {
        // Contar asistencias y totales
        $confirmedGuestsQuery = Guest::where('is_attending', true);
        $confirmedCount = $confirmedGuestsQuery->count();
        $totalAssistants = $confirmedGuestsQuery->sum('assistants_count');
        
        $notAttendingCount = Guest::where('is_attending', false)->count();

        // Contar cargas pendientes de moderación
        $pendingPhotosCount = UploadedPhoto::where('status', 'pending')->count();
        $pendingMessagesCount = GuestMessage::where('status', 'pending')->count();

        // Obtener confirmaciones recientes
        $recentRsvps = Guest::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'confirmedCount',
            'totalAssistants',
            'notAttendingCount',
            'pendingPhotosCount',
            'pendingMessagesCount',
            'recentRsvps'
        ));
    }
}
