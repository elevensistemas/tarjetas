@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    
    <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
        <div>
            <h1 class="h3 mb-1 text-gray-800 title-font">Música de Fondo</h1>
            <p class="text-muted small mb-0">Carga la canción que sonará automáticamente cuando tus invitados abran la invitación.</p>
        </div>
    </div>

    <div class="row g-4">
        
        <!-- Formulario de Configuración -->
        <div class="col-lg-7">
            <div class="admin-card">
                <h5 class="card-title">Ajustes del Reproductor</h5>
                
                <form action="{{ route('admin.music.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="music_file" class="form-label fw-semibold small">Cargar Canción en Formato MP3</label>
                        <input class="form-control" type="file" id="music_file" name="music_file" accept="audio/mpeg,audio/mp3">
                        <div class="form-text small text-muted">Asegúrate de que esté en formato MP3 y que no supere los 15 Megabytes (15MB).</div>
                    </div>

                    <div class="p-3 border rounded-3 bg-light mb-4">
                        <h6 class="fw-bold mb-3"><i class="bi bi-play-circle text-primary me-2"></i>Comportamiento</h6>
                        
                        <!-- Música Activa Toggle -->
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ $music->is_active ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_active">Música activa en la invitación</label>
                            <div class="form-text small text-muted">Si se desactiva, el reproductor flotante no se mostrará para los invitados.</div>
                        </div>

                        <!-- Autoplay Toggle -->
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="autoplay" name="autoplay" value="1" {{ $music->autoplay ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="autoplay">Iniciar reproducción automáticamente (Autoplay)</label>
                            <div class="form-text small text-muted">El navegador intentará reproducir el audio de fondo al cargar la página. (Nota: los navegadores móviles requieren un clic en la pantalla para permitir sonido).</div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-semibold" style="background-color: var(--admin-accent-dark); border-color: var(--admin-accent-dark);">
                        <i class="bi bi-save me-2"></i>Guardar Ajustes
                    </button>
                </form>
            </div>
        </div>

        <!-- Vista Previa de Canción Actual -->
        <div class="col-lg-5">
            <div class="admin-card text-center py-5 h-100 d-flex flex-column justify-content-center">
                <i class="bi bi-music-note-beamed text-secondary opacity-25 mb-3" style="font-size: 4rem;"></i>
                
                @if($music->file_path)
                    <h5 class="fw-bold text-dark mb-2">Canción Activa</h5>
                    <p class="text-muted small px-3 mb-4">
                        Archivo: <strong>{{ basename($music->file_path) }}</strong>
                    </p>

                    <!-- Pre-escucha -->
                    <div class="px-4 mb-4">
                        <audio controls class="w-100" style="outline: none;">
                            <source src="{{ asset('storage/' . $music->file_path) }}" type="audio/mpeg">
                            Tu navegador no soporta el elemento de audio.
                        </audio>
                    </div>

                    <!-- Eliminar Canción -->
                    <form action="{{ route('admin.music.destroy') }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar permanentemente la canción de fondo actual?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-4">
                            <i class="bi bi-trash me-2"></i>Eliminar Canción del Servidor
                        </button>
                    </form>
                @else
                    <h5 class="fw-bold text-muted mb-2">No hay ninguna canción cargada</h5>
                    <p class="text-muted small px-4 mb-0">Carga un archivo MP3 en el panel izquierdo para activar la ambientación sonora en la invitación.</p>
                @endif
            </div>
        </div>

    </div>

</div>
@endsection
