@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    
    <!-- Encabezado de la página -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 title-font">Resumen del Evento</h1>
        <span class="text-muted small">Estado actual al {{ now()->format('d/m/Y H:i') }}</span>
    </div>

    <!-- TARJETAS DE MÉTRICAS -->
    <div class="row g-4 mb-4">
        
        <!-- Total RSVP Confirmados -->
        <div class="col-xl-3 col-md-6">
            <div class="metric-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="metric-value">{{ $confirmedCount }}</div>
                        <div class="metric-title">Invitaciones SÍ</div>
                    </div>
                    <div class="icon-box bg-success-subtle text-success">
                        <i class="bi bi-calendar-check-fill"></i>
                    </div>
                </div>
                <div class="text-muted small mt-2">
                    Confirmaciones individuales positivas
                </div>
            </div>
        </div>

        <!-- Total de Asistentes Reales -->
        <div class="col-xl-3 col-md-6">
            <div class="metric-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="metric-value">{{ $totalAssistants }}</div>
                        <div class="metric-title">Invitados Totales</div>
                    </div>
                    <div class="icon-box bg-primary-subtle text-primary">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
                <div class="text-muted small mt-2">
                    Personas reales que asistirán
                </div>
            </div>
        </div>

        <!-- Confirmados No Asisten -->
        <div class="col-xl-3 col-md-6">
            <div class="metric-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="metric-value">{{ $notAttendingCount }}</div>
                        <div class="metric-title">Invitaciones NO</div>
                    </div>
                    <div class="icon-box bg-danger-subtle text-danger">
                        <i class="bi bi-calendar-x-fill"></i>
                    </div>
                </div>
                <div class="text-muted small mt-2">
                    Confirmados que no asistirán
                </div>
            </div>
        </div>

        <!-- Moderaciones Pendientes -->
        <div class="col-xl-3 col-md-6">
            <div class="metric-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="metric-value">{{ $pendingPhotosCount + $pendingMessagesCount }}</div>
                        <div class="metric-title">Pendientes</div>
                    </div>
                    <div class="icon-box bg-warning-subtle text-warning">
                        <i class="bi bi-shield-exclamation"></i>
                    </div>
                </div>
                <div class="text-muted small mt-2">
                    {{ $pendingPhotosCount }} fotos y {{ $pendingMessagesCount }} dedicatorias
                </div>
            </div>
        </div>

    </div>

    <!-- SECCIÓN INTERACTIVA PRINCIPAL CON SIMULADOR CELULAR -->
    <div class="row g-4">
        
        <!-- CONTENIDO DE GESTIÓN (Izquierda) -->
        <div class="col-xl-8 col-lg-7">
            <div class="row g-4">
                
                <!-- Últimas Confirmaciones RSVP -->
                <div class="col-12">
                    <div class="admin-card shadow-sm">
                        <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                            <h5 class="card-title m-0 border-0 p-0">Últimos Invitados Confirmados</h5>
                            <a href="{{ route('admin.rsvp') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Ver Todos</a>
                        </div>

                        <div class="table-responsive">
                            <table class="table admin-table align-middle">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Teléfono</th>
                                        <th>Estado</th>
                                        <th>Asistentes</th>
                                        <th>Registro</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentRsvps as $guest)
                                        <tr>
                                            <td><strong>{{ $guest->name }}</strong></td>
                                            <td>{{ $guest->phone }}</td>
                                            <td>
                                                @if($guest->is_attending)
                                                    <span class="badge bg-success-subtle text-success border border-success border-opacity-25 rounded-pill px-3 py-1">Asiste</span>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger border border-danger border-opacity-25 rounded-pill px-3 py-1">No Asiste</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="fw-bold">{{ $guest->is_attending ? $guest->assistants_count : 0 }}</span>
                                            </td>
                                            <td class="text-muted small">{{ $guest->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">Ningún invitado ha confirmado asistencia todavía.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta de Acciones Rápidas / Moderaciones -->
                <div class="col-12">
                    <div class="admin-card shadow-sm">
                        <h5 class="card-title m-0 border-0 pb-3 mb-3 border-bottom">Acciones de Moderación</h5>
                        
                        <div class="row g-3">
                            
                            <!-- Moderación de Fotos -->
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 d-flex align-items-center justify-content-between h-100 {{ $pendingPhotosCount > 0 ? 'bg-danger-subtle border-danger border-opacity-25' : 'bg-light' }}">
                                    <div>
                                        <h6 class="fw-bold mb-1" style="color: #2b2b40;">Fotos de Invitados</h6>
                                        <p class="small text-muted mb-0">{{ $pendingPhotosCount }} fotos pendientes de aprobación</p>
                                    </div>
                                    <a href="{{ route('admin.uploaded-photos') }}" class="btn btn-sm {{ $pendingPhotosCount > 0 ? 'btn-danger' : 'btn-outline-secondary' }} rounded-pill px-3">
                                        Moderar
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Moderación de Mensajes -->
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 d-flex align-items-center justify-content-between h-100 {{ $pendingMessagesCount > 0 ? 'bg-danger-subtle border-danger border-opacity-25' : 'bg-light' }}">
                                    <div>
                                        <h6 class="fw-bold mb-1" style="color: #2b2b40;">Dedicatorias Libro</h6>
                                        <p class="small text-muted mb-0">{{ $pendingMessagesCount }} mensajes por autorizar</p>
                                    </div>
                                    <a href="{{ route('admin.messages') }}" class="btn btn-sm {{ $pendingMessagesCount > 0 ? 'btn-danger' : 'btn-outline-secondary' }} rounded-pill px-3">
                                        Moderar
                                    </a>
                                </div>
                            </div>

                            <!-- Música de Fondo -->
                            <div class="col-12">
                                <div class="p-3 border bg-light rounded-3 d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="icon-box bg-dark text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="bi bi-music-note-beamed"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1" style="color: #2b2b40; margin-bottom: 2px;">Música de Fondo Activa</h6>
                                            <p class="small text-muted mb-0">Gestiona la carga de archivos de música MP3 para la ambientación general</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('admin.music') }}" class="btn btn-sm btn-outline-dark rounded-pill px-4">
                                        Configurar MP3
                                    </a>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- SIMULADOR CELULAR EN VIVO (Derecha - Sticky) -->
        <div class="col-xl-4 col-lg-5">
            <div class="admin-card text-center d-flex flex-column align-items-center position-sticky shadow-sm" style="top: 30px; z-index: 10;">
                <h5 class="card-title w-100 text-start border-0 pb-3 mb-3 border-bottom">Vista Celular en Vivo</h5>
                
                <div class="phone-preview-container">
                    <!-- Streaming Live Indicator Badge -->
                    <div class="stream-badge">
                        <span class="stream-pulse-dot"></span>
                        Transmitiendo Web
                    </div>
                    
                    <!-- Smartphone Chassis Mock -->
                    <div class="smartphone-frame shadow">
                        <!-- Dynamic Notch -->
                        <div class="smartphone-notch">
                            <span class="smartphone-camera"></span>
                            <span class="smartphone-speaker"></span>
                        </div>
                        
                        <!-- Screen area -->
                        <div class="smartphone-screen">
                            <div class="smartphone-glass-glare"></div>
                            <!-- Loaded with absolute URL for exact local live preview -->
                            <iframe id="phone-iframe" src="{{ url('/') }}" class="smartphone-iframe"></iframe>
                        </div>
                    </div>
                    
                    <!-- Real-time Controls -->
                    <div class="phone-controls">
                        <button onclick="document.getElementById('phone-iframe').contentWindow.location.reload();" class="btn btn-sm btn-dark btn-phone-action rounded-pill px-3 shadow-sm border border-secondary">
                            <i class="bi bi-arrow-clockwise me-1 text-success"></i> Recargar
                        </button>
                        <a href="{{ url('/') }}" target="_blank" class="btn btn-sm btn-outline-secondary btn-phone-action rounded-pill px-3 shadow-sm">
                            <i class="bi bi-box-arrow-up-right me-1"></i> Pantalla Completa
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    </div>

</div>
@endsection
