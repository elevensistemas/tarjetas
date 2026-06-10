<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Mis 15 Años - Bianca')</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Te invito a celebrar junto a mí una noche inolvidable. Confirma tu asistencia y entérate de todos los detalles de mi fiesta de 15.">
    <meta name="author" content="Bianca">
    
    <!-- Open Graph / Facebook / WhatsApp Preview -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="¡Estás invitado a mis 15 años! - Bianca">
    <meta property="og:description" content="Te invito a celebrar junto a mí una noche mágica. Ingresa para ver los detalles del evento y confirmar tu asistencia.">
    <meta property="og:image" content="{{ $event->hero_image_path ? asset('storage/' . $event->hero_image_path) : asset('images/default_preview.jpg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&family=Bungee&family=Space+Mono:wght@400;700&family=Anton&family=Special+Elite&family=Share+Tech+Mono&family=Syne:wght@700;800&family=Inter:wght@300;400;500;600&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400&family=Cinzel:wght@400;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Great+Vibes&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    
    <!-- Configuración Dinámica de Colores (Inyectada desde Admin) -->
    @php
        $ds = $event->design_settings ?? [];
        $theme = $ds['theme'] ?? 'cyber';
        $primary = $ds['color_primary'] ?? '#F4C2C2';
        $secondary = $ds['color_secondary'] ?? '#D4AF37';
        $bg = $ds['color_bg'] ?? '#FAF7F2';
        $dark = $ds['color_dark'] ?? '#3D3D3D';
        $fontTitle = $ds['typography_title'] ?? 'Playfair Display';
        $fontBody = $ds['typography_body'] ?? 'Montserrat';
    @endphp
    <style>
        :root {
            --color-primary: {{ $primary }};
            --color-primary-rgb: {{ implode(',', hexToRgb($primary)) }};
            --color-secondary: {{ $secondary }};
            --color-secondary-rgb: {{ implode(',', hexToRgb($secondary)) }};
            --color-bg: {{ $bg }};
            --color-dark: {{ $dark }};
            --font-title: '{{ $fontTitle }}', serif;
            --font-body: '{{ $fontBody }}', sans-serif;
        }
    </style>
</head>
<body class="theme-{{ $theme }}">

    @yield('content')

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Custom Scripts -->
    <script src="{{ asset('js/countdown.js') }}"></script>
    <script src="{{ asset('js/audio-player.js') }}"></script>
    
    @yield('scripts')
</body>
</html>

<?php
// Función helper inline para convertir HEX a RGB en el Blade layout
function hexToRgb($hex) {
    $hex = str_replace("#", "", $hex);
    if(strlen($hex) == 3) {
        $r = hexdec(substr($hex,0,1).substr($hex,0,1));
        $g = hexdec(substr($hex,1,1).substr($hex,1,1));
        $b = hexdec(substr($hex,2,1).substr($hex,2,1));
    } else {
        $r = hexdec(substr($hex,0,2));
        $g = hexdec(substr($hex,2,2));
        $b = hexdec(substr($hex,4,2));
    }
    return [$r, $g, $b];
}
?>
