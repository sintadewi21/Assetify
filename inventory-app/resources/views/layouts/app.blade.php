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
        
        <!-- Bootstrap Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

        <!-- Custom Design Tokens (Premium UI/UX System) -->
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
            .text-telkomsel-red {
                color: rgba(178, 86, 159, 1) !important;
            }
            .border-telkomsel {
                border-color: rgba(178, 86, 159, 1) !important;
            }
            /* Premium Buttons (4-Color Sliding Gradient) */
            .btn-telkomsel {
                background: linear-gradient(135deg, rgba(178, 86, 159, 1) 0%, rgba(130, 113, 180, 1) 35%, rgba(87, 169, 216, 1) 70%, rgba(233, 201, 30, 1) 100%) !important;
                background-size: 200% auto !important;
                background-position: left center !important;
                border: none !important;
                color: #ffffff !important;
                font-weight: 600;
                border-radius: 12px;
                padding: 10px 22px;
                transition: all 0.3s ease-in-out;
            }
            .btn-telkomsel:hover, .btn-telkomsel:focus {
                background-position: right center !important;
                color: #ffffff !important;
                transform: translateY(-1.5px);
                box-shadow: 0 5px 15px rgba(130, 113, 180, 0.35) !important;
            }
            .btn-telkomsel:active {
                transform: translateY(0);
            }
            /* Secondary Brand Buttons */
            .btn-brand-secondary {
                background-color: rgba(130, 113, 180, 1) !important;
                border-color: rgba(130, 113, 180, 1) !important;
                color: #ffffff !important;
                font-weight: 600;
                border-radius: 12px;
                transition: all 0.2s ease-in-out;
            }
            .btn-brand-secondary:hover, .btn-brand-secondary:focus {
                background-color: rgba(178, 86, 159, 1) !important;
                border-color: rgba(178, 86, 159, 1) !important;
                color: #ffffff !important;
                box-shadow: 0 4px 12px rgba(178, 86, 159, 0.2) !important;
            }
            /* Responsive Navbar resets */
            @media (min-width: 992px) {
                .navbar-border-lg-none {
                    border-top: 0 !important;
                    padding-top: 0 !important;
                    margin-top: 0 !important;
                }
            }
            /* Input Focus Glows */
            .form-control, .form-select {
                border-radius: 12px !important;
                border: 1px solid var(--bs-border-color);
                padding: 11px 16px;
                transition: all 0.2s ease-in-out;
            }
            .form-control:focus, .form-select:focus {
                border-color: rgba(178, 86, 159, 1) !important;
                box-shadow: 0 0 0 0.25rem rgba(178, 86, 159, 0.15) !important;
            }
            /* Cards Styling */
            .card {
                border-radius: 20px !important;
                border: 1px solid rgba(0, 0, 0, 0.04) !important;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02) !important;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }
            [data-bs-theme="dark"] .card {
                border: 1px solid rgba(255, 255, 255, 0.05) !important;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
            }
            /* Table Styling & Premium Colors */
            .table-responsive {
                border-radius: 16px;
                overflow-x: auto;
            }
            .table-premium {
                border-collapse: separate !important;
                border-spacing: 0 !important;
                width: 100% !important;
            }
            .table-premium thead th {
                background-color: rgba(130, 113, 180, 0.08) !important;
                color: rgba(130, 113, 180, 1) !important;
                font-weight: 700 !important;
                text-transform: uppercase !important;
                letter-spacing: 0.5px !important;
                font-size: 11px !important;
                border-bottom: 2px solid rgba(130, 113, 180, 0.15) !important;
                padding: 14px 16px !important;
            }
            [data-bs-theme="dark"] .table-premium thead th {
                background-color: rgba(130, 113, 180, 0.15) !important;
                color: rgba(160, 150, 210, 1) !important;
                border-bottom: 2px solid rgba(130, 113, 180, 0.3) !important;
            }
            .table-premium tbody tr:nth-of-type(even) {
                background-color: rgba(87, 169, 216, 0.03) !important;
            }
            [data-bs-theme="dark"] .table-premium tbody tr:nth-of-type(even) {
                background-color: rgba(87, 169, 216, 0.05) !important;
            }
            .table-premium tbody tr:hover {
                background-color: rgba(178, 86, 159, 0.06) !important;
                transition: background-color 0.2s ease-in-out !important;
            }
            [data-bs-theme="dark"] .table-premium tbody tr:hover {
                background-color: rgba(178, 86, 159, 0.12) !important;
            }
            .table-premium tbody td {
                padding: 14px 16px !important;
                vertical-align: middle !important;
                border-bottom: 1px solid var(--bs-border-color) !important;
            }
            /* Badges */
            .badge-custom {
                font-weight: 600;
                border-radius: 8px;
                padding: 6px 12px;
                font-size: 11px;
            }
            /* Custom Scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
                height: 8px;
            }
            ::-webkit-scrollbar-track {
                background: transparent;
            }
            ::-webkit-scrollbar-thumb {
                background: var(--bs-border-color-translucent);
                border-radius: 10px;
            }
            ::-webkit-scrollbar-thumb:hover {
                background: var(--bs-secondary-color);
            }
            .text-gradient {
                background: linear-gradient(135deg, rgba(178, 86, 159, 1), rgba(130, 113, 180, 1), rgba(87, 169, 216, 1), rgba(233, 201, 30, 1));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-size: 300% 300%;
                display: inline-block;
            }
            /* Header Style */
            header.page-header {
                background: var(--bs-body-bg) !important;
                border-bottom: 1px solid var(--bs-border-color) !important;
                padding: 22px 0 !important;
                margin-bottom: 24px !important;
                text-align: center !important;
                position: relative;
            }
            [data-bs-theme="dark"] header.page-header {
                background: var(--bs-body-bg) !important;
                border-bottom: 1px solid var(--bs-border-color) !important;
            }
            header.page-header h2 {
                font-size: 24px !important;
                font-weight: 800 !important;
                display: inline-block !important;
                margin: 0 !important;
                background: linear-gradient(135deg, rgba(178, 86, 159, 1), rgba(130, 113, 180, 1), rgba(87, 169, 216, 1), rgba(233, 201, 30, 1)) !important;
                -webkit-background-clip: text !important;
                -webkit-text-fill-color: transparent !important;
                background-size: 300% 300%;
                animation: header-gradient-shift 8s infinite alternate ease-in-out;
            }
            @keyframes header-gradient-shift {
                0% { background-position: 0% 50%; }
                100% { background-position: 100% 50%; }
            }
            header.page-header div.w-100.d-flex {
                justify-content: center !important;
                position: relative;
            }
            header.page-header div.w-100.d-flex a.btn-telkomsel {
                position: absolute;
                right: 0;
            }
            @media (max-width: 576px) {
                header.page-header div.w-100.d-flex {
                    flex-direction: column !important;
                    align-items: center !important;
                    gap: 12px !important;
                }
                header.page-header div.w-100.d-flex a.btn-telkomsel {
                    position: static !important;
                }
            }
        </style>

        <!-- Dark Mode Checker Script (Bootstrap 5 data-bs-theme) -->
        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.setAttribute('data-bs-theme', 'dark');
            } else {
                document.documentElement.setAttribute('data-bs-theme', 'light');
            }
        </script>

        <!-- AlpineJS CDN for reactivity -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="bg-body-secondary min-vh-screen d-flex flex-column">
        
        <!-- Navigation Header -->
        @include('layouts.navigation')

        <!-- Page Heading Header -->
        @isset($header)
            <header class="page-header shadow-sm">
                <div class="container">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Main Content Container -->
        <main class="flex-grow-1 mb-5">
            <div class="container">
                {{ $slot }}
            </div>
        </main>

        <!-- Bootstrap 5 JS Bundle via CDN -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
