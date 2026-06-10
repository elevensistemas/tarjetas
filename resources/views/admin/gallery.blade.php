@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    
    <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
        <div>
            <h1 class="h3 mb-1 text-gray-800 title-font">Galería de Fotos Oficiales</h1>
            <p class="text-muted small mb-0">Sube, destaca y elimina las fotos oficiales del álbum de recuerdos de Bianca.</p>
        </div>
    </div>

    <!-- SECCIÓN SUBIR FOTOS -->
    <div class="row g-4 mb-5">
        <div class="col-lg-4">
            <div class="admin-card">
                <h5 class="card-title border-bottom-0 pb-0 mb-3">Subir Nuevas Fotos</h5>
                
                <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="photos" class="form-label fw-semibold small">Selecciona una o más fotos</label>
                        <input class="form-control" type="file" id="photos" name="photos[]" accept="image/*" multiple required>
                        <div class="form-text small">Formatos permitidos: JPG, JPEG, PNG, WEBP. Tamaño máx: 8MB por archivo.</div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary rounded-pill w-100 py-2 fw-semibold" style="background-color: var(--admin-accent-dark); border-color: var(--admin-accent-dark);">
                        <i class="bi bi-cloud-arrow-up me-2"></i>Cargar a la Galería
                    </button>
                </form>
            </div>
        </div>

        <!-- LISTADO DE FOTOS CARGADAS -->
        <div class="col-lg-8">
            <div class="admin-card">
                <h5 class="card-title">Fotos en el Álbum</h5>

                @if($photos->count() > 0)
                    <div class="alert alert-info border-0 small py-2 d-flex align-items-center mb-4" style="border-radius: 10px;">
                        <i class="bi bi-info-circle-fill me-2 fs-5 text-info"></i>
                        <span>Marca la estrella (<i class="bi bi-star-fill text-warning"></i>) en la foto que quieras destacar como miniatura de compartir.</span>
                    </div>

                    <div class="row g-3">
                        @foreach($photos as $photo)
                            <div class="col-6 col-sm-4 col-md-3">
                                <div class="gallery-preview-card">
                                    <!-- Estrella si es destacado -->
                                    @if($photo->is_featured)
                                        <div class="highlight-star" title="Foto Destacada">
                                            <i class="bi bi-star-fill"></i>
                                        </div>
                                    @endif

                                    <img src="{{ asset('storage/' . $photo->file_path) }}" class="gallery-preview-img" alt="Álbum">
                                    
                                    <div class="gallery-preview-actions">
                                        <!-- Botón Destacar -->
                                        <form action="{{ route('admin.gallery.highlight', $photo->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm {{ $photo->is_featured ? 'btn-warning text-white' : 'btn-outline-warning' }} rounded-circle p-2" title="{{ $photo->is_featured ? 'Quitar Destacado' : 'Destacar Foto' }}">
                                                <i class="bi bi-star-fill"></i>
                                            </button>
                                        </form>

                                        <!-- Botón Eliminar -->
                                        <form action="{{ route('admin.gallery.destroy', $photo->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta foto de la galería oficial?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger rounded-circle p-2" title="Eliminar Foto">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="text-center mt-2 small text-muted">
                                    Orden: <span class="fw-bold">#{{ $photo->order }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-images fs-1 opacity-25 d-block mb-3"></i>
                        <p class="italic mb-0">La galería de fotos está vacía. ¡Sube las primeras fotos de Bianca!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection
