<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EventSetting;
use App\Models\MusicSetting;
use App\Models\GalleryPhoto;

class EventSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear o actualizar configuración de evento única
        EventSetting::updateOrCreate(
            ['id' => 1],
            [
                'quinceanera_name' => 'Bianca',
                'event_date' => '2026-11-20 21:00:00',
                'event_place' => 'Salón Premium Palace',
                'event_address' => 'Av. del Libertador 4500, Palermo, CABA',
                'google_maps_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3285.3400588661623!2d-58.423985523412574!3d-34.56903735572979!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95bcb59fe57f0037%3A0xe4a13e5d321598f8!2sAv.%20del%20Libertador%204500%2C%20Buenos%20Aires!5e0!3m2!1ses-419!2sar!4v1700000000000!5m2!1ses-419!2sar',
                'google_maps_share_url' => 'https://maps.app.goo.gl/uX7G1y3KxT7z5FfW7',
                'dress_code' => 'Formal Elegante',
                'dress_code_description' => 'Los invitamos a vestir sus mejores trajes y vestidos de gala para compartir esta noche mágica e inolvidable.',
                'hero_text' => 'Mis 15 Años',
                'hero_subtext' => 'BIANCA',
                'quinceanera_message' => 'Hay momentos en la vida que son especiales, pero compartirlos con las personas que más quiero los hace inolvidables. Te espero para celebrar juntos mi gran noche.',
                
                // Diseño premium JSON
                'design_settings' => [
                    'color_primary' => '#F4C2C2',     // Rosa Pastel
                    'color_secondary' => '#D4AF37',   // Dorado Suave
                    'color_bg' => '#FAF7F2',          // Crema Cálido
                    'color_dark' => '#3D3D3D',        // Gris Carbón Elegante
                    'typography_title' => 'Playfair Display',
                    'typography_body' => 'Montserrat',
                    'animations_enabled' => true,
                    'hero_image' => 'placeholder_hero.jpg',
                    'monogram' => 'placeholder_monogram.png',
                ],
                
                // Imágenes iniciales null/placeholder
                'hero_image_path' => null,
                'monogram_path' => null,

                // Configuración WhatsApp
                'whatsapp_phone' => '5491122334455',
                'whatsapp_message' => 'Hola, tengo una consulta sobre la fiesta de 15 de Bianca',
                'whatsapp_enabled' => true,

                // Configuración Regalos
                'gifts_alias' => 'bianca.mis15.mp',
                'gifts_cbu' => '0000003100012345678901',
                'gifts_text' => 'Tu presencia es mi mejor regalo. Pero si deseas hacerme un presente, puedes colaborar con mi viaje de quinceañera mediante transferencia bancaria o Mercado Pago.',
                'gifts_qr_path' => null,
                'gifts_enabled' => true,
            ]
        );

        // 2. Crear configuración de música inicial
        MusicSetting::updateOrCreate(
            ['id' => 1],
            [
                'file_path' => null,
                'is_active' => true,
                'autoplay' => false,
            ]
        );
    }
}
