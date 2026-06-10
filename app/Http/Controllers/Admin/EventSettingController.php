<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventSettingController extends Controller
{
    /**
     * Show the event and design settings form.
     */
    public function index()
    {
        $event = EventSetting::firstOrCreate(['id' => 1], [
            'quinceanera_name' => 'Bianca',
            'event_date' => now()->addMonths(6),
            'event_place' => 'Salón Premium Palace',
            'event_address' => 'Av. del Libertador 4500, Palermo, CABA',
            'google_maps_url' => 'https://www.google.com/maps/embed',
            'google_maps_share_url' => 'https://maps.google.com',
            'dress_code' => 'Formal Elegante',
            'hero_text' => 'Mis 15 Años',
            'hero_subtext' => 'BIANCA',
            'design_settings' => [
                'theme' => 'cyber',
                'color_primary' => '#FF00FF',
                'color_secondary' => '#39FF14',
                'color_bg' => '#08080C',
                'color_dark' => '#F5F5FA',
                'typography_title' => 'Outfit',
                'typography_body' => 'Inter',
                'animations_enabled' => true,
            ]
        ]);

        return view('admin.settings', compact('event'));
    }

    /**
     * Update the event settings.
     */
    public function update(Request $request)
    {
        $event = EventSetting::findOrFail(1);

        $validated = $request->validate([
            'quinceanera_name' => 'required|string|max:255',
            'event_date' => 'required|date',
            'event_place' => 'required|string|max:255',
            'event_address' => 'required|string|max:255',
            'google_maps_url' => 'required|string',
            'google_maps_share_url' => 'required|url',
            'dress_code' => 'required|string|max:255',
            'dress_code_description' => 'nullable|string',
            'hero_text' => 'required|string|max:255',
            'hero_subtext' => 'required|string|max:255',
            'quinceanera_message' => 'nullable|string',
            
            // Colores y Diseño
            'theme' => 'required|string|in:cyber,coquette,vip',
            'color_primary' => 'required|string|max:7',
            'color_secondary' => 'required|string|max:7',
            'color_bg' => 'required|string|max:7',
            'color_dark' => 'required|string|max:7',
            'typography_title' => 'required|string|max:255',
            'typography_body' => 'required|string|max:255',
            'animations_enabled' => 'nullable|boolean',
            
            // Archivos opcionales
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'monogram' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',

            // WhatsApp
            'whatsapp_phone' => 'nullable|string|max:50',
            'whatsapp_message' => 'nullable|string|max:1000',
            'whatsapp_enabled' => 'nullable|boolean',

            // Regalos
            'gifts_alias' => 'nullable|string|max:255',
            'gifts_cbu' => 'nullable|string|max:255',
            'gifts_text' => 'nullable|string|max:1000',
            'gifts_qr' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gifts_enabled' => 'nullable|boolean',
        ]);

        // Procesar diseño JSON anterior y unir nuevos valores
        $designSettings = $event->design_settings ?? [];
        $designSettings['theme'] = $validated['theme'];
        $designSettings['color_primary'] = $validated['color_primary'];
        $designSettings['color_secondary'] = $validated['color_secondary'];
        $designSettings['color_bg'] = $validated['color_bg'];
        $designSettings['color_dark'] = $validated['color_dark'];
        $designSettings['typography_title'] = $validated['typography_title'];
        $designSettings['typography_body'] = $validated['typography_body'];
        $designSettings['animations_enabled'] = $request->has('animations_enabled');

        $event->fill([
            'quinceanera_name' => $validated['quinceanera_name'],
            'event_date' => $validated['event_date'],
            'event_place' => $validated['event_place'],
            'event_address' => $validated['event_address'],
            'google_maps_url' => $validated['google_maps_url'],
            'google_maps_share_url' => $validated['google_maps_share_url'],
            'dress_code' => $validated['dress_code'],
            'dress_code_description' => $validated['dress_code_description'],
            'hero_text' => $validated['hero_text'],
            'hero_subtext' => $validated['hero_subtext'],
            'quinceanera_message' => $validated['quinceanera_message'],
            'design_settings' => $designSettings,
            
            'whatsapp_phone' => $validated['whatsapp_phone'],
            'whatsapp_message' => $validated['whatsapp_message'],
            'whatsapp_enabled' => $request->has('whatsapp_enabled'),
            
            'gifts_alias' => $validated['gifts_alias'],
            'gifts_cbu' => $validated['gifts_cbu'],
            'gifts_text' => $validated['gifts_text'],
            'gifts_enabled' => $request->has('gifts_enabled'),
        ]);

        // Manejar subida de imagen Hero
        if ($request->hasFile('hero_image')) {
            if ($event->hero_image_path) {
                Storage::disk('public')->delete($event->hero_image_path);
            }
            $event->hero_image_path = $request->file('hero_image')->store('design', 'public');
        }

        // Manejar subida de Monograma/Logotipo
        if ($request->hasFile('monogram')) {
            if ($event->monogram_path) {
                Storage::disk('public')->delete($event->monogram_path);
            }
            $event->monogram_path = $request->file('monogram')->store('design', 'public');
        }

        // Manejar subida de código QR de Regalos
        if ($request->hasFile('gifts_qr')) {
            if ($event->gifts_qr_path) {
                Storage::disk('public')->delete($event->gifts_qr_path);
            }
            $event->gifts_qr_path = $request->file('gifts_qr')->store('design', 'public');
        }

        $event->save();

        return redirect()->route('admin.settings')->with('success', 'Configuración actualizada correctamente.');
    }
}
