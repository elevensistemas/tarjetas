@extends('layouts.app')

@section('title')
    ¡Te invito a celebrar mis 15 años! - {{ $event->quinceanera_name }}
@endsection

@section('content')

@php
    $fotosPath = public_path('fotos');
    $fotos = [];
    if (file_exists($fotosPath)) {
        $files = glob($fotosPath . '/*.{jpg,jpeg,png,webp,JPG,JPEG,PNG,WEBP}', GLOB_BRACE);
        if ($files) {
            sort($files);
            foreach ($files as $file) {
                $fotos[] = basename($file);
            }
        }
    }
    
    $devices = [
        ['device' => 'tiktok', 'label' => '📱 TikTok Live'],
        ['device' => 'tv', 'label' => '📺 TV Smart'],
        ['device' => 'gameboy', 'label' => '🎮 Gameboy Retro'],
        ['device' => 'tablet', 'label' => '📟 Y2K Tablet'],
        ['device' => 'astronaut', 'label' => '👩‍🚀 Space HUD'],
        ['device' => 'polaroid', 'label' => '📸 Polaroid Cam'],
    ];
@endphp

    <!-- REPRODUCTOR DE MÚSICA FLOTANTE -->
    @if($music->is_active && $music->file_path)
        <audio id="background-audio" src="{{ asset('storage/' . $music->file_path) }}" loop data-autoplay="{{ $music->autoplay ? '1' : '0' }}"></audio>
        <div class="audio-player-floating">
            <button id="music-btn" class="music-btn" title="Música de Fondo">
                <i class="bi bi-volume-mute-fill"></i>
                <div class="waves-container">
                    <span class="wave"></span>
                    <span class="wave"></span>
                    <span class="wave"></span>
                </div>
            </button>
        </div>
    @endif

    <!-- BOTÓN DE WHATSAPP FLOTANTE -->
    @if($event->whatsapp_enabled && $event->whatsapp_phone)
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $event->whatsapp_phone) }}?text={{ urlencode($event->whatsapp_message ?? 'Hola, tengo una consulta sobre la fiesta de 15 de Bianca') }}" 
           class="whatsapp-float" 
           target="_blank" 
           rel="noopener noreferrer" 
           title="Contactarse por WhatsApp">
            <i class="bi bi-whatsapp"></i>
        </a>
    @endif

    <!-- 1. HERO / PORTADA -->
    <header class="hero-section">
        <div class="hero-bg" style="background-image: url('{{ $event->hero_image_path ? asset('storage/' . $event->hero_image_path) : asset('https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=2070&auto=format&fit=cover') }}');"></div>
        <div class="hero-overlay"></div>
        
        <!-- VHS Retro Camcorder Overlay -->
        <div class="vhs-cam-overlay">
            <div class="vhs-left-top"><span class="badge bg-danger rounded-circle animate-pulse me-1">●</span>REC</div>
            <div class="vhs-right-top">PLAY ▶</div>
            <div class="vhs-left-bottom">{{ $event->event_date->format('d . m . Y') }}</div>
            <div class="vhs-right-bottom">{{ $event->event_date->format('H:i:s') }}</div>
        </div>
        
        <div class="hero-content d-flex flex-column align-items-center">
            
            <!-- STICKER Y2K BADGE -->
            <div class="y2k-sticker-monogram mb-3">
                <span class="y2k-sticker-text">{{ $event->quinceanera_name }} 15</span>
            </div>

            <!-- INTERACTIVE SPOTIFY PLAYER FRAME -->
            <div class="spotify-player-card">
                <div class="player-header d-flex align-items-center justify-content-between mb-3">
                    <!-- Dynamic Device Tag -->
                    <span id="device-tag" class="badge bg-secondary font-monospace uppercase text-white animate-pulse" style="font-size: 0.65rem; background-color: var(--color-primary) !important;">📱 TikTok Live</span>
                    <i class="bi bi-three-dots text-white-50"></i>
                </div>
                
                <!-- Mock Device Frame Container -->
                <div class="player-art-container mb-3 shadow position-relative" id="spotify-art-frame">
                    <!-- Images Slideshow -->
                    <img id="slideshow-img" src="{{ !empty($fotos) ? asset('fotos/' . $fotos[0]) : asset('storage/design/bianca_hero_punk.png') }}" class="player-art active-slide" alt="Bianca Album Art">
                    
                    <!-- TV Scanlines & Static Screen -->
                    <div id="tv-static" class="tv-static-effect"></div>
                    
                    <!-- OVERLAY 1: TikTok Live -->
                    <div class="device-overlay" data-device="tiktok">
                        <div class="tiktok-live-badge"><span class="badge bg-danger rounded-circle animate-pulse me-1">●</span>EN VIVO</div>
                        <div class="tiktok-live-audience"><i class="bi bi-eye-fill"></i> 15.2k</div>
                        <div class="tiktok-comments-container">
                            <div class="tiktok-comment"><strong>@sofi.gomez:</strong> ¡Qué facha Bianca! 🔥</div>
                            <div class="tiktok-comment"><strong>@matias_trap:</strong> El mejor 15 del año 💎</div>
                            <div class="tiktok-comment"><strong>@luli_dance:</strong> Queremos ver ese vestido yaaa 😍</div>
                        </div>
                        <div class="tiktok-action-icons d-flex flex-column align-items-center gap-2">
                            <div class="tiktok-icon-btn"><i class="bi bi-suit-heart-fill text-danger animate-pulse"></i><span>150k</span></div>
                            <div class="tiktok-icon-btn"><i class="bi bi-chat-dots-fill"></i><span>8.2k</span></div>
                            <div class="tiktok-icon-btn"><i class="bi bi-share-fill"></i><span>Compartir</span></div>
                        </div>
                        <div class="tiktok-user-info">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle bg-secondary border border-2 border-success" style="width: 25px; height: 25px; background: url('{{ !empty($fotos) ? asset('fotos/' . $fotos[0]) : asset('storage/design/bianca_hero_punk.png') }}') center/cover;"></div>
                                <strong>@bianca.quince</strong>
                            </div>
                            <p class="small m-0 mt-1">¡Preparando la noche mágica! ⚡💀 #Mis15 #PunkStyle</p>
                        </div>
                    </div>
                    
                    <!-- OVERLAY 2: Retro TV -->
                    <div class="device-overlay" data-device="tv">
                        <div class="tv-channel">CH 15</div>
                        <div class="tv-vintage-logo">Y2K-TV</div>
                        <div class="tv-scanlines"></div>
                        <div class="tv-flicker"></div>
                        <div class="tv-tint"></div>
                        <div class="tv-control-knobs">
                            <span class="knob"></span>
                            <span class="knob"></span>
                        </div>
                    </div>
                    
                    <!-- OVERLAY 3: Gameboy Retro -->
                    <div class="device-overlay" data-device="gameboy">
                        <div class="gameboy-screen-bezel">
                            <div class="gameboy-battery-indicator">
                                <span class="battery-led"></span>
                                <span class="battery-label">BATTERY</span>
                            </div>
                            <div class="gameboy-text-top">DOT MATRIX WITH STEREO SOUND</div>
                        </div>
                        <div class="gameboy-buttons-indicator">
                            <div class="gameboy-dpad"><i class="bi bi-plus-square-fill"></i></div>
                            <div class="gameboy-a-b">
                                <span class="gameboy-btn-round">B</span>
                                <span class="gameboy-btn-round">A</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- OVERLAY 4: Y2K Tech Tablet -->
                    <div class="device-overlay" data-device="tablet">
                        <div class="tablet-header">
                            <span class="window-title">📂 BIANCA_SYSTEM_v1.5.exe</span>
                            <div class="window-controls">
                                <span>_</span>
                                <span>□</span>
                                <span class="btn-close-window">X</span>
                            </div>
                        </div>
                        <div class="tablet-hud-grid"></div>
                        <div class="tablet-hud-crosshairs">
                            <div class="hud-target-bracket corner-tl"></div>
                            <div class="hud-target-bracket corner-tr"></div>
                            <div class="hud-target-bracket corner-bl"></div>
                            <div class="hud-target-bracket corner-br"></div>
                        </div>
                        <div class="tablet-battery-hud">
                            <i class="bi bi-battery-half text-warning animate-pulse"></i> 15%
                        </div>
                    </div>
                    
                    <!-- OVERLAY 5: Astronaut Spacesuit HUD -->
                    <div class="device-overlay" data-device="astronaut">
                        <div class="astronaut-helmet-glass"></div>
                        <div class="astronaut-hud-telemetry">
                            <div class="gauge-row"><span>O2 LEVEL:</span> <span class="text-success fw-bold">100%</span></div>
                            <div class="gauge-row"><span>GRAVITY:</span> <span class="text-info font-monospace">0.15G</span></div>
                            <div class="gauge-row"><span>MISSION:</span> <span class="text-danger">BIANCA-15</span></div>
                        </div>
                        <div class="astronaut-crosshairs">⚡ TARGET LOCKED ⚡</div>
                    </div>
                    
                    <!-- OVERLAY 6: Polaroid Cam (Beach) -->
                    <div class="device-overlay" data-device="polaroid">
                        <div class="polaroid-vhs-rec"><span class="badge bg-danger rounded-circle animate-pulse me-1">●</span>REC</div>
                        <div class="polaroid-vhs-play">PLAY ▶</div>
                        <div class="polaroid-vhs-timestamp">29 . 08 . 2026</div>
                        <div class="polaroid-vhs-time">21:00:00</div>
                        <div class="polaroid-vhs-filter"></div>
                    </div>
                </div>
                
                <div class="player-track-info text-start d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="player-track-title title-font m-0 text-white" style="font-size: 1.35rem; letter-spacing: 1px;">{{ $event->hero_text }}</h4>
                        <p class="player-track-artist m-0 text-success fw-bold" style="font-size: 0.95rem; font-family: 'Permanent Marker', cursive;">
                            <span class="typing-effect">BIANCA</span>
                        </p>
                    </div>
                    <button class="btn btn-link p-0 text-white-50 fs-4"><i class="bi bi-heart"></i></button>
                </div>
                
                <!-- Progress bar mimicking her 29/8 party date! -->
                <div class="player-progress-container">
                    <div class="player-progress-track">
                        <div class="player-progress-bar" style="width: 25.8%;"></div> <!-- 29/8 ratio -->
                    </div>
                    <div class="d-flex justify-content-between text-muted mt-1 font-monospace" style="font-size: 0.65rem;">
                        <span>02:29</span>
                        <span>11:20</span>
                    </div>
                </div>
                
                <!-- Music Player Controls -->
                <div class="player-controls d-flex justify-content-between align-items-center px-2 mt-2">
                    <button class="player-btn" id="btn-spotify-shuffle" title="Mezclar Dispositivo"><i class="bi bi-shuffle"></i></button>
                    <button class="player-btn" id="btn-spotify-prev" title="Dispositivo Anterior"><i class="bi bi-skip-backward-fill"></i></button>
                    <button class="player-btn btn-play-main" id="btn-spotify-play" title="Reproducir Música"><i class="bi bi-play-circle-fill fs-1"></i></button>
                    <button class="player-btn" id="btn-spotify-next" title="Dispositivo Siguiente"><i class="bi bi-skip-forward-fill"></i></button>
                    <button class="player-btn" id="btn-spotify-repeat" title="Reiniciar Dispositivo"><i class="bi bi-repeat"></i></button>
                </div>
            </div>

            <!-- CUENTA REGRESIVA Y2K -->
            <div class="d-flex justify-content-center my-4 py-1" id="countdown-container" data-date="{{ $event->event_date->format('Y-m-d H:i:s') }}">
                <div class="countdown-box">
                    <span class="countdown-value d-block" id="days">00</span>
                    <span class="countdown-label">Días</span>
                </div>
                <div class="countdown-box">
                    <span class="countdown-value d-block" id="hours">00</span>
                    <span class="countdown-label">Horas</span>
                </div>
                <div class="countdown-box">
                    <span class="countdown-value d-block" id="minutes">00</span>
                    <span class="countdown-label">Min</span>
                </div>
                <div class="countdown-box">
                    <span class="countdown-value d-block" id="seconds">00</span>
                    <span class="countdown-label">Seg</span>
                </div>
            </div>
            
            <div class="d-flex flex-column flex-sm-row justify-content-center gap-3 mt-2 w-100 px-4" style="max-width: 450px;">
                <a href="#rsvp" class="btn btn-premium text-decoration-none">
                    <i class="bi bi-calendar-check me-2"></i>Confirmar Asistencia
                </a>
                <a href="#detalles" class="btn btn-premium-outline text-decoration-none">
                    <i class="bi bi-geo-alt me-2"></i>Ver Ubicación
                </a>
            </div>
        </div>
    </header>
    
    <!-- GUCCI WEB STRIPE -->
    <div class="gucci-stripe"></div>

    <!-- 2. MENSAJE EMOTIVO DE BIANCA -->
    @if($event->quinceanera_message)
        <section class="py-5 bg-white text-center">
            <div class="container py-4">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6">
                        <i class="bi bi-chat-quote fs-1 text-secondary opacity-50 mb-3 d-block"></i>
                        <p class="fs-4 italic brush-font px-3 mb-0" style="line-height: 1.8;">
                            "{{ $event->quinceanera_message }}"
                        </p>
                        <h4 class="title-font fs-3 text-secondary mt-3">— {{ $event->quinceanera_name }}</h4>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- 3. DETALLES DEL EVENTO -->
    <section id="detalles" class="py-5 bg-dark-section">
        <div class="container py-4">
            <div class="section-title-container">
                <p class="section-subtitle script-font">Los Detalles de</p>
                <h2 class="section-title title-font">Una Noche Especial</h2>
                <div class="title-divider"></div>
            </div>

            <div class="row g-4 justify-content-center">
                <!-- Tarjeta Fecha y Hora -->
                <div class="col-md-4">
                    <div class="glass-card card-led-pink text-center h-100 d-flex flex-column justify-content-center">
                        <i class="bi bi-clock fs-1 text-secondary mb-3"></i>
                        <h4 class="title-font fs-4 text-dark mb-2">Fecha y Hora</h4>
                        <p class="mb-0 fs-5 text-secondary">
                            {{ $event->event_date->translatedFormat('l d \d\e F') }}<br>
                            a las {{ $event->event_date->format('H:i') }} hs.
                        </p>
                    </div>
                </div>

                <!-- Tarjeta Dirección -->
                <div class="col-md-4">
                    <div class="glass-card card-led-green text-center h-100 d-flex flex-column justify-content-center">
                        <i class="bi bi-geo-alt fs-1 text-secondary mb-3"></i>
                        <h4 class="title-font fs-4 text-dark mb-2">Lugar</h4>
                        <p class="mb-0 fs-5 text-secondary fw-semibold">{{ $event->event_place }}</p>
                        <p class="text-secondary">{{ $event->event_address }}</p>
                    </div>
                </div>

                <!-- Tarjeta Dress Code -->
                <div class="col-md-4">
                    <div class="glass-card card-led-blue text-center h-100 d-flex flex-column justify-content-center">
                        <i class="bi bi-bookmark-heart fs-1 text-secondary mb-3"></i>
                        <h4 class="title-font fs-4 text-dark mb-2">Dress Code</h4>
                        <p class="mb-0 fs-5 text-secondary fw-semibold">{{ $event->dress_code }}</p>
                        @if($event->dress_code_description)
                            <p class="text-secondary small mt-2 mb-0">{{ $event->dress_code_description }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- MAPA INTEGRADO -->
            <div class="row justify-content-center mt-5">
                <div class="col-lg-10">
                    <div class="glass-card p-2 border-0 overflow-hidden shadow-sm" style="border-radius: 20px;">
                        <div class="ratio ratio-21x9 bg-light" style="border-radius: 18px; overflow: hidden; min-height: 300px;">
                            <iframe src="{{ $event->google_maps_url }}" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        <div class="text-center py-3">
                            <a href="{{ $event->google_maps_share_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-premium px-5">
                                <i class="bi bi-cursor me-2"></i>Cómo llegar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. GALERÍA DE FOTOS -->
    @if($galleryPhotos->count() > 0)
        <section class="py-5 bg-white">
            <div class="container py-4">
                <div class="section-title-container">
                    <p class="section-subtitle script-font">Mis Recuerdos</p>
                    <h2 class="section-title title-font">Galería de Fotos</h2>
                    <div class="title-divider"></div>
                </div>

                <div class="row g-3 justify-content-center">
                    @foreach($galleryPhotos as $photo)
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="gallery-item" onclick="openLightbox('{{ asset('storage/' . $photo->file_path) }}')">
                                <img src="{{ asset('storage/' . $photo->file_path) }}" class="gallery-img" alt="Recuerdo de Bianca" loading="lazy">
                                <div class="gallery-overlay">
                                    <i class="bi bi-zoom-in"></i>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- LIGHTBOX MODAL (SIN DEPENDENCIAS) -->
        <div class="modal fade" id="lightboxModal" tabindex="-1" aria-hidden="true" style="background-color: rgba(0,0,0,0.95);">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content bg-transparent border-0">
                    <div class="modal-header border-0 p-0 position-relative">
                        <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 fs-3" data-bs-dismiss="modal" aria-label="Close" style="z-index: 1050;"></button>
                    </div>
                    <div class="modal-body text-center p-0">
                        <img src="" id="lightbox-img" class="img-fluid" style="max-height: 85vh; border-radius: 8px;" alt="Visualizador de Fotos">
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- 5. RSVP – CONFIRMACIÓN DE ASISTENCIA -->
    <section id="rsvp" class="py-5" style="background-color: #FAF7F2;">
        <div class="container py-4">
            <div class="section-title-container">
                <p class="section-subtitle script-font">Confirmación</p>
                <h2 class="section-title title-font">¿Me Acompañas?</h2>
                <div class="title-divider"></div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-7">
                    @if($invitation && $invitation->is_confirmed)
                        <div class="glass-card shadow-sm text-center py-5">
                            <i class="bi bi-bookmark-check-fill fs-1 text-primary mb-3 d-block"></i>
                            <h3 class="title-font mb-3 text-white">¡Asistencia Confirmada!</h3>
                            <p class="fs-5 text-secondary px-3">
                                Hola <strong>{{ $invitation->name }}</strong>, tu respuesta ya fue registrada con éxito.
                            </p>
                            <hr class="border-secondary opacity-25 my-4 mx-auto w-75">
                            <div class="bg-dark bg-opacity-25 p-4 rounded text-start mb-4 mx-auto w-75 border border-secondary border-opacity-10" style="background-color: rgba(255,255,255,0.02) !important;">
                                <div class="mb-2"><strong>¿Asistes?:</strong> 
                                    @if($invitation->is_attending)
                                        <span class="text-success fw-bold">Sí, asistiré</span>
                                    @else
                                        <span class="text-danger fw-bold">No podré asistir</span>
                                    @endif
                                </div>
                                @if($invitation->is_attending)
                                    <div class="mb-2"><strong>Lugares reservados:</strong> {{ $invitation->assistants_count }} personas</div>
                                @endif
                                @if($invitation->dietary_restrictions)
                                    <div class="mb-2"><strong>Menú especial:</strong> {{ $invitation->dietary_restrictions }}</div>
                                @endif
                                @if($invitation->comments)
                                    <div class="mb-0"><strong>Comentario:</strong> <span class="italic text-muted">"{{ $invitation->comments }}"</span></div>
                                @endif
                            </div>
                            <p class="small text-muted mb-0 px-4">Si deseas modificar algún dato de tu confirmación, por favor contáctate directamente por WhatsApp.</p>
                        </div>
                    @else
                        <div class="glass-card shadow-sm">
                            @if($invitation)
                                <div class="alert alert-info border-0 shadow-sm text-start mb-4" style="border-radius: 12px; background-color: rgba(0, 240, 255, 0.1); border-left: 4px solid #00F0FF !important;">
                                    <h5 class="fw-bold mb-1" style="color: #00F0FF;"><i class="bi bi-envelope-open-fill me-2"></i>¡Invitación Exclusiva!</h5>
                                    <p class="mb-0 small text-white-50">Hola <strong>{{ $invitation->name }}</strong>. Tienes reservado un máximo de <strong>{{ $invitation->max_passes }}</strong> {{ $invitation->max_passes == 1 ? 'pase' : 'pases' }}. Por favor, confirma cuántos asistirán a continuación.</p>
                                </div>
                            @endif

                            <form id="rsvp-form" action="{{ route('rsvp.store') }}" method="POST" class="form-premium">
                                @csrf
                                
                                @if($invitation)
                                    <input type="hidden" name="code" value="{{ $invitation->code }}">
                                @endif

                                <div id="rsvp-alert-container"></div>
                                
                                <div class="row g-3">
                                    <!-- Nombre -->
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Nombre y Apellido</label>
                                        <input type="text" class="form-control" id="name" name="name" required placeholder="Ej: Juan Pérez" value="{{ $invitation ? $invitation->name : '' }}" {{ $invitation ? 'readonly' : '' }}>
                                    </div>
                                    
                                    <!-- Teléfono -->
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Teléfono / WhatsApp</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" required placeholder="Ej: 1122334455">
                                    </div>
                                    
                                    <!-- Confirmación de asistencia -->
                                    <div class="col-12 my-3">
                                        <label class="form-label d-block mb-3 text-center">¿Asistirás a mi fiesta?</label>
                                        <div class="d-flex justify-content-center gap-4">
                                            <div class="form-check form-check-inline m-0">
                                                <input class="form-check-input d-none" type="radio" name="is_attending" id="attending-yes" value="1" checked required>
                                                <label class="btn btn-premium-outline px-4 w-100 py-3 d-flex flex-column align-items-center" for="attending-yes" style="min-width: 140px; border-radius: 15px;">
                                                    <i class="bi bi-emoji-smile fs-2 mb-1"></i>
                                                    <span>¡Sí, asisto!</span>
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline m-0">
                                                <input class="form-check-input d-none" type="radio" name="is_attending" id="attending-no" value="0" required>
                                                <label class="btn btn-premium-outline px-4 w-100 py-3 d-flex flex-column align-items-center" for="attending-no" style="min-width: 140px; border-radius: 15px;">
                                                    <i class="bi bi-emoji-frown fs-2 mb-1"></i>
                                                    <span>No podré</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Cantidad de asistentes -->
                                    <div class="col-md-6" id="assistants-container">
                                        <label for="assistants_count" class="form-label">Cantidad de Acompañantes</label>
                                        <select class="form-select" id="assistants_count" name="assistants_count">
                                            @if($invitation)
                                                @for($i = 1; $i <= $invitation->max_passes; $i++)
                                                    <option value="{{ $i }}" {{ $i == 1 ? 'selected' : '' }}>{{ $i == 1 ? 'Asisto solo/a (1)' : "Somos $i personas" }}</option>
                                                @endfor
                                            @else
                                                <option value="1" selected>Asisto solo/a (1)</option>
                                                <option value="2">Somos 2 personas</option>
                                                <option value="3">Somos 3 personas</option>
                                                <option value="4">Somos 4 personas</option>
                                                <option value="5">Somos 5 personas</option>
                                                <option value="6">Somos más de 5</option>
                                            @endif
                                        </select>
                                    </div>

                                <!-- Restricciones Alimentarias -->
                                <div class="col-md-6" id="dietary-container">
                                    <label for="dietary_restrictions" class="form-label">Menú Especial / Restricciones</label>
                                    <select class="form-select" id="dietary_restrictions" name="dietary_restrictions">
                                        <option value="" selected>Menú Estándar</option>
                                        <option value="Vegetariano">Menú Vegetariano</option>
                                        <option value="Vegano">Menú Vegano</option>
                                        <option value="Celíaco">Menú Sin TACC / Celíaco</option>
                                        <option value="Diabético">Menú Diabético</option>
                                        <option value="Hipertenso">Menú Bajo en Sodio</option>
                                        <option value="Otro">Otro (Especificar en comentarios)</option>
                                    </select>
                                </div>

                                <!-- Comentarios -->
                                <div class="col-12">
                                    <label for="comments" class="form-label">Mensaje adicional o comentario</label>
                                    <textarea class="form-control" id="comments" name="comments" rows="3" placeholder="Si tienes alguna sugerencia o alergia específica, escríbela aquí..."></textarea>
                                </div>

                                <!-- Botón de Envío -->
                                <div class="col-12 text-center mt-4">
                                    <button type="submit" class="btn btn-premium w-100 py-3" id="rsvp-submit-btn">
                                        <span class="spinner-border spinner-border-sm me-2 d-none" id="rsvp-spinner" role="status" aria-hidden="true"></span>
                                        Confirmar mi Lugar
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. SECCIÓN REGALOS -->
    @if($event->gifts_enabled)
        <section class="py-5 bg-white">
            <div class="container py-4">
                <div class="section-title-container">
                    <p class="section-subtitle script-font">Regalos</p>
                    <h2 class="section-title title-font">Presentes</h2>
                    <div class="title-divider"></div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6">
                        <div class="glass-card text-center p-4 border border-secondary border-opacity-25" style="border-radius: 20px;">
                            <i class="bi bi-gift fs-1 text-secondary mb-3 d-block"></i>
                            <p class="fs-5 text-secondary px-2 mb-4">
                                "{{ $event->gifts_text ?? 'Tu presencia es mi mejor regalo. Pero si deseas hacerme un presente, puedes colaborar mediante transferencia bancaria o Mercado Pago.' }}"
                            </p>
                            
                            <div class="accordion accordion-premium" id="giftsAccordion">
                                <div class="accordion-item border border-opacity-25">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAccount" aria-expanded="false" aria-controls="collapseAccount">
                                            <i class="bi bi-bank me-2 text-secondary"></i> Ver datos de transferencia
                                        </button>
                                    </h2>
                                    <div id="collapseAccount" class="accordion-collapse collapse" data-bs-parent="#giftsAccordion">
                                        <div class="accordion-body bg-light text-start py-4" style="border-radius: 0 0 15px 15px;">
                                            @if($event->gifts_alias)
                                                <div class="mb-3 border-bottom pb-2">
                                                    <span class="text-uppercase small text-muted d-block">Alias:</span>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <strong id="alias-text" class="fs-5 text-dark">{{ $event->gifts_alias }}</strong>
                                                        <button class="btn btn-outline-secondary btn-sm rounded-pill" onclick="copyToClipboard('alias-text')">
                                                            <i class="bi bi-copy"></i> Copiar
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            @if($event->gifts_cbu)
                                                <div class="mb-2">
                                                    <span class="text-uppercase small text-muted d-block">CBU:</span>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <strong id="cbu-text" class="fs-6 text-dark" style="word-break: break-all;">{{ $event->gifts_cbu }}</strong>
                                                        <button class="btn btn-outline-secondary btn-sm rounded-pill ms-2" onclick="copyToClipboard('cbu-text')">
                                                            <i class="bi bi-copy"></i> Copiar
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @if($event->gifts_qr_path)
                                    <div class="accordion-item border border-opacity-25">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseQr" aria-expanded="false" aria-controls="collapseQr">
                                                <i class="bi bi-qr-code me-2 text-secondary"></i> Ver Código QR
                                            </button>
                                        </h2>
                                        <div id="collapseQr" class="accordion-collapse collapse" data-bs-parent="#giftsAccordion">
                                            <div class="accordion-body text-center bg-light" style="border-radius: 0 0 15px 15px;">
                                                <img src="{{ asset('storage/' . $event->gifts_qr_path) }}" class="img-fluid border shadow-sm p-2 bg-white" style="max-height: 250px; border-radius: 12px;" alt="Mercado Pago QR">
                                                <p class="small text-muted mt-2 mb-0">Escanea desde tu app bancaria o Mercado Pago</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- 7. LIBRO DE MENSAJES / MURO DE DEDICATORIAS -->
    <section class="py-5" style="background-color: #FAF7F2;">
        <div class="container py-4">
            <div class="section-title-container">
                <p class="section-subtitle script-font">Libro de Firmas</p>
                <h2 class="section-title title-font">Dedicatorias</h2>
                <div class="title-divider"></div>
            </div>

            <div class="row justify-content-center mb-5">
                <div class="col-md-8 col-lg-6 text-center">
                    <button class="btn btn-premium px-5" data-bs-toggle="collapse" data-bs-target="#collapseMessageForm">
                        <i class="bi bi-pencil-square me-2"></i>Dejar un Mensaje a Bianca
                    </button>
                    
                    <div class="collapse mt-4 text-start" id="collapseMessageForm">
                        <div class="glass-card shadow-sm">
                            <form id="message-form" action="{{ route('guest-message.store') }}" method="POST" class="form-premium">
                                @csrf
                                <div id="message-alert-container"></div>
                                <div class="mb-3">
                                    <label for="msg_guest_name" class="form-label">Tu Nombre</label>
                                    <input type="text" class="form-control" id="msg_guest_name" name="guest_name" required placeholder="Ej: Padrino Luis">
                                </div>
                                <div class="mb-3">
                                    <label for="msg_message" class="form-label">Tu Dedicatoria</label>
                                    <textarea class="form-control" id="msg_message" name="message" rows="4" required placeholder="Escribe tus mejores deseos para mi noche de 15 años..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-premium w-100 py-3" id="message-submit-btn">
                                    <span class="spinner-border spinner-border-sm me-2 d-none" id="message-spinner" role="status" aria-hidden="true"></span>
                                    Enviar Mensaje
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MURO DE MENSAJES -->
            <div class="row justify-content-center" id="messages-wall">
                @if($approvedMessages->count() > 0)
                    <div class="col-12 col-md-10">
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 justify-content-center">
                            @foreach($approvedMessages as $msg)
                                <div class="col">
                                    <div class="message-bubble h-100 d-flex flex-column justify-content-between">
                                        <p class="text-secondary italic mb-3 font-monospace" style="font-size: 0.95rem;">
                                            "{{ $msg->message }}"
                                        </p>
                                        <h5 class="script-font fs-3 text-secondary text-end m-0">— {{ $msg->guest_name }}</h5>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="col-12 text-center text-muted py-4">
                        <p class="italic mb-0">Aún no hay dedicatorias visibles. ¡Sé el primero en dejar un lindo mensaje!</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- 8. SUBIDA DE FOTOS POR INVITADOS -->
    <section class="py-5 bg-white">
        <div class="container py-4">
            <div class="section-title-container">
                <p class="section-subtitle script-font">Instantes Compartidos</p>
                <h2 class="section-title title-font">Muro de Fotos</h2>
                <div class="title-divider"></div>
            </div>

            <div class="row justify-content-center mb-5">
                <div class="col-md-8 col-lg-6 text-center">
                    <p class="text-secondary mb-4">¿Tomaste fotos increíbles en la fiesta? Súbelas aquí para compartirlas conmigo y que aparezcan en el muro interactivo.</p>
                    <button class="btn btn-premium px-5" data-bs-toggle="collapse" data-bs-target="#collapsePhotoForm">
                        <i class="bi bi-camera me-2"></i>Subir una Foto
                    </button>
                    
                    <div class="collapse mt-4 text-start" id="collapsePhotoForm">
                        <div class="glass-card shadow-sm">
                            <form id="photo-form" action="{{ route('guest-photo.store') }}" method="POST" enctype="multipart/form-data" class="form-premium">
                                @csrf
                                <div id="photo-alert-container"></div>
                                <div class="mb-3">
                                    <label for="upload_guest_name" class="form-label">Tu Nombre</label>
                                    <input type="text" class="form-control" id="upload_guest_name" name="guest_name" required placeholder="Ej: Tía María">
                                </div>
                                <div class="mb-3">
                                    <label for="upload_photo" class="form-label">Seleccionar Foto</label>
                                    <input type="file" class="form-control" id="upload_photo" name="photo" accept="image/*" required>
                                    <div class="form-text small text-muted">Formatos: JPG, JPEG, PNG, WEBP. Tamaño máx: 10MB</div>
                                </div>
                                <div class="mb-3">
                                    <label for="upload_comment" class="form-label">Comentario Corto</label>
                                    <input type="text" class="form-control" id="upload_comment" name="comment" placeholder="Ej: ¡Hermosa Bianca!">
                                </div>
                                <button type="submit" class="btn btn-premium w-100 py-3" id="photo-submit-btn">
                                    <span class="spinner-border spinner-border-sm me-2 d-none" id="photo-spinner" role="status" aria-hidden="true"></span>
                                    Subir Foto al Muro
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FOTOS DE INVITADOS APROBADAS (ESTILO POLAROID) -->
            <div class="row justify-content-center" id="guest-photos-wall">
                @if($approvedPhotos->count() > 0)
                    <div class="col-12 col-md-10">
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 justify-content-center">
                            @foreach($approvedPhotos as $gPhoto)
                                <div class="col">
                                    <div class="polaroid-card">
                                        <img src="{{ asset('storage/' . $gPhoto->file_path) }}" class="polaroid-img" alt="Foto de invitado" onclick="openLightbox('{{ asset('storage/' . $gPhoto->file_path) }}')">
                                        <div class="polaroid-caption">
                                            @if($gPhoto->comment)
                                                <p class="mb-0 italic text-muted">"{{ $gPhoto->comment }}"</p>
                                            @endif
                                            <div class="polaroid-author">— {{ $gPhoto->guest_name }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="col-12 text-center text-muted py-4">
                        <p class="italic mb-0">Aún no hay fotos aprobadas en la galería de los invitados. ¡Sube la primera!</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- 9. SECCIÓN COMPARTIR INVITACIÓN (CÓDIGO QR GENERADO DINÁMICAMENTE) -->
    <section class="py-5" style="background-color: #FAF7F2;">
        <div class="container py-4 text-center">
            <div class="section-title-container">
                <p class="section-subtitle script-font">Compartir</p>
                <h2 class="section-title title-font">Código QR</h2>
                <div class="title-divider"></div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="glass-card p-4">
                        @php
                            $currentUrl = url()->current();
                            $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=" . urlencode($currentUrl);
                        @endphp
                        
                        <img src="{{ $qrCodeUrl }}" class="img-fluid border p-2 bg-white shadow-sm mb-3" style="max-height: 200px; border-radius: 12px;" alt="Código QR Invitación">
                        
                        <p class="text-secondary small mb-3">Muestra este código para que tus amigos o familiares lo escaneen y accedan directamente a la invitación digital.</p>
                        
                        <a href="{{ $qrCodeUrl }}" download="qr_invitacion_bianca15.png" target="_blank" class="btn btn-premium-outline rounded-pill w-100">
                            <i class="bi bi-download me-2"></i>Descargar QR
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER ELEGANTE -->
    <footer class="py-5 bg-dark text-white text-center" style="background-color: #1A1A1A !important;">
        <div class="container">
            <span class="script-font fs-1 d-block mb-2 text-secondary">{{ $event->quinceanera_name }}</span>
            <div class="title-font fs-6 text-muted mb-3" style="letter-spacing: 2px;">MIS 15 AÑOS</div>
            <hr class="w-25 mx-auto border-secondary opacity-25 mb-4">
            <p class="small text-muted mb-0">© {{ date('Y') }} Todos los derechos reservados. Diseñado con amor para Bianca.</p>
        </div>
    </footer>

    <!-- TOAST DE COPIADO EXITOSO -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100;">
        <div id="copyToast" class="toast align-items-center text-white bg-success border-0 rounded-pill" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex justify-content-center py-2 px-3">
                <div class="toast-body fs-6 py-1">
                    <i class="bi bi-check-circle-fill me-2"></i>¡Copiado al portapapeles!
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        // Lógica de apertura del visualizador Lightbox (Cero dependencias)
        function openLightbox(imgUrl) {
            const modalImage = document.getElementById('lightbox-img');
            if (modalImage) {
                modalImage.src = imgUrl;
                const modal = new bootstrap.Modal(document.getElementById('lightboxModal'));
                modal.show();
            }
        }

        // Lógica para copiar CBU/Alias en portapapeles
        function copyToClipboard(elementId) {
            const textToCopy = document.getElementById(elementId).innerText;
            navigator.clipboard.writeText(textToCopy).then(() => {
                const toastEl = document.getElementById('copyToast');
                const toast = new bootstrap.Toast(toastEl);
                toast.show();
            }).catch(err => {
                console.error('Error al copiar el texto: ', err);
            });
        }

        // Animación suave de visualización al hacer scroll (Intersection Observer)
        document.addEventListener('DOMContentLoaded', function() {
            // Manejador del campo de asistencia para esconder/mostrar acompañantes
            const attendingYes = document.getElementById('attending-yes');
            const attendingNo = document.getElementById('attending-no');
            const assistantsContainer = document.getElementById('assistants-container');
            const dietaryContainer = document.getElementById('dietary-container');

            if(attendingYes && attendingNo) {
                function toggleRsvpFields() {
                    if (attendingYes.checked) {
                        assistantsContainer.style.display = 'block';
                        dietaryContainer.style.display = 'block';
                    } else {
                        assistantsContainer.style.display = 'none';
                        dietaryContainer.style.display = 'none';
                    }
                }
                attendingYes.addEventListener('change', toggleRsvpFields);
                attendingNo.addEventListener('change', toggleRsvpFields);
                toggleRsvpFields(); // Ejecución inicial
            }

            // AJAX: Formulario RSVP
            const rsvpForm = document.getElementById('rsvp-form');
            if (rsvpForm) {
                rsvpForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const submitBtn = document.getElementById('rsvp-submit-btn');
                    const spinner = document.getElementById('rsvp-spinner');
                    const alertContainer = document.getElementById('rsvp-alert-container');
                    
                    submitBtn.disabled = true;
                    spinner.classList.remove('d-none');
                    alertContainer.innerHTML = ''; // Limpiar alertas anteriores

                    const formData = new FormData(rsvpForm);
                    
                    fetch(rsvpForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        submitBtn.disabled = false;
                        spinner.classList.add('d-none');
                        
                        if (data.success) {
                            alertContainer.innerHTML = `
                                <div class="alert alert-success border-0 shadow-sm" style="border-radius: 12px;">
                                    <i class="bi bi-check-circle-fill me-2"></i> ${data.message}
                                </div>
                            `;
                            rsvpForm.reset();
                            // Esconder el botón para evitar re-envíos
                            submitBtn.style.display = 'none';
                        } else {
                            alertContainer.innerHTML = `
                                <div class="alert alert-danger border-0 shadow-sm" style="border-radius: 12px;">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i> ${data.message}
                                </div>
                            `;
                        }
                    })
                    .catch(error => {
                        submitBtn.disabled = false;
                        spinner.classList.add('d-none');
                        alertContainer.innerHTML = `
                            <div class="alert alert-danger border-0 shadow-sm" style="border-radius: 12px;">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> Ya existe una confirmación con este número de teléfono o los datos ingresados no son correctos.
                            </div>
                        `;
                    });
                });
            }

            // AJAX: Formulario Dedicatorias
            const messageForm = document.getElementById('message-form');
            if (messageForm) {
                messageForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const submitBtn = document.getElementById('message-submit-btn');
                    const spinner = document.getElementById('message-spinner');
                    const alertContainer = document.getElementById('message-alert-container');
                    
                    submitBtn.disabled = true;
                    spinner.classList.remove('d-none');
                    alertContainer.innerHTML = '';

                    const formData = new FormData(messageForm);
                    
                    fetch(messageForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        submitBtn.disabled = false;
                        spinner.classList.add('d-none');
                        
                        if (data.success) {
                            alertContainer.innerHTML = `
                                <div class="alert alert-success border-0 shadow-sm" style="border-radius: 12px;">
                                    <i class="bi bi-check-circle-fill me-2"></i> ${data.message}
                                </div>
                            `;
                            messageForm.reset();
                        } else {
                            alertContainer.innerHTML = `
                                <div class="alert alert-danger border-0 shadow-sm" style="border-radius: 12px;">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i> ${data.message}
                                </div>
                            `;
                        }
                    })
                    .catch(error => {
                        submitBtn.disabled = false;
                        spinner.classList.add('d-none');
                        alertContainer.innerHTML = `
                            <div class="alert alert-danger border-0 shadow-sm" style="border-radius: 12px;">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> Ocurrió un error. Verifica que los campos sean válidos.
                            </div>
                        `;
                    });
                });
            }

            // AJAX: Formulario Fotos de Invitados
            const photoForm = document.getElementById('photo-form');
            if (photoForm) {
                photoForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const submitBtn = document.getElementById('photo-submit-btn');
                    const spinner = document.getElementById('photo-spinner');
                    const alertContainer = document.getElementById('photo-alert-container');
                    
                    submitBtn.disabled = true;
                    spinner.classList.remove('d-none');
                    alertContainer.innerHTML = '';

                    const formData = new FormData(photoForm);
                    
                    fetch(photoForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        submitBtn.disabled = false;
                        spinner.classList.add('d-none');
                        
                        if (data.success) {
                            alertContainer.innerHTML = `
                                <div class="alert alert-success border-0 shadow-sm" style="border-radius: 12px;">
                                    <i class="bi bi-check-circle-fill me-2"></i> ${data.message}
                                </div>
                            `;
                            photoForm.reset();
                        } else {
                            alertContainer.innerHTML = `
                                <div class="alert alert-danger border-0 shadow-sm" style="border-radius: 12px;">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i> ${data.message}
                                </div>
                            `;
                        }
                    })
                    .catch(error => {
                        submitBtn.disabled = false;
                        spinner.classList.add('d-none');
                        alertContainer.innerHTML = `
                            <div class="alert alert-danger border-0 shadow-sm" style="border-radius: 12px;">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> Ocurrió un error. Verifica que la imagen sea menor a 10MB y de formato válido (JPG, PNG, WEBP).
                            </div>
                        `;
                    });
                });
            }

            // ==========================================
            // INTERACTIVE CYBER-DEVICES SLIDESHOW LOGIC
            // ==========================================
            const slides = [
                @if(!empty($fotos))
                    @foreach($fotos as $index => $foto)
                        @php
                            $dev = $devices[$index % count($devices)];
                        @endphp
                        {
                            image: "{{ asset('fotos/' . $foto) }}",
                            label: "{{ $dev['label'] }}",
                            device: "{{ $dev['device'] }}"
                        },
                    @endforeach
                @else
                    {
                        image: "{{ asset('storage/design/bianca_hero_punk.png') }}",
                        label: "📱 TikTok Live",
                        device: "tiktok"
                    },
                    {
                        image: "{{ asset('storage/design/bianca_rollercoaster.png') }}",
                        label: "📺 TV Smart",
                        device: "tv"
                    },
                    {
                        image: "{{ asset('storage/design/bianca_arcade.png') }}",
                        label: "🎮 Gameboy Retro",
                        device: "gameboy"
                    },
                    {
                        image: "{{ asset('storage/design/bianca_cyber_neon.png') }}",
                        label: "📟 Y2K Tablet",
                        device: "tablet"
                    },
                    {
                        image: "{{ asset('storage/design/bianca_astronaut.png') }}",
                        label: "👩‍🚀 Space HUD",
                        device: "astronaut"
                    },
                    {
                        image: "{{ asset('storage/design/bianca_beach.png') }}",
                        label: "📸 Polaroid Cam",
                        device: "polaroid"
                    }
                @endif
            ];

            let currentSlideIndex = 0;
            let slideshowInterval = null;

            function showSlide(index, isManual = false) {
                if (index < 0) {
                    index = slides.length - 1;
                } else if (index >= slides.length) {
                    index = 0;
                }
                
                currentSlideIndex = index;
                const slide = slides[currentSlideIndex];
                
                const staticEffect = document.getElementById('tv-static');
                const slideshowImg = document.getElementById('slideshow-img');
                const deviceTag = document.getElementById('device-tag');
                
                if (staticEffect) {
                    staticEffect.classList.add('active-glitch');
                }
                
                setTimeout(() => {
                    if (slideshowImg) {
                        slideshowImg.src = slide.image;
                    }
                    if (deviceTag) {
                        deviceTag.textContent = slide.label;
                        
                        // Adapt border and badge colors
                        if (slide.device === 'tiktok') {
                            deviceTag.style.setProperty('background-color', 'var(--color-primary)', 'important');
                            deviceTag.style.setProperty('color', '#fff', 'important');
                        } else if (slide.device === 'tv') {
                            deviceTag.style.setProperty('background-color', 'var(--color-secondary)', 'important');
                            deviceTag.style.setProperty('color', '#fff', 'important');
                        } else if (slide.device === 'gameboy') {
                            deviceTag.style.setProperty('background-color', '#a6192e', 'important');
                            deviceTag.style.setProperty('color', '#fff', 'important');
                        } else if (slide.device === 'tablet') {
                            deviceTag.style.setProperty('background-color', '#0070FF', 'important');
                            deviceTag.style.setProperty('color', '#fff', 'important');
                        } else if (slide.device === 'astronaut') {
                            deviceTag.style.setProperty('background-color', '#00FFFF', 'important');
                            deviceTag.style.setProperty('color', '#000', 'important');
                        } else if (slide.device === 'polaroid') {
                            deviceTag.style.setProperty('background-color', '#ff5500', 'important');
                            deviceTag.style.setProperty('color', '#fff', 'important');
                        }
                    }
                    
                    const overlays = document.querySelectorAll('.device-overlay');
                    overlays.forEach(overlay => {
                        if (overlay.getAttribute('data-device') === slide.device) {
                            overlay.style.display = 'block';
                        } else {
                            overlay.style.display = 'none';
                        }
                    });
                    
                    setTimeout(() => {
                        if (staticEffect) {
                            staticEffect.classList.remove('active-glitch');
                        }
                    }, 150);
                    
                }, 200);

                if (isManual) {
                    resetSlideshowTimer();
                }
            }

            function resetSlideshowTimer() {
                if (slideshowInterval) {
                    clearInterval(slideshowInterval);
                }
                slideshowInterval = setInterval(() => {
                    showSlide(currentSlideIndex + 1);
                }, 10000);
            }

            // Start Slideshow and Controls
            resetSlideshowTimer();
            
            const nextBtn = document.getElementById('btn-spotify-next');
            const prevBtn = document.getElementById('btn-spotify-prev');
            const shuffleBtn = document.getElementById('btn-spotify-shuffle');
            const repeatBtn = document.getElementById('btn-spotify-repeat');
            
            if (nextBtn) {
                nextBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    showSlide(currentSlideIndex + 1, true);
                });
            }
            if (prevBtn) {
                prevBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    showSlide(currentSlideIndex - 1, true);
                });
            }
            if (shuffleBtn) {
                shuffleBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    let randomIndex;
                    do {
                        randomIndex = Math.floor(Math.random() * slides.length);
                    } while (randomIndex === currentSlideIndex && slides.length > 1);
                    showSlide(randomIndex, true);
                });
            }
            if (repeatBtn) {
                repeatBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    // Play special screen static noise flash
                    const staticEffect = document.getElementById('tv-static');
                    if (staticEffect) {
                        staticEffect.classList.add('active-glitch');
                        setTimeout(() => {
                            staticEffect.classList.remove('active-glitch');
                        }, 500);
                    }
                    showSlide(currentSlideIndex, true);
                });
            }
        });
    </script>
@endsection
