<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Administrador Bianca 15</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <style>
        body {
            background-color: #FAF7F2;
            font-family: 'Inter', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
            background: #ffffff;
            width: 100%;
            max-width: 420px;
            overflow: hidden;
        }

        .login-header {
            background-color: #f4c2c2;
            padding: 35px 20px;
            text-align: center;
            color: #ffffff;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .login-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }

        .login-subtitle {
            font-size: 0.9rem;
            opacity: 0.9;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .btn-login {
            background-color: #d4af37;
            border: none;
            color: white;
            font-weight: 600;
            padding: 12px;
            border-radius: 12px;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background-color: #c49e27;
            transform: translateY(-1px);
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
            border: 1px solid #e1e3ea;
        }

        .form-control:focus {
            border-color: #d4af37;
            box-shadow: 0 0 8px rgba(212, 175, 55, 0.2);
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <h1 class="login-title">Bianca</h1>
            <p class="login-subtitle">Panel de Control</p>
        </div>
        
        <div class="card-body p-4 p-sm-5">
            <!-- Mensaje de éxito/alerta general -->
            @if(session('success'))
                <div class="alert alert-success border-0 small mb-4 py-2 text-center" style="border-radius: 10px;">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf
                
                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label small fw-semibold text-muted text-uppercase mb-1">Correo Electrónico</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="correo@ejemplo.com">
                    @error('email')
                        <div class="invalid-feedback small">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="form-label small fw-semibold text-muted text-uppercase mb-1">Contraseña</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required placeholder="••••••••">
                    @error('password')
                        <div class="invalid-feedback small">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Recordarme -->
                <div class="mb-4 form-check d-flex align-items-center">
                    <input type="checkbox" class="form-check-input mt-0" id="remember" name="remember">
                    <label class="form-check-label text-muted small ms-2" for="remember">Recordar mi sesión</label>
                </div>
                
                <!-- Botón Login -->
                <button type="submit" class="btn btn-login w-100 mb-2">Ingresar al Panel</button>
                
                <div class="text-center mt-3">
                    <a href="{{ route('invitation') }}" class="text-decoration-none small text-muted">
                        ← Volver al sitio público
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
