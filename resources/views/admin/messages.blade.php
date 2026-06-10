@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    
    <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
        <div>
            <h1 class="h3 mb-1 text-gray-800 title-font">Moderador de Mensajes y Firmas</h1>
            <p class="text-muted small mb-0">Controla el libro de firmas virtual y autoriza qué dedicatorias se muestran en el muro.</p>
        </div>
    </div>

    <!-- FILTROS DE ESTADO -->
    <div class="d-flex gap-2 mb-4 overflow-x-auto pb-2">
        <a href="{{ route('admin.messages') }}" class="btn btn-sm rounded-pill px-4 py-2 {{ !$status ? 'btn-dark' : 'btn-outline-dark' }}">
            Todos
        </a>
        <a href="{{ route('admin.messages', ['status' => 'pending']) }}" class="btn btn-sm rounded-pill px-4 py-2 {{ $status == 'pending' ? 'btn-warning text-white' : 'btn-outline-warning' }}">
            Pendientes
        </a>
        <a href="{{ route('admin.messages', ['status' => 'approved']) }}" class="btn btn-sm rounded-pill px-4 py-2 {{ $status == 'approved' ? 'btn-success' : 'btn-outline-success' }}">
            Aprobados
        </a>
        <a href="{{ route('admin.messages', ['status' => 'rejected']) }}" class="btn btn-sm rounded-pill px-4 py-2 {{ $status == 'rejected' ? 'btn-danger' : 'btn-outline-danger' }}">
            Ocultados
        </a>
    </div>

    <!-- LISTADO DE MENSAJES -->
    <div class="admin-card p-0 overflow-hidden shadow-sm" style="border-radius: 15px;">
        @if($messages->count() > 0)
            <div class="table-responsive">
                <table class="table admin-table align-middle m-0">
                    <thead>
                        <tr>
                            <th>Autor</th>
                            <th>Mensaje / Dedicatoria</th>
                            <th>Estado</th>
                            <th>Enviado</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($messages as $msg)
                            <tr>
                                <td style="width: 200px;">
                                    <strong>{{ $msg->guest_name }}</strong>
                                </td>
                                <td>
                                    <span class="text-secondary italic">"{{ $msg->message }}"</span>
                                </td>
                                <td style="width: 120px;">
                                    @if($msg->status == 'pending')
                                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning border-opacity-25 rounded-pill px-3 py-1">Pendiente</span>
                                    @elseif($msg->status == 'approved')
                                        <span class="badge bg-success-subtle text-success border border-success border-opacity-25 rounded-pill px-3 py-1">Aprobado</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger border-opacity-25 rounded-pill px-3 py-1">Ocultado</span>
                                    @endif
                                </td>
                                <td style="width: 150px;" class="text-muted small">
                                    {{ $msg->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="text-end" style="width: 250px;">
                                    <div class="d-flex justify-content-end gap-2">
                                        
                                        <!-- Botones Moderar -->
                                        @if($msg->status !== 'approved')
                                            <form action="{{ route('admin.messages.approve', $msg->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">
                                                    Aprobar
                                                </button>
                                            </form>
                                        @endif

                                        @if($msg->status !== 'rejected')
                                            <form action="{{ route('admin.messages.reject', $msg->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-warning rounded-pill px-3">
                                                    Ocultar
                                                </button>
                                            </form>
                                        @endif

                                        <!-- Botón Eliminar -->
                                        <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar definitivamente este mensaje?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- ENLACES DE PAGINACIÓN -->
            @if($messages->hasPages())
                <div class="p-3 bg-light border-top d-flex justify-content-center">
                    {{ $messages->links() }}
                </div>
            @endif
        @else
            <div class="text-center text-muted py-5">
                <i class="bi bi-chat-heart-fill fs-1 opacity-25 d-block mb-3"></i>
                <p class="italic mb-0">No se encontraron dedicatorias con el filtro seleccionado.</p>
            </div>
        @endif
    </div>

</div>
@endsection
