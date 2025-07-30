<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Connexion - SAFIR Administration')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            background: linear-gradient(120deg, #C41E3A 0%, #E67E22 40%, #F39C12 100%);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }
        
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        
        .auth-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 400px;
            width: 100%;
        }
        
        .auth-header {
            background: linear-gradient(135deg, #C41E3A 0%, #E67E22 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .auth-logo {
            font-size: 2.5rem;
            font-weight: 900;
            margin-bottom: 0.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .auth-subtitle {
            opacity: 0.9;
            font-size: 0.95rem;
        }
        
        .auth-body {
            padding: 2rem;
        }
        
        .form-control {
            border: 2px solid #f1f3f4;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #C41E3A;
            box-shadow: 0 0 0 0.2rem rgba(196, 30, 58, 0.15);
        }
        
        .btn-auth {
            background: linear-gradient(135deg, #C41E3A 0%, #E67E22 100%);
            border: none;
            border-radius: 12px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
        }
        
        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(196, 30, 58, 0.3);
            color: white;
        }
        
        .form-check-input:checked {
            background-color: #C41E3A;
            border-color: #C41E3A;
        }
        
        .auth-link {
            color: #C41E3A;
            text-decoration: none;
            font-weight: 500;
        }
        
        .auth-link:hover {
            color: #E67E22;
            text-decoration: underline;
        }
        
        .alert {
            border-radius: 12px;
            border: none;
        }
        
        .auth-footer {
            text-align: center;
            padding: 1rem 2rem 2rem;
            color: #6c757d;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-logo">SAFIR</div>
                <div class="auth-subtitle">Administration</div>
            </div>
            
            <div class="auth-body">
                {{ $slot }}
            </div>
            
            <div class="auth-footer">
                <a href="{{ route('home') }}" class="auth-link">
                    <i class="bi bi-arrow-left me-1"></i>Retour au site
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
