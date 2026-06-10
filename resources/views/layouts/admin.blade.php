<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Panel de Control - Bianca 15</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Custom Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    
    @yield('styles')
</head>
<body class="admin-body">

    <div class="admin-wrapper">
        
        <!-- SIDEBAR -->
        <nav id="sidebar">
            <div class="sidebar-header d-flex align-items-center justify-content-between">
                <span class="fs-4 fw-bold text-white title-font" style="letter-spacing: 1px;">Bianca 15</span>
                <span class="badge bg-secondary">Admin</span>
            </div>

            <ul class="list-unstyled components">
                <li class="{{ Route::is('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="{{ Route::is('admin.settings') ? 'active' : '' }}">
                    <a href="{{ route('admin.settings') }}">
                        <i class="bi bi-sliders"></i> Ajustes del Evento
                    </a>
                </li>
                <li class="{{ Route::is('admin.music') ? 'active' : '' }}">
                    <a href="{{ route('admin.music') }}">
                        <i class="bi bi-music-note-beamed"></i> Música de Fondo
                    </a>
                </li>
                <li class="{{ Route::is('admin.gallery') ? 'active' : '' }}">
                    <a href="{{ route('admin.gallery') }}">
                        <i class="bi bi-images"></i> Galería Oficial
                    </a>
                </li>
                <li class="{{ Route::is('admin.rsvp') ? 'active' : '' }}">
                    <a href="{{ route('admin.rsvp') }}">
                        <i class="bi bi-people-fill"></i> Invitados RSVP
                    </a>
                </li>
                <li class="{{ Route::is('admin.uploaded-photos') ? 'active' : '' }}">
                    <a href="{{ route('admin.uploaded-photos') }}">
                        <i class="bi bi-camera-fill"></i> Fotos Invitados
                        @php
                            $pendingPhotos = \App\Models\UploadedPhoto::where('status', 'pending')->count();
                        @endphp
                        @if($pendingPhotos > 0)
                            <span class="badge bg-danger rounded-pill float-end">{{ $pendingPhotos }}</span>
                        @endif
                    </a>
                </li>
                <li class="{{ Route::is('admin.messages') ? 'active' : '' }}">
                    <a href="{{ route('admin.messages') }}">
                        <i class="bi bi-chat-heart-fill"></i> Libro de Firmas
                        @php
                            $pendingMsgs = \App\Models\GuestMessage::where('status', 'pending')->count();
                        @endphp
                        @if($pendingMsgs > 0)
                            <span class="badge bg-danger rounded-pill float-end">{{ $pendingMsgs }}</span>
                        @endif
                    </a>
                </li>
                <li class="mt-4 border-top border-secondary border-opacity-25 pt-3">
                    <a href="{{ route('invitation') }}" target="_blank">
                        <i class="bi bi-eye-fill"></i> Ver Sitio Público
                    </a>
                </li>
                <li>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-danger">
                        <i class="bi bi-box-arrow-right text-danger"></i> Cerrar Sesión
                    </a>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>

        <!-- CONTENIDO PRINCIPAL -->
        <div id="content">
            
            <!-- Navbar Superior -->
            <nav class="navbar navbar-expand-lg admin-navbar px-3">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-outline-secondary rounded-pill navbar-btn px-3 py-2">
                        <i class="bi bi-justify fs-5"></i>
                    </button>
                    
                    <span class="navbar-text ms-3 fw-medium d-none d-sm-inline-block">
                        Hola, <strong>{{ Auth::user()->name ?? 'Administrador' }}</strong>
                    </span>

                    <div class="ms-auto d-flex align-items-center">
                        <a href="{{ route('invitation') }}" class="btn btn-sm btn-outline-secondary rounded-pill me-2 px-3" target="_blank">
                            <i class="bi bi-box-arrow-up-right me-1"></i>Ver Invitación
                        </a>
                    </div>
                </div>
            </nav>

            <!-- Mensajes de Alerta/Éxito Flash -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 12px;">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 12px;">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>

    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Sidebar Toggler Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const collapseBtn = document.getElementById('sidebarCollapse');
            
            if(collapseBtn && sidebar) {
                collapseBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                });
            }
        });
    </script>
    
    @yield('scripts')
</body>
</html>
