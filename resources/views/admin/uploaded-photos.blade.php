@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    
    <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
        <div>
            <h1 class="h3 mb-1 text-gray-800 title-font">Fotos Subidas por Invitados</h1>
            <p class="text-muted small mb-0">Modera los instantes capturados y autoriza qué fotos aparecen en el muro público.</p>
        </div>
    </div>

    <!-- FILTROS DE ESTADO -->
    <div class="d-flex gap-2 mb-4 overflow-x-auto pb-2">
        <a href="{{ route('admin.uploaded-photos') }}" class="btn btn-sm rounded-pill px-4 py-2 {{ !$status ? 'btn-dark' : 'btn-outline-dark' }}">
            Todos
        </a>
        <a href="{{ route('admin.uploaded-photos', ['status' => 'pending']) }}" class="btn btn-sm rounded-pill px-4 py-2 {{ $status == 'pending' ? 'btn-warning text-white' : 'btn-outline-warning' }}">
            Pendientes
        </a>
        <a href="{{ route('admin.uploaded-photos', ['status' => 'approved']) }}" class="btn btn-sm rounded-pill px-4 py-2 {{ $status == 'approved' ? 'btn-success' : 'btn-outline-success' }}">
            Aprobados
        </a>
        <a href="{{ route('admin.uploaded-photos', ['status' => 'rejected']) }}" class="btn btn-sm rounded-pill px-4 py-2 {{ $status == 'rejected' ? 'btn-danger' : 'btn-outline-danger' }}">
            Rechazados
        </a>
    </div>

    <!-- CUADRÍCULA DE FOTOS -->
    <div class="admin-card">
        @if($photos->count() > 0)
            <div class="row g-4">
                @foreach($photos as $photo)
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="card h-100 border-0 shadow-sm overflow-hidden" style="border-radius: 12px; background-color: var(--admin-bg-light);">
                            
                            <!-- Foto con enlace a verla grande -->
                            <div class="position-relative">
                                <img src="{{ asset('storage/' . $photo->file_path) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Invitado">
                                <span class="position-absolute top-0 start-0 m-2">
                                    @if($photo->status == 'pending')
                                        <span class="badge bg-warning text-dark border border-warning border-opacity-25 rounded-pill">Pendiente</span>
                                    @elseif($photo->status == 'approved')
                                        <span class="badge bg-success border border-success border-opacity-25 rounded-pill">Aprobada</span>
                                    @else
                                        <span class="badge bg-danger border border-danger border-opacity-25 rounded-pill">Rechazada</span>
                                    @endif
                                </span>
                            </div>

                            <div class="card-body p-3 d-flex flex-column justify-content-between">
                                <div class="mb-3">
                                    <h6 class="fw-bold mb-1 text-dark">{{ $photo->guest_name }}</h6>
                                    <p class="card-text small text-muted italic">
                                        {{ $photo->comment ? '"' . $photo->comment . '"' : 'Sin comentarios' }}
                                    </p>
                                    <span class="text-muted small d-block" style="font-size: 0.75rem;">
                                        Cargada: {{ $photo->created_at->format('d/m/Y H:i') }}
                                    </span>
                                </div>

                                <div class="border-top pt-2 mt-auto d-flex justify-content-between gap-2">
                                    
                                    <!-- Aprobación / Rechazo -->
                                    <div class="d-flex gap-1">
                                        @if($photo->status !== 'approved')
                                            <form action="{{ route('admin.uploaded-photos.approve', $photo->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success rounded-pill px-3" title="Aprobar para el muro">
                                                    Aprobar
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if($photo->status !== 'rejected')
                                            <form action="{{ route('admin.uploaded-photos.reject', $photo->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-warning rounded-pill px-3" title="Rechazar / Ocultar">
                                                    Rechazar
                                                </button>
                                            </form>
                                        @endif
                                    </div>

                                    <!-- Eliminar -->
                                    <form action="{{ route('admin.uploaded-photos.destroy', $photo->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar permanentemente esta foto del servidor?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Eliminar definitivamente">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            <!-- ENLACES DE PAGINACIÓN -->
            @if($photos->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    {{ $photos->links() }}
                </div>
            @endif
        @else
            <div class="text-center text-muted py-5">
                <i class="bi bi-camera-fill fs-1 opacity-25 d-block mb-3"></i>
                <p class="italic mb-0">No se encontraron fotos subidas con el filtro seleccionado.</p>
            </div>
        @endif
    </div>

</div>
@endsection
