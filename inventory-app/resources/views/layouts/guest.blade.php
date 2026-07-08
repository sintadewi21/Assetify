<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'InLife Telkomsel Inventory') }}</title>

        <!-- Fonts (Outfit) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Bootstrap 5 CSS CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

        <style>
            body {
                font-family: 'Outfit', sans-serif !important;
                background-color: #f6f8fb !important;
                background-image: 
                    radial-gradient(at 0% 0%, rgba(178, 86, 159, 0.03) 0px, transparent 50%), 
                    radial-gradient(at 100% 0%, rgba(87, 169, 216, 0.04) 0px, transparent 50%), 
                    radial-gradient(at 100% 100%, rgba(233, 201, 30, 0.02) 0px, transparent 50%) !important;
                background-attachment: fixed;
            }
            [data-bs-theme="dark"] body {
                background-color: #0f1116 !important;
                background-image: 
                    radial-gradient(at 0% 0%, rgba(178, 86, 159, 0.05) 0px, transparent 50%), 
                    radial-gradient(at 100% 0%, rgba(87, 169, 216, 0.06) 0px, transparent 50%), 
                    radial-gradient(at 50% 100%, rgba(130, 113, 180, 0.04) 0px, transparent 50%) !important;
                background-attachment: fixed;
            }
            .bg-telkomsel-red {
                background: linear-gradient(135deg, rgba(178, 86, 159, 1), rgba(130, 113, 180, 1), rgba(87, 169, 216, 1), rgba(233, 201, 30, 1)) !important;
            }
            .btn-telkomsel {
                background: linear-gradient(135deg, rgba(178, 86, 159, 1) 0%, rgba(130, 113, 180, 1) 35%, rgba(87, 169, 216, 1) 70%, rgba(233, 201, 30, 1) 100%) !important;
                background-size: 200% auto !important;
                background-position: left center !important;
                border: none !important;
                color: #ffffff !important;
                font-weight: 750;
                border-radius: 12px;
                transition: all 0.3s ease-in-out;
            }
            .btn-telkomsel:hover, .btn-telkomsel:focus {
                background-position: right center !important;
                color: #ffffff !important;
                box-shadow: 0 5px 15px rgba(130, 113, 180, 0.3) !important;
            }
            .rounded-card {
                border-radius: 20px !important;
            }
        </style>

        <!-- Dark Mode Checker Script -->
        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.setAttribute('data-bs-theme', 'dark');
            } else {
                document.documentElement.setAttribute('data-bs-theme', 'light');
            }
        </script>
    </head>
    <body class="min-vh-100 d-flex flex-column align-items-center justify-content-center py-3 py-sm-5">
        
        <!-- Logo -->
        <div class="mb-4">
            <a href="/" class="d-flex align-items-center text-decoration-none">
                <img src="{{ asset('images/logo.png') }}" alt="Logo InLife" height="45">
            </a>
        </div>

        <!-- Form Card Container -->
        <div class="container d-flex justify-content-center px-2 px-sm-3">
            <div class="card rounded-card shadow border-0 p-3 p-sm-4 p-md-5 w-100" style="max-width: 480px;">
                {{ $slot }}
            </div>
        </div>

        <!-- Bootstrap 5 JS Bundle CDN -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
