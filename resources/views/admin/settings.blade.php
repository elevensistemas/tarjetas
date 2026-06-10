@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    
    <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
        <div>
            <h1 class="h3 mb-1 text-gray-800 title-font">Ajustes del Evento y Diseño</h1>
            <p class="text-muted small mb-0">Personaliza la invitación digital al instante sin tocar código.</p>
        </div>
    </div>

    <div class="admin-card p-0 overflow-hidden shadow-sm" style="border-radius: 15px;">
        
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- NAVEGACIÓN POR PESTAÑAS (TABS) -->
            <ul class="nav nav-tabs settings-tabs bg-light px-3 pt-2" id="settingsTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="event-tab" data-bs-toggle="tab" data-bs-target="#event" type="button" role="tab" aria-controls="event" aria-selected="true">
                        <i class="bi bi-info-circle me-1"></i> Información General
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="design-tab" data-bs-toggle="tab" data-bs-target="#design" type="button" role="tab" aria-controls="design" aria-selected="false">
                        <i class="bi bi-palette me-1"></i> Diseño y Estilos
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="whatsapp-tab" data-bs-toggle="tab" data-bs-target="#whatsapp" type="button" role="tab" aria-controls="whatsapp" aria-selected="false">
                        <i class="bi bi-whatsapp me-1"></i> Botón WhatsApp
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="gifts-tab" data-bs-toggle="tab" data-bs-target="#gifts" type="button" role="tab" aria-controls="gifts" aria-selected="false">
                        <i class="bi bi-gift me-1"></i> Regalos / Alias
                    </button>
                </li>
            </ul>

            <!-- CONTENIDO DE LAS PESTAÑAS -->
            <div class="tab-content p-4 p-md-5" id="settingsTabsContent">
                
                <!-- PESTAÑA 1: INFORMACIÓN GENERAL -->
                <div class="tab-pane fade show active" id="event" role="tabpanel" aria-labelledby="event-tab">
                    <h4 class="mb-4 text-secondary pb-2 border-bottom border-light">Datos del Cumpleaños</h4>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="quinceanera_name" class="form-label fw-semibold">Nombre de la Quinceañera</label>
                            <input type="text" class="form-control" id="quinceanera_name" name="quinceanera_name" value="{{ old('quinceanera_name', $event->quinceanera_name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="event_date" class="form-label fw-semibold">Fecha y Hora de la Fiesta</label>
                            <input type="datetime-local" class="form-control" id="event_date" name="event_date" value="{{ old('event_date', $event->event_date->format('Y-m-d\TH:i')) }}" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="event_place" class="form-label fw-semibold">Nombre del Salón / Lugar</label>
                            <input type="text" class="form-control" id="event_place" name="event_place" value="{{ old('event_place', $event->event_place) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="event_address" class="form-label fw-semibold">Dirección del Salón</label>
                            <input type="text" class="form-control" id="event_address" name="event_address" value="{{ old('event_address', $event->event_address) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="dress_code" class="form-label fw-semibold">Dress Code (Etiqueta)</label>
                            <input type="text" class="form-control" id="dress_code" name="dress_code" value="{{ old('dress_code', $event->dress_code) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="dress_code_description" class="form-label fw-semibold">Descripción del Vestuario</label>
                            <input type="text" class="form-control" id="dress_code_description" name="dress_code_description" value="{{ old('dress_code_description', $event->dress_code_description) }}">
                        </div>

                        <div class="col-md-6">
                            <label for="hero_text" class="form-label fw-semibold">Título de Portada</label>
                            <input type="text" class="form-control" id="hero_text" name="hero_text" value="{{ old('hero_text', $event->hero_text) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="hero_subtext" class="form-label fw-semibold">Subtítulo de Portada</label>
                            <input type="text" class="form-control" id="hero_subtext" name="hero_subtext" value="{{ old('hero_subtext', $event->hero_subtext) }}" required>
                        </div>

                        <div class="col-12">
                            <label for="quinceanera_message" class="form-label fw-semibold">Mensaje Emotivo o Frase Principal</label>
                            <textarea class="form-control" id="quinceanera_message" name="quinceanera_message" rows="3">{{ old('quinceanera_message', $event->quinceanera_message) }}</textarea>
                        </div>

                        <div class="col-12">
                            <label for="google_maps_url" class="form-label fw-semibold">URL de Mapa de Google Embebido (Iframe `src` attribute only)</label>
                            <textarea class="form-control" id="google_maps_url" name="google_maps_url" rows="3" required>{{ old('google_maps_url', $event->google_maps_url) }}</textarea>
                            <div class="form-text small">Pega el link que figura dentro del atributo `src="..."` al pulsar "Compartir -> Insertar un mapa" en Google Maps.</div>
                        </div>

                        <div class="col-12">
                            <label for="google_maps_share_url" class="form-label fw-semibold">Link de Google Maps Compartir ("Cómo llegar")</label>
                            <input type="url" class="form-control" id="google_maps_share_url" name="google_maps_share_url" value="{{ old('google_maps_share_url', $event->google_maps_share_url) }}" required>
                            <div class="form-text small">Link directo de compartir de Google Maps. Ejemplo: `https://maps.app.goo.gl/...`</div>
                        </div>
                    </div>
                </div>

                <!-- PESTAÑA 2: DISEÑO Y ESTILOS -->
                <div class="tab-pane fade" id="design" role="tabpanel" aria-labelledby="design-tab">
                    <h4 class="mb-4 text-secondary pb-2 border-bottom border-light">Configuración Estética y Visual</h4>
                    
                    @php
                        $ds = $event->design_settings;
                    @endphp

                    <div class="row g-3">
                        <!-- Selector de Tema -->
                        <div class="col-12 mb-3">
                            <label for="theme" class="form-label fw-bold text-primary">Estilo de Diseño (Tema)</label>
                            <select class="form-select border border-primary-subtle" id="theme" name="theme" style="border-radius: 8px; padding: 10px 15px;">
                                <option value="cyber" {{ (old('theme', $ds['theme'] ?? 'cyber') == 'cyber') ? 'selected' : '' }}>Cyber Y2K (Urbano, Neón y Retro-Dispositivos)</option>
                                <option value="coquette" {{ (old('theme', $ds['theme'] ?? '') == 'coquette') ? 'selected' : '' }}>Romantic Coquette (Delicado, Floral y Pastel)</option>
                                <option value="vip" {{ (old('theme', $ds['theme'] ?? '') == 'vip') ? 'selected' : '' }}>VIP Night Glam (Gala de Lujo, Oro y Negro)</option>
                            </select>
                            <div class="form-text small">Al seleccionar un estilo, los campos de color y tipografía de abajo se actualizarán automáticamente con la configuración recomendada. ¡Aún puedes personalizarlos libremente!</div>
                        </div>

                        <!-- Color Pickers -->
                        <div class="col-md-3">
                            <label for="color_primary" class="form-label fw-semibold">Color Principal (Acentos Rosa)</label>
                            <input type="color" class="form-control form-control-color w-100" style="height: 48px;" id="color_primary" name="color_primary" value="{{ old('color_primary', $ds['color_primary'] ?? '#F4C2C2') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="color_secondary" class="form-label fw-semibold">Color Secundario (Oro/Detalles)</label>
                            <input type="color" class="form-control form-control-color w-100" style="height: 48px;" id="color_secondary" name="color_secondary" value="{{ old('color_secondary', $ds['color_secondary'] ?? '#D4AF37') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="color_bg" class="form-label fw-semibold">Fondo General</label>
                            <input type="color" class="form-control form-control-color w-100" style="height: 48px;" id="color_bg" name="color_bg" value="{{ old('color_bg', $ds['color_bg'] ?? '#FAF7F2') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="color_dark" class="form-label fw-semibold">Color de Texto Principal</label>
                            <input type="color" class="form-control form-control-color w-100" style="height: 48px;" id="color_dark" name="color_dark" value="{{ old('color_dark', $ds['color_dark'] ?? '#3D3D3D') }}">
                        </div>

                        <!-- Fuentes Tipográficas -->
                        <div class="col-md-6 mt-4">
                            <label for="typography_title" class="form-label fw-semibold">Tipografía de Títulos</label>
                            <select class="form-select" id="typography_title" name="typography_title">
                                <option value="Bungee" {{ (old('typography_title', $ds['typography_title'] ?? '') == 'Bungee') ? 'selected' : '' }}>Bungee (Cyber Bold)</option>
                                <option value="Great Vibes" {{ (old('typography_title', $ds['typography_title'] ?? '') == 'Great Vibes') ? 'selected' : '' }}>Great Vibes (Caligráfica Muy Elegante)</option>
                                <option value="Cinzel" {{ (old('typography_title', $ds['typography_title'] ?? '') == 'Cinzel') ? 'selected' : '' }}>Cinzel (Lujosa y Romana)</option>
                                <option value="Playfair Display" {{ (old('typography_title', $ds['typography_title'] ?? '') == 'Playfair Display') ? 'selected' : '' }}>Playfair Display (Elegante Clásica)</option>
                                <option value="Outfit" {{ (old('typography_title', $ds['typography_title'] ?? '') == 'Outfit') ? 'selected' : '' }}>Outfit (Moderna Sans-Serif)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mt-4">
                            <label for="typography_body" class="form-label fw-semibold">Tipografía de Cuerpo</label>
                            <select class="form-select" id="typography_body" name="typography_body">
                                <option value="Space Mono" {{ (old('typography_body', $ds['typography_body'] ?? '') == 'Space Mono') ? 'selected' : '' }}>Space Mono (Digital Y2K Monospaced)</option>
                                <option value="Montserrat" {{ (old('typography_body', $ds['typography_body'] ?? '') == 'Montserrat') ? 'selected' : '' }}>Montserrat (Clara y Premium)</option>
                                <option value="Inter" {{ (old('typography_body', $ds['typography_body'] ?? '') == 'Inter') ? 'selected' : '' }}>Inter (Limpia y Minimalista)</option>
                                <option value="Roboto" {{ (old('typography_body', $ds['typography_body'] ?? '') == 'Roboto') ? 'selected' : '' }}>Roboto (Clásica y Legible)</option>
                            </select>
                        </div>

                        <!-- Interruptor Animaciones -->
                        <div class="col-12 my-3">
                            <div class="form-check form-switch py-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="animations_enabled" name="animations_enabled" value="1" {{ ($ds['animations_enabled'] ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="animations_enabled">Habilitar micro-animaciones dinámicas al hacer scroll</label>
                            </div>
                        </div>

                        <!-- Carga de Imagen Hero y Monograma -->
                        <div class="col-md-6 border-top pt-3">
                            <label for="hero_image" class="form-label fw-semibold">Imagen Principal de Portada (Hero Background)</label>
                            <input class="form-control" type="file" id="hero_image" name="hero_image" accept="image/*">
                            <div class="form-text small">Recomendado: Imagen horizontal, de alta resolución (max 5MB).</div>
                            @if($event->hero_image_path)
                                <div class="mt-2">
                                    <span class="small text-muted d-block">Portada actual:</span>
                                    <img src="{{ asset('storage/' . $event->hero_image_path) }}" class="img-thumbnail" style="max-height: 120px;" alt="Hero">
                                </div>
                            @endif
                        </div>

                        <div class="col-md-6 border-top pt-3">
                            <label for="monogram" class="form-label fw-semibold">Logotipo o Monograma Inicial</label>
                            <input class="form-control" type="file" id="monogram" name="monogram" accept="image/*">
                            <div class="form-text small">Monograma que aparece en el círculo del Hero. Si queda vacío, se usa la primera letra de Bianca.</div>
                            @if($event->monogram_path)
                                <div class="mt-2">
                                    <span class="small text-muted d-block">Monograma actual:</span>
                                    <img src="{{ asset('storage/' . $event->monogram_path) }}" class="img-thumbnail rounded-circle bg-dark" style="max-height: 80px; max-width: 80px;" alt="Monograma">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- PESTAÑA 3: BOTÓN DE WHATSAPP -->
                <div class="tab-pane fade" id="whatsapp" role="tabpanel" aria-labelledby="whatsapp-tab">
                    <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom border-light">
                        <h4 class="m-0 text-secondary">Botón Flotante de WhatsApp</h4>
                        <div class="form-check form-switch m-0">
                            <input class="form-check-input" type="checkbox" role="switch" id="whatsapp_enabled" name="whatsapp_enabled" value="1" {{ $event->whatsapp_enabled ? 'checked' : '' }}>
                            <label class="form-check-label small fw-semibold" for="whatsapp_enabled">Habilitar Botón</label>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="whatsapp_phone" class="form-label fw-semibold">Número de Teléfono (Con código de país, sin + ni espacios)</label>
                            <input type="text" class="form-control" id="whatsapp_phone" name="whatsapp_phone" value="{{ old('whatsapp_phone', $event->whatsapp_phone) }}" placeholder="Ej: 5491122334455">
                            <div class="form-text small">Código de país + área + celular. (Ej: 549 para Argentina, luego prefijo local sin 0 y móvil sin 15).</div>
                        </div>
                        <div class="col-md-6">
                            <label for="whatsapp_message" class="form-label fw-semibold">Mensaje Automático Inicial</label>
                            <input type="text" class="form-control" id="whatsapp_message" name="whatsapp_message" value="{{ old('whatsapp_message', $event->whatsapp_message) }}">
                            <div class="form-text small">Mensaje que el invitado enviará automáticamente al hacer clic en el botón.</div>
                        </div>
                    </div>
                </div>

                <!-- PESTAÑA 4: REGALOS / TRANSFERENCIAS -->
                <div class="tab-pane fade" id="gifts" role="tabpanel" aria-labelledby="gifts-tab">
                    <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom border-light">
                        <h4 class="m-0 text-secondary">Sección de Regalos (Regalos/CBU/Alias)</h4>
                        <div class="form-check form-switch m-0">
                            <input class="form-check-input" type="checkbox" role="switch" id="gifts_enabled" name="gifts_enabled" value="1" {{ $event->gifts_enabled ? 'checked' : '' }}>
                            <label class="form-check-label small fw-semibold" for="gifts_enabled">Habilitar Sección</label>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="gifts_alias" class="form-label fw-semibold">Alias de Cuenta Bancaria / Mercado Pago</label>
                            <input type="text" class="form-control" id="gifts_alias" name="gifts_alias" value="{{ old('gifts_alias', $event->gifts_alias) }}" placeholder="Ej: bianca.mis15.mp">
                        </div>
                        <div class="col-md-6">
                            <label for="gifts_cbu" class="form-label fw-semibold">CBU / CVU de la Cuenta (22 dígitos)</label>
                            <input type="text" class="form-control" id="gifts_cbu" name="gifts_cbu" value="{{ old('gifts_cbu', $event->gifts_cbu) }}" placeholder="Ej: 0000003100012345678901">
                        </div>

                        <div class="col-12 mt-3">
                            <label for="gifts_text" class="form-label fw-semibold">Texto Explicativo o Mensaje de Regalo</label>
                            <textarea class="form-control" id="gifts_text" name="gifts_text" rows="3">{{ old('gifts_text', $event->gifts_text) }}</textarea>
                        </div>

                        <div class="col-md-6 mt-4 border-top pt-3">
                            <label for="gifts_qr" class="form-label fw-semibold">Imagen del Código QR de Transferencia</label>
                            <input class="form-control" type="file" id="gifts_qr" name="gifts_qr" accept="image/*">
                            <div class="form-text small">Sube una captura del QR de tu banco o cuenta de Mercado Pago (max 2MB).</div>
                            @if($event->gifts_qr_path)
                                <div class="mt-2">
                                    <span class="small text-muted d-block">QR actual:</span>
                                    <img src="{{ asset('storage/' . $event->gifts_qr_path) }}" class="img-thumbnail" style="max-height: 120px;" alt="QR Regalo">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

            <!-- BOTONES DE ENVÍO FIJOS AL PIE DE LA TARJETA -->
            <div class="bg-light p-4 border-top text-end" style="border-radius: 0 0 15px 15px;">
                <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill fw-bold" style="background-color: var(--admin-accent-dark); border-color: var(--admin-accent-dark);">
                    <i class="bi bi-save me-2"></i>Guardar Todos los Cambios
                </button>
            </div>
        </form>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const themeSelect = document.getElementById('theme');
    
    // Theme Defaults configuration
    const themeDefaults = {
        cyber: {
            primary: '#FF00FF',
            secondary: '#39FF14',
            bg: '#08080C',
            dark: '#F5F5FA',
            titleFont: 'Bungee',
            bodyFont: 'Space Mono'
        },
        coquette: {
            primary: '#D4A5A9',
            secondary: '#8FA89B',
            bg: '#FCF8F5',
            dark: '#4A3E3F',
            titleFont: 'Great Vibes',
            bodyFont: 'Montserrat'
        },
        vip: {
            primary: '#DFBA73',
            secondary: '#FFFFFF',
            bg: '#0A0A0D',
            dark: '#EAEAEA',
            titleFont: 'Cinzel',
            bodyFont: 'Inter'
        }
    };

    if (themeSelect) {
        themeSelect.addEventListener('change', function() {
            const selectedTheme = this.value;
            const defaults = themeDefaults[selectedTheme];
            
            if (defaults) {
                // Update Color Pickers
                document.getElementById('color_primary').value = defaults.primary;
                document.getElementById('color_secondary').value = defaults.secondary;
                document.getElementById('color_bg').value = defaults.bg;
                document.getElementById('color_dark').value = defaults.dark;
                
                // Update Typography Dropdowns
                const titleFontSelect = document.getElementById('typography_title');
                const bodyFontSelect = document.getElementById('typography_body');
                
                if (titleFontSelect) {
                    titleFontSelect.value = defaults.titleFont;
                }
                if (bodyFontSelect) {
                    bodyFontSelect.value = defaults.bodyFont;
                }
            }
        });
    }
});
</script>
@endsection
