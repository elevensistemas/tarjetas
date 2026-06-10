<?php

namespace App\Http\Controllers;

use App\Models\EventSetting;
use App\Models\MusicSetting;
use App\Models\GalleryPhoto;
use App\Models\GuestMessage;
use App\Models\UploadedPhoto;
use Illuminate\Http\Request;

class PublicInvitationController extends Controller
{
    /**
     * Display the elegant public digital invitation.
     */
    public function index()
    {
        // Obtener configuración del evento (Singleton / ID 1)
        $event = EventSetting::firstOrCreate(
            ['id' => 1],
            [
                'quinceanera_name' => 'Bianca',
                'event_date' => now()->addMonths(6),
                'event_place' => 'Salón Premium Palace',
                'event_address' => 'Av. del Libertador 4500, Palermo, CABA',
                'google_maps_url' => 'https://www.google.com/maps/embed',
                'google_maps_share_url' => 'https://maps.google.com',
                'dress_code' => 'Formal Elegante',
                'hero_text' => 'Mis 15 Años',
                'hero_subtext' => 'BIANCA',
            ]
        );

        // Obtener música de fondo
        $music = MusicSetting::firstOrCreate(['id' => 1]);

        // Obtener fotos oficiales ordenadas
        $galleryPhotos = GalleryPhoto::orderBy('order', 'asc')->get();

        // Obtener mensajes del libro de firmas aprobados
        $approvedMessages = GuestMessage::where('status', 'approved')
            ->latest()
            ->get();

        // Obtener fotos subidas por invitados aprobadas
        $approvedPhotos = UploadedPhoto::where('status', 'approved')
            ->latest()
            ->get();

        return view('public.invitation', compact(
            'event',
            'music',
            'galleryPhotos',
            'approvedMessages',
            'approvedPhotos'
        ));
    }
}
