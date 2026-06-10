@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    
    <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between mb-4 border-bottom pb-3 gap-3">
        <div>
            <h1 class="h3 mb-1 text-gray-800 title-font">Invitaciones y RSVP</h1>
            <p class="text-muted small mb-0">Crea enlaces de invitación personalizados y administra las confirmaciones recibidas.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.rsvp.export') }}" class="btn btn-success rounded-pill px-4 py-2 fw-semibold">
                <i class="bi bi-file-earmark-excel me-2"></i>Exportar Planilla CSV
            </a>
        </div>
    </div>

    <!-- NAVEGACIÓN POR PESTAÑAS (TABS) -->
    <ul class="nav nav-tabs settings-tabs mb-4 bg-light px-3 pt-2" id="rsvpTabs" role="tablist" style="border-radius: 10px; border: 1px solid rgba(0,0,0,0.05);">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold" id="invitations-tab" data-bs-toggle="tab" data-bs-target="#invitations" type="button" role="tab" aria-controls="invitations" aria-selected="true">
                <i class="bi bi-link-45deg me-1 text-primary"></i> Generador de Enlaces y Pases
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="confirmations-tab" data-bs-toggle="tab" data-bs-target="#confirmations" type="button" role="tab" aria-controls="confirmations" aria-selected="false">
                <i class="bi bi-bookmark-check-fill me-1 text-success"></i> Confirmaciones Recibidas (RSVP)
            </button>
        </li>
    </ul>

    <!-- CONTENIDO DE LAS PESTAÑAS -->
    <div class="tab-content" id="rsvpTabsContent">
        
        <!-- PESTAÑA 1: GENERADOR DE ENLACES -->
        <div class="tab-pane fade show active" id="invitations" role="tabpanel" aria-labelledby="invitations-tab">
            <div class="row g-4">
                <!-- FORMULARIO CREAR INVITACIÓN -->
                <div class="col-lg-4">
                    <div class="admin-card shadow-sm border-0 mb-4" style="border-radius: 15px;">
                        <h4 class="fw-bold mb-3 text-primary"><i class="bi bi-plus-circle-fill me-2"></i>Nueva Invitación</h4>
                        <form action="{{ route('admin.rsvp.store-invite') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="invite_name" class="form-label fw-semibold small">Nombre del Invitado o Familia</label>
                                <input type="text" class="form-control bg-light" id="invite_name" name="name" required placeholder="Ej: Familia Gómez, Padrino Luis..." style="border-radius: 8px;">
                            </div>
                            <div class="mb-3">
                                <label for="max_passes" class="form-label fw-semibold small">Cantidad de Pases (Total personas)</label>
                                <input type="number" class="form-control bg-light" id="max_passes" name="max_passes" value="2" min="1" max="20" required style="border-radius: 8px;">
                            </div>
                            <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold" style="background-color: var(--admin-accent-dark); border-color: var(--admin-accent-dark);">
                                <i class="bi bi-magic me-2"></i>Generar Enlace
                            </button>
                        </form>
                    </div>
                </div>

                <!-- LISTADO DE INVITACIONES -->
                <div class="col-lg-8">
                    <div class="admin-card p-0 overflow-hidden shadow-sm" style="border-radius: 15px; border: 1px solid rgba(0,0,0,0.05);">
                        <div class="p-3 bg-light border-bottom d-flex align-items-center justify-content-between">
                            <h5 class="m-0 fw-bold"><i class="bi bi-list-ul me-2 text-primary"></i>Invitaciones y Enlaces Generados</h5>
                            <span class="badge bg-primary rounded-pill px-3 py-1">{{ $invitations->count() }} totales</span>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table admin-table align-middle m-0">
                                <thead>
                                    <tr>
                                        <th>Invitado / Familia</th>
                                        <th class="text-center">Pases</th>
                                        <th class="text-center">Estado</th>
                                        <th>Enlace / WhatsApp</th>
                                        <th class="text-end">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $quinName = $event->quinceanera_name ?? 'Bianca';
                                        $waTextTemplate = "🌸 ¡Hola *GUEST_NAME*!\n\nFalta muy poco para mi gran noche de 15 años y quiero que seas parte de este momento tan especial. Te comparto mi invitación digital interactiva donde podrás ver la ubicación, escuchar música y confirmar tu asistencia:\n\n🔗 *INVITATION_URL*\n\n¡Te espero! — $quinName ✨";
                                    @endphp
                                    @forelse($invitations as $invite)
                                        @php
                                            $inviteUrl = url('/?invitado=' . $invite->code);
                                            $messageText = str_replace(
                                                ['GUEST_NAME', 'INVITATION_URL'],
                                                [$invite->name, $inviteUrl],
                                                $waTextTemplate
                                            );
                                            $waLink = 'https://api.whatsapp.com/send?text=' . rawurlencode($messageText);
                                        @endphp
                                        <tr>
                                            <td>
                                                <strong class="text-dark">{{ $invite->name }}</strong>
                                                <div class="text-muted small font-monospace mt-1" style="font-size: 0.75rem;">Código: {{ $invite->code }}</div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill px-3">{{ $invite->max_passes }}</span>
                                            </td>
                                            <td class="text-center">
                                                @if($invite->is_confirmed)
                                                    @if($invite->is_attending)
                                                        <span class="badge bg-success-subtle text-success border border-success border-opacity-25 rounded-pill px-3 py-1">Confirmó SÍ ({{ $invite->assistants_count }})</span>
                                                    @else
                                                        <span class="badge bg-danger-subtle text-danger border border-danger border-opacity-25 rounded-pill px-3 py-1">Confirmó NO</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-warning-subtle text-warning border border-warning border-opacity-25 rounded-pill px-3 py-1">Pendiente</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column gap-1" style="max-width: 250px;">
                                                    <div class="input-group input-group-sm">
                                                        <input type="text" class="form-control bg-light text-muted small border-end-0" id="link-{{ $invite->id }}" value="{{ $inviteUrl }}" readonly style="border-radius: 6px 0 0 6px;">
                                                        <button class="btn btn-outline-secondary border-start-0" onclick="copyText('link-{{ $invite->id }}')" title="Copiar enlace" style="border-radius: 0 6px 6px 0;">
                                                            <i class="bi bi-copy"></i>
                                                        </button>
                                                    </div>
                                                    <a href="{{ $waLink }}" target="_blank" class="btn btn-sm btn-success rounded-pill mt-1 text-center py-1 text-white fw-semibold d-flex align-items-center justify-content-center gap-1" style="font-size: 0.75rem; background-color: #25D366; border-color: #25D366;">
                                                        <i class="bi bi-whatsapp"></i> Enviar por WhatsApp
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <form action="{{ route('admin.rsvp.destroy', $invite->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta invitación?');" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Eliminar">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">No se han generado invitaciones de enlace aún. Crea una en el panel izquierdo.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PESTAÑA 2: CONFIRMACIONES RSVP -->
        <div class="tab-pane fade" id="confirmations" role="tabpanel" aria-labelledby="confirmations-tab">
            <!-- TARJETAS DE CONTEOS RÁPIDOS -->
            <div class="row g-3 mb-4">
                <div class="col-6 col-md-3">
                    <div class="bg-white p-3 rounded-4 shadow-sm border-0 text-center">
                        <span class="text-uppercase small text-muted d-block fw-bold">Total RSVP</span>
                        <span class="fs-3 fw-bold text-dark">{{ $totals['total_registered'] }}</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="bg-white p-3 rounded-4 shadow-sm border-0 text-center">
                        <span class="text-uppercase small text-success d-block fw-bold">Confirmaron SÍ</span>
                        <span class="fs-3 fw-bold text-success">{{ $totals['attending'] }}</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="bg-white p-3 rounded-4 shadow-sm border-0 text-center">
                        <span class="text-uppercase small text-primary d-block fw-bold">Asistentes Totales</span>
                        <span class="fs-3 fw-bold text-primary">{{ $totals['total_people'] }}</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="bg-white p-3 rounded-4 shadow-sm border-0 text-center">
                        <span class="text-uppercase small text-danger d-block fw-bold">Confirmaron NO</span>
                        <span class="fs-3 fw-bold text-danger">{{ $totals['not_attending'] }}</span>
                    </div>
                </div>
            </div>

            <!-- FILTROS Y BUSCADOR -->
            <div class="admin-card mb-4 py-3">
                <form action="{{ route('admin.rsvp') }}" method="GET" class="row g-3 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control border-start-0 bg-light" name="search" value="{{ $search }}" placeholder="Buscar por nombre o teléfono...">
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <select class="form-select bg-light" name="attendance">
                            <option value="" selected>Todos los estados</option>
                            <option value="1" {{ ($attendance === '1') ? 'selected' : '' }}>Asistirá (SÍ)</option>
                            <option value="0" {{ ($attendance === '0') ? 'selected' : '' }}>No asistirá (NO)</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 w-100" style="background-color: var(--admin-accent-dark); border-color: var(--admin-accent-dark);">
                            Filtrar
                        </button>
                        @if($search || $attendance !== null)
                            <a href="{{ route('admin.rsvp') }}" class="btn btn-outline-secondary rounded-pill px-3">
                                Limpiar
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- TABLA DE INVITADOS -->
            <div class="admin-card p-0 overflow-hidden shadow-sm" style="border-radius: 15px;">
                <div class="table-responsive">
                    <table class="table admin-table align-middle m-0">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Teléfono</th>
                                <th>Estado</th>
                                <th>Asistentes</th>
                                <th>Menu / Restricciones</th>
                                <th>Comentarios</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($guests as $guest)
                                <tr>
                                    <td>
                                        <strong>{{ $guest->name }}</strong>
                                        @if($guest->code)
                                            <div class="text-muted small" style="font-size: 0.7rem;">Código: {{ $guest->code }}</div>
                                        @endif
                                    </td>
                                    <td>{{ $guest->phone }}</td>
                                    <td>
                                        @if($guest->is_attending)
                                            <span class="badge bg-success-subtle text-success border border-success border-opacity-25 rounded-pill px-3 py-1">SÍ, asiste</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger border border-danger border-opacity-25 rounded-pill px-3 py-1">NO asiste</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="fw-bold">{{ $guest->is_attending ? $guest->assistants_count : 0 }}</span>
                                    </td>
                                    <td>
                                        @if($guest->dietary_restrictions)
                                            <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill">{{ $guest->dietary_restrictions }}</span>
                                        @else
                                            <span class="text-muted small">Menú estándar</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($guest->comments)
                                            <span class="text-muted small d-inline-block text-truncate" style="max-width: 150px;" title="{{ $guest->comments }}">
                                                {{ $guest->comments }}
                                            </span>
                                        @else
                                            <span class="text-muted small italic">-</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-2">
                                            <button class="btn btn-sm btn-outline-secondary rounded-circle" data-bs-toggle="modal" data-bs-target="#editModal{{ $guest->id }}" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <form action="{{ route('admin.rsvp.destroy', $guest->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este registro de RSVP?');" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Eliminar">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- MODAL EDITAR INVITADO -->
                                <div class="modal fade" id="editModal{{ $guest->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $guest->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content" style="border-radius: 15px;">
                                            <div class="modal-header border-bottom-0 pb-0">
                                                <h5 class="modal-title fw-bold" id="editModalLabel{{ $guest->id }}">Editar Registro RSVP</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('admin.rsvp.update', $guest->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                
                                                <div class="modal-body py-3">
                                                    <div class="row g-3">
                                                        <div class="col-12">
                                                            <label class="form-label fw-semibold small">Nombre y Apellido</label>
                                                            <input type="text" class="form-control" name="name" value="{{ $guest->name }}" required>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label fw-semibold small">Teléfono</label>
                                                            <input type="text" class="form-control" name="phone" value="{{ $guest->phone }}" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-semibold small">¿Asiste?</label>
                                                            <select class="form-select" name="is_attending">
                                                                <option value="1" {{ $guest->is_attending ? 'selected' : '' }}>Asistirá (SÍ)</option>
                                                                <option value="0" {{ !$guest->is_attending ? 'selected' : '' }}>No asistirá (NO)</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-semibold small">Acompañantes</label>
                                                            <input type="number" class="form-control" name="assistants_count" value="{{ $guest->assistants_count }}" min="0" max="20" required>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label fw-semibold small">Menú Especial</label>
                                                            <input type="text" class="form-control" name="dietary_restrictions" value="{{ $guest->dietary_restrictions }}">
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label fw-semibold small">Comentarios</label>
                                                            <textarea class="form-control" name="comments" rows="2">{{ $guest->comments }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-top-0 pt-0">
                                                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-primary rounded-pill px-4" style="background-color: var(--admin-accent-dark); border-color: var(--admin-accent-dark);">Guardar Cambios</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">No se encontraron confirmaciones de asistencia con los filtros aplicados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- ENLACES DE PAGINACIÓN -->
                @if($guests->hasPages())
                    <div class="p-3 bg-light border-top d-flex justify-content-center">
                        {{ $guests->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>

</div>

@endsection

@section('scripts')
<script>
    function copyText(elementId) {
        const copyTextInput = document.getElementById(elementId);
        if (copyTextInput) {
            // Copy using clipboard API
            navigator.clipboard.writeText(copyTextInput.value).then(() => {
                // Show floating alert or toast style
                alert("¡Enlace de invitación copiado al portapapeles!");
            }).catch(err => {
                // Fallback select and copy
                copyTextInput.select();
                copyTextInput.setSelectionRange(0, 99999);
                document.execCommand("copy");
                alert("¡Enlace copiado al portapapeles!");
            });
        }
    }
</script>
@endsection
