<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>InLife Assetify - Inventory Management System</title>
    
    <!-- Fonts (Outfit) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --color-orchid: rgba(178, 86, 159, 1);
            --color-slate: rgba(130, 113, 180, 1);
            --color-skyblue: rgba(87, 169, 216, 1);
            --color-gold: rgba(233, 201, 30, 1);
        }

        body {
            font-family: 'Outfit', sans-serif !important;
            background: 
                radial-gradient(at 0% 0%, rgba(178, 86, 159, 0.08) 0px, transparent 50%), 
                radial-gradient(at 100% 0%, rgba(87, 169, 216, 0.09) 0px, transparent 50%), 
                radial-gradient(at 50% 50%, rgba(233, 201, 30, 0.06) 0px, transparent 50%), 
                #f1f5f9 !important;
            color: #1e293b !important;
            position: relative;
            overflow-x: hidden;
            transition: background-color 0.4s ease, color 0.4s ease;
        }

        [data-bs-theme="dark"] body {
            background: 
                radial-gradient(at 0% 0%, rgba(178, 86, 159, 0.16) 0px, transparent 50%), 
                radial-gradient(at 100% 0%, rgba(87, 169, 216, 0.18) 0px, transparent 50%), 
                radial-gradient(at 50% 50%, rgba(130, 113, 180, 0.12) 0px, transparent 50%), 
                #0d1117 !important;
            color: #f8fafc !important;
        }

        /* Ambient Animated Blobs */
        .ambient-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.45;
            z-index: -1;
            pointer-events: none;
            transition: all 0.5s ease;
        }

        [data-bs-theme="dark"] .ambient-blob {
            opacity: 0.35;
        }

        .blob-1 {
            width: 400px;
            height: 400px;
            background-color: var(--color-orchid);
            top: -100px;
            left: 10%;
            animation: float-blob-1 12s infinite alternate ease-in-out;
        }

        .blob-2 {
            width: 450px;
            height: 450px;
            background-color: var(--color-skyblue);
            top: 20%;
            right: 10%;
            animation: float-blob-2 15s infinite alternate ease-in-out;
        }

        .blob-3 {
            width: 350px;
            height: 350px;
            background-color: var(--color-gold);
            bottom: -50px;
            left: 40%;
            animation: float-blob-3 10s infinite alternate ease-in-out;
        }

        @keyframes float-blob-1 {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(40px, 60px) scale(1.15); }
        }

        @keyframes float-blob-2 {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(-60px, -40px) scale(0.9); }
        }

        @keyframes float-blob-3 {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(30px, -30px) scale(1.2); }
        }

        /* Glassmorphic Navbar */
        .navbar-glass {
            backdrop-filter: blur(12px);
            background-color: rgba(255, 255, 255, 0.7) !important;
            transition: all 0.3s ease;
        }

        [data-bs-theme="dark"] .navbar-glass {
            background-color: rgba(11, 13, 16, 0.7) !important;
            border-bottom-color: rgba(255, 255, 255, 0.05) !important;
        }

        /* Gradients & Text */
        .bg-telkomsel-red {
            background: linear-gradient(135deg, var(--color-orchid), var(--color-slate), var(--color-skyblue), var(--color-gold)) !important;
        }

        .text-gradient {
            background: linear-gradient(135deg, var(--color-orchid), var(--color-slate), var(--color-skyblue), var(--color-gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-size: 300% 300%;
            animation: gradient-shift 6s infinite alternate;
        }

        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            100% { background-position: 100% 50%; }
        }

        /* Premium Buttons */
        .btn-telkomsel {
            background: linear-gradient(135deg, var(--color-orchid) 0%, var(--color-slate) 35%, var(--color-skyblue) 70%, var(--color-gold) 100%) !important;
            background-size: 200% auto !important;
            background-position: left center !important;
            border: none !important;
            color: #ffffff !important;
            font-weight: 600;
            border-radius: 14px;
            transition: all 0.3s ease-in-out;
        }

        .btn-telkomsel:hover {
            background-position: right center !important;
            color: #ffffff !important;
            box-shadow: 0 8px 20px rgba(130, 113, 180, 0.4) !important;
            transform: translateY(-2px);
        }

        .btn-outline-custom {
            border: 2px solid var(--color-slate) !important;
            color: var(--color-slate) !important;
            font-weight: 600;
            border-radius: 14px;
            transition: all 0.3s ease-in-out;
        }

        .btn-outline-custom:hover {
            background-color: var(--color-slate) !important;
            color: #ffffff !important;
            transform: translateY(-2px);
        }

        /* Glass Cards */
        .glass-card {
            background: rgba(255, 255, 255, 0.6) !important;
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.5) !important;
            border-radius: 24px !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03) !important;
            transition: all 0.3s ease;
        }

        [data-bs-theme="dark"] .glass-card {
            background: rgba(20, 24, 33, 0.6) !important;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2) !important;
        }

        .glass-card:hover {
            transform: translateY(-8px) !important;
        }

        /* Color-coded Card styling (non-white colored gradients) */
        .card-orchid {
            background: linear-gradient(135deg, var(--color-orchid), rgba(178, 86, 159, 0.85)) !important;
            border: 1px solid var(--color-orchid) !important;
            color: #ffffff !important;
        }
        .card-orchid:hover {
            background: linear-gradient(135deg, rgba(178, 86, 159, 0.95), rgba(178, 86, 159, 0.75)) !important;
            box-shadow: 0 20px 40px rgba(178, 86, 159, 0.4) !important;
        }
        .card-orchid .text-gradient {
            -webkit-text-fill-color: #ffffff !important;
        }
        .card-orchid .text-secondary {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        .card-orchid .text-body {
            color: #ffffff !important;
        }
        .card-orchid .rounded-3 {
            background-color: rgba(255, 255, 255, 0.2) !important;
            color: #ffffff !important;
        }
        [data-bs-theme="dark"] .card-orchid {
            background: linear-gradient(135deg, var(--color-orchid), rgba(178, 86, 159, 0.85)) !important;
            border: 1px solid var(--color-orchid) !important;
        }
        
        .card-slate {
            background: linear-gradient(135deg, var(--color-slate), rgba(130, 113, 180, 0.85)) !important;
            border: 1px solid var(--color-slate) !important;
            color: #ffffff !important;
        }
        .card-slate:hover {
            background: linear-gradient(135deg, rgba(130, 113, 180, 0.95), rgba(130, 113, 180, 0.75)) !important;
            box-shadow: 0 20px 40px rgba(130, 113, 180, 0.4) !important;
        }
        .card-slate .text-gradient {
            -webkit-text-fill-color: #ffffff !important;
        }
        .card-slate .text-secondary {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        .card-slate .text-body {
            color: #ffffff !important;
        }
        .card-slate .rounded-3 {
            background-color: rgba(255, 255, 255, 0.2) !important;
            color: #ffffff !important;
        }
        [data-bs-theme="dark"] .card-slate {
            background: linear-gradient(135deg, var(--color-slate), rgba(130, 113, 180, 0.85)) !important;
            border: 1px solid var(--color-slate) !important;
        }
        
        .card-skyblue {
            background: linear-gradient(135deg, var(--color-skyblue), rgba(87, 169, 216, 0.85)) !important;
            border: 1px solid var(--color-skyblue) !important;
            color: #ffffff !important;
        }
        .card-skyblue:hover {
            background: linear-gradient(135deg, rgba(87, 169, 216, 0.95), rgba(87, 169, 216, 0.75)) !important;
            box-shadow: 0 20px 40px rgba(87, 169, 216, 0.4) !important;
        }
        .card-skyblue .text-gradient {
            -webkit-text-fill-color: #ffffff !important;
        }
        .card-skyblue .text-secondary {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        .card-skyblue .text-body {
            color: #ffffff !important;
        }
        .card-skyblue .rounded-3 {
            background-color: rgba(255, 255, 255, 0.2) !important;
            color: #ffffff !important;
        }
        [data-bs-theme="dark"] .card-skyblue {
            background: linear-gradient(135deg, var(--color-skyblue), rgba(87, 169, 216, 0.85)) !important;
            border: 1px solid var(--color-skyblue) !important;
        }
        
        .card-gold {
            background: linear-gradient(135deg, var(--color-gold), rgba(233, 201, 30, 0.85)) !important;
            border: 1px solid var(--color-gold) !important;
            color: #1e293b !important;
        }
        .card-gold:hover {
            background: linear-gradient(135deg, rgba(233, 201, 30, 0.95), rgba(233, 201, 30, 0.75)) !important;
            box-shadow: 0 20px 40px rgba(233, 201, 30, 0.4) !important;
        }
        .card-gold .text-gradient {
            -webkit-text-fill-color: #1e293b !important;
        }
        .card-gold .text-secondary {
            color: rgba(30, 41, 59, 0.8) !important;
        }
        .card-gold .text-body {
            color: #1e293b !important;
        }
        .card-gold .rounded-3 {
            background-color: rgba(30, 41, 59, 0.1) !important;
            color: #1e293b !important;
        }
        [data-bs-theme="dark"] .card-gold {
            background: linear-gradient(135deg, var(--color-gold), rgba(233, 201, 30, 0.85)) !important;
            border: 1px solid var(--color-gold) !important;
        }

        /* Quick Asset Availability Checker style */
        .checker-results {
            max-height: 180px;
            overflow-y: auto;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(0,0,0,0.06);
        }
        [data-bs-theme="dark"] .checker-results {
            background: rgba(15, 17, 22, 0.9);
            border-color: rgba(255,255,255,0.08);
        }

        /* Splash Screen / Preloader Animations */
        #preloader {
            position: fixed;
            inset: 0;
            z-index: 99999;
            background: linear-gradient(-45deg, rgba(178, 86, 159, 0.92), rgba(130, 113, 180, 0.92), rgba(87, 169, 216, 0.92), rgba(233, 201, 30, 0.92));
            background-size: 400% 400%;
            animation: fluidGradient 6s ease infinite;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            width: 100vw;
            height: 100vh;
        }

        @keyframes fluidGradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .preloader-logo-wrapper {
            perspective: 1000px;
        }
        .preloader-logo {
            animation: logoSlideFlip 2.5s cubic-bezier(0.25, 1, 0.5, 1) forwards;
            opacity: 0;
        }
        .preloader-text {
            animation: fadeInText 1.2s cubic-bezier(0.25, 1, 0.5, 1) forwards;
            animation-delay: 1.5s;
            opacity: 0;
        }

        @keyframes logoSlideFlip {
            0% {
                transform: translateY(60px) rotateY(0deg) scale(0.6);
                opacity: 0;
            }
            30% {
                transform: translateY(0) rotateY(0deg) scale(1.1);
                opacity: 1;
            }
            60% {
                transform: translateY(0) rotateY(360deg) scale(1.0);
                opacity: 1;
            }
            80% {
                transform: translateY(0) rotateY(180deg) scale(1.05);
                opacity: 1;
            }
            100% {
                transform: translateY(0) rotateY(0deg) scale(1.0);
                opacity: 1;
            }
        }

        @keyframes fadeInText {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    
    <script>
        // Init dark mode state
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.setAttribute('data-bs-theme', 'dark');
        } else {
            document.documentElement.setAttribute('data-bs-theme', 'light');
        }
    </script>
</head>
<body class="min-vh-screen d-flex flex-column justify-content-between" style="overflow: hidden;">

    <!-- Splash Screen / Preloader -->
    <div id="preloader">
        <div class="text-center d-flex flex-column align-items-center">
            <!-- Logo with 3D Flip & Slide Up Animation -->
            <div class="preloader-logo-wrapper mb-4">
                <img src="{{ asset('images/icon.png') }}" alt="Icon InLife" style="height: 220px; opacity: 1;" class="preloader-logo">
            </div>
            <!-- Descriptions (Fade In with 1.5s delay) -->
            <div class="preloader-text mt-3 text-white">
                <p class="text-uppercase fw-bold text-white mb-1" style="font-size: 1.2rem; letter-spacing: 4px; opacity: 0.9; text-shadow: 0 2px 4px rgba(0,0,0,0.15);">Welcome To</p>
                <h1 class="fw-extrabold mb-2" style="letter-spacing: -2px; font-weight: 900; font-size: 5.5rem; text-shadow: 0 4px 15px rgba(0,0,0,0.25);">Assetify</h1>
                <p class="mb-0 text-white" style="font-size: 24px; letter-spacing: 0.5px; font-weight: 400; text-shadow: 0 2px 8px rgba(0,0,0,0.2);">Manage your inventory with assetify</p>
            </div>
        </div>
    </div>

    <!-- Ambient Blobs -->
    <div class="ambient-blob blob-1"></div>
    <div class="ambient-blob blob-2"></div>
    <div class="ambient-blob blob-3"></div>
    
    <!-- Header -->
    <header class="navbar navbar-expand-lg navbar-glass sticky-top py-3 border-bottom shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand d-flex align-items-center text-decoration-none" href="#">
                <img src="{{ asset('images/logo.png') }}" alt="Logo InLife" height="35">
            </a>
            
            <nav class="d-flex align-items-center gap-3">
                <!-- Theme Switcher -->
                <button onclick="toggleDarkModeWelcome()" class="btn btn-outline-secondary border-0 rounded-circle p-2 d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px;" title="Toggle Dark/Light Mode">
                    <i id="welcome-theme-toggle-dark-icon" class="bi bi-sun-fill text-warning d-none" style="font-size: 18px;"></i>
                    <i id="welcome-theme-toggle-light-icon" class="bi bi-moon-stars-fill d-none" style="font-size: 18px;"></i>
                </button>

                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-telkomsel px-4 shadow-sm text-sm">
                            Enter Dashboard <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-link text-decoration-none text-body fw-bold">
                            Login
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-dark fw-bold px-3" style="border-radius: 10px;">
                                Register
                            </a>
                        @endif
                    @endauth
                @endif
            </nav>
        </div>
    </header>

    <!-- Main Hero Section (Centered Layout) -->
    <main class="container d-flex flex-column justify-content-center align-items-center position-relative" style="min-height: calc(100vh - 80px);">
        <div class="row justify-content-center text-center">
            <div class="col-12 col-xl-10 d-flex flex-column align-items-center">
                
                <span class="badge bg-opacity-10 text-danger border px-3 py-2 uppercase tracking-wider fw-bold mb-3 d-inline-flex align-items-center gap-2" style="font-size: 11px; border-radius: 8px; background-color: rgba(178, 86, 159, 0.1); color: rgba(178, 86, 159, 1) !important; border-color: rgba(178, 86, 159, 0.2) !important;">
                    ASSETIFY
                </span>
                
                <h1 class="fw-black text-body mb-4 leading-tight" style="font-weight: 950; letter-spacing: -2px; font-size: calc(1.8rem + 3vw);">
                    <span class="text-nowrap"> Optimize Office Assets</span><br>
                    <span class="text-nowrap">With <span class="text-gradient">InLife Assetify</span></span>
                </h1>
                
                <p class="lead text-secondary mb-5 fw-light" style="font-size: 18px; max-width: 700px;">
                    InLife Assetify is a next-generation platform designed to track item circulation, manage stock levels, prevent asset displacement, and process loan requests instantly and securely.
                </p>

                <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                    <a href="{{ route('login') }}" class="btn btn-telkomsel btn-lg px-5 py-3 shadow">
                        Get Started <i class="bi bi-rocket-takeoff ms-1"></i>
                    </a>
                    <button type="button" class="btn btn-outline-custom btn-lg px-5 py-3" data-bs-toggle="modal" data-bs-target="#featuresModal">
                        Learn Features
                    </button>
                </div>
                
            </div>
        </div>
    </main>

    <!-- Demo Account Guide Section -->
    <section class="border-top py-5 transition-all bg-body-tertiary">
        <div class="container py-4">
            <div class="card glass-card p-4 p-md-5 border-0 shadow-sm mx-auto" style="max-width: 800px;">
                <div class="text-center mb-4">
                    <span class="badge bg-opacity-10 text-danger border px-3 py-2 uppercase tracking-wider fw-bold mb-3 d-inline-flex align-items-center gap-2" style="font-size: 11px; border-radius: 8px; background-color: rgba(178, 86, 159, 0.1); color: rgba(178, 86, 159, 1) !important; border-color: rgba(178, 86, 159, 0.2) !important;">
                        <i class="bi bi-info-circle"></i> DEMO ACCOUNT GUIDE
                    </span>
                    <h3 class="fw-extrabold text-body mb-3">Demonstration Account System</h3>
                    <p class="text-secondary small mb-0" style="font-size: 14px; line-height: 1.6;">
                        For security and evaluation purposes, the self-registration process is restricted to the Staff role. If you want to log in and test the system as an Admin or a Manager, you can log in directly using the following pre-configured demonstration accounts:
                    </p>
                </div>
                
                <div class="row g-3 justify-content-center text-start">
                    <div class="col-sm-6">
                        <div class="p-3 bg-body rounded-4 border border-light-subtle shadow-sm h-100">
                            <h6 class="fw-bold text-gradient mb-2"><i class="bi bi-shield-lock me-1"></i> Admin Account</h6>
                            <p class="mb-1 small text-body-emphasis"><strong>Email:</strong> admin1@gmail.com</p>
                            <p class="mb-0 small text-body-emphasis"><strong>Password:</strong> admin123</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 bg-body rounded-4 border border-light-subtle shadow-sm h-100">
                            <h6 class="fw-bold text-gradient mb-2"><i class="bi bi-person-badge me-1"></i> Manager Account</h6>
                            <p class="mb-1 small text-body-emphasis"><strong>Email:</strong> manager@gmail.com</p>
                            <p class="mb-0 small text-body-emphasis"><strong>Password:</strong> manager123</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="border-top py-5 transition-all bg-body">
        <div class="container py-4">
            <div class="text-center mx-auto mb-5" style="max-width: 600px;">
                <h2 class="fw-extrabold text-body uppercase tracking-wider mb-2">Asset Statistics</h2>
                <p class="text-secondary small">Real-time counts of products and categories managed within InLife Assetify.</p>
            </div>
            
            <div class="row g-4 justify-content-center text-center">
                <div class="col-md-6 col-lg-3">
                    <div class="card glass-card p-4 h-100 shadow-sm border card-orchid">
                        <div class="rounded-3 d-flex align-items-center justify-content-center mb-3 mx-auto" style="width: 44px; height: 44px; background-color: rgba(178, 86, 159, 0.1); color: rgba(178, 86, 159, 1);">
                           <i class="bi bi-boxes" style="font-size: 22px;"></i>
                        </div>
                        <h3 class="fw-extrabold text-gradient mb-1" style="font-size: 2.5rem;">{{ \App\Models\Product::count() }}</h3>
                        <p class="text-secondary mb-0 small fw-bold">Total Products</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card glass-card p-4 h-100 shadow-sm border card-slate">
                        <div class="rounded-3 d-flex align-items-center justify-content-center mb-3 mx-auto" style="width: 44px; height: 44px; background-color: rgba(130, 113, 180, 0.1); color: rgba(130, 113, 180, 1);">
                           <i class="bi bi-tags" style="font-size: 22px;"></i>
                        </div>
                        <h3 class="fw-extrabold text-gradient mb-1" style="font-size: 2.5rem;">{{ \App\Models\Category::count() }}</h3>
                        <p class="text-secondary mb-0 small fw-bold">Main Categories</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card glass-card p-4 h-100 shadow-sm border card-skyblue">
                        <div class="rounded-3 d-flex align-items-center justify-content-center mb-3 mx-auto" style="width: 44px; height: 44px; background-color: rgba(87, 169, 216, 0.15); color: rgba(87, 169, 216, 1);">
                           <i class="bi bi-box-seam" style="font-size: 22px;"></i>
                        </div>
                        <h3 class="fw-extrabold text-gradient mb-1" style="font-size: 2.5rem;">{{ \App\Models\Product::sum('stock') }}</h3>
                        <p class="text-secondary mb-0 small fw-bold">Total Physical Stock</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Feature Capabilities Section -->
    <section id="fitur" class="border-top py-5 transition-all bg-body-tertiary">
        <div class="container py-4">
            <div class="text-center mx-auto mb-5" style="max-width: 600px;">
                <h2 class="fw-extrabold text-body uppercase tracking-wider mb-2">Why Choose Assetify?</h2>
                <p class="text-secondary small">A smart solution to avoid conventional inventory asset registration issues.</p>
            </div>

            <div class="row g-4">
                <!-- Feature 1: No Data Loss -->
                <div class="col-md-6 col-lg-3">
                    <div class="card glass-card p-4 h-100 shadow-sm border card-orchid">
                        <div class="rounded-3 d-flex align-items-center justify-content-center mb-3" style="width: 44px; height: 44px; background-color: rgba(178, 86, 159, 0.1); color: rgba(178, 86, 159, 1);">
                            <i class="bi bi-shield-check" style="font-size: 22px;"></i>
                        </div>
                        <h5 class="fw-bold text-body mb-2" style="font-size: 15px;">Secure & Guaranteed</h5>
                        <p class="text-secondary small mb-0 lh-base">Office asset data loss is prevented with secure, encrypted centralized database storage.</p>
                    </div>
                </div>

                <!-- Feature 2: No Duplicate Records -->
                <div class="col-md-6 col-lg-3">
                    <div class="card glass-card p-4 h-100 shadow-sm border card-slate">
                        <div class="rounded-3 d-flex align-items-center justify-content-center mb-3" style="width: 44px; height: 44px; background-color: rgba(130, 113, 180, 0.1); color: rgba(130, 113, 180, 1);">
                            <i class="bi bi-fingerprint" style="font-size: 22px;"></i>
                        </div>
                        <h5 class="fw-bold text-body mb-2" style="font-size: 15px;">No Duplication</h5>
                        <p class="text-secondary small mb-0 lh-base">Every item has its own unique code to guarantee accurate registration data.</p>
                    </div>
                </div>

                <!-- Feature 3: Real-Time Stock Tracking -->
                <div class="col-md-6 col-lg-3">
                    <div class="card glass-card p-4 h-100 shadow-sm border card-skyblue">
                        <div class="rounded-3 d-flex align-items-center justify-content-center mb-3" style="width: 44px; height: 44px; background-color: rgba(87, 169, 216, 0.15); color: rgba(87, 169, 216, 1);">
                            <i class="bi bi-eye" style="font-size: 22px;"></i>
                        </div>
                        <h5 class="fw-bold text-body mb-2" style="font-size: 15px;">Stock Monitoring</h5>
                        <p class="text-secondary small mb-0 lh-base">View product stock in real-time and receive instant notifications if stock levels become critical.</p>
                    </div>
                </div>

                <!-- Feature 4: Fast Reports -->
                <div class="col-md-6 col-lg-3">
                    <div class="card glass-card p-4 h-100 shadow-sm border card-gold">
                        <div class="rounded-3 d-flex align-items-center justify-content-center mb-3" style="width: 44px; height: 44px; background-color: rgba(233, 201, 30, 0.18); color: rgba(200, 170, 20, 1);">
                            <i class="bi bi-file-earmark-bar-graph" style="font-size: 22px;"></i>
                        </div>
                        <h5 class="fw-bold text-body mb-2" style="font-size: 15px;">Instant Reports</h5>
                        <p class="text-secondary small mb-0 lh-base">Export asset loan logs to Excel (CSV) or print PDF files in just a few seconds.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center py-4 text-secondary border-top small mt-5 transition-all" style="background: linear-gradient(90deg, rgba(178, 86, 159, 0.04), rgba(130, 113, 180, 0.04), rgba(87, 169, 216, 0.04), rgba(233, 201, 30, 0.04)) !important;">
        <p class="mb-0">© 2026 InLife Assetify. All Rights Reserved. Information Systems Internship Project.</p>
    </footer>>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Welcome theme switch and dynamic script -->
    <script>
        const welcomeDarkIcon = document.getElementById('welcome-theme-toggle-dark-icon');
        const welcomeLightIcon = document.getElementById('welcome-theme-toggle-light-icon');

        function updateWelcomeThemeIcons() {
            const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
            if (isDark) {
                welcomeDarkIcon.classList.remove('d-none');
                welcomeLightIcon.classList.add('d-none');
            } else {
                welcomeLightIcon.classList.remove('d-none');
                welcomeDarkIcon.classList.add('d-none');
            }
        }

        function toggleDarkModeWelcome() {
            const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
            if (isDark) {
                document.documentElement.setAttribute('data-bs-theme', 'light');
                localStorage.theme = 'light';
            } else {
                document.documentElement.setAttribute('data-bs-theme', 'dark');
                localStorage.theme = 'dark';
            }
            updateWelcomeThemeIcons();
        }

        // Initialize icons
        updateWelcomeThemeIcons();

        // Preloader transition script
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const preloader = document.getElementById('preloader');
                if (preloader) {
                    preloader.style.transition = 'transform 1.0s cubic-bezier(0.85, 0, 0.15, 1)';
                    preloader.style.transform = 'translateY(-100%)';
                    
                    // Enable scrolling
                    document.body.style.overflow = '';
                    
                    // Cleanup from DOM after transition
                    setTimeout(function() {
                        preloader.remove();
                    }, 1000);
                }
            }, 5000); // 5 seconds total splash time
        });
    </script>

    <!-- Features Modal with Bootstrap 5 Carousel -->
    <div class="modal fade" id="featuresModal" tabindex="-1" aria-labelledby="featuresModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-card bg-body border border-light-subtle shadow-lg">
                <!-- Header with close button (X) -->
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-extrabold text-gradient" id="featuresModalLabel">Explore InLife Assetify Features</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4 text-start">
                    <!-- Carousel Slider -->
                    <div id="featuresCarousel" class="carousel slide" data-bs-ride="carousel">
                        <!-- Indicators -->
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#featuresCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#featuresCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#featuresCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                            <button type="button" data-bs-target="#featuresCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
                        </div>
                        
                        <!-- Slides -->
                        <div class="carousel-inner rounded-4 bg-light border" style="min-height: 300px;">
                            <!-- Slide 1 -->
                            <div class="carousel-item active text-center p-4">
                                <img src="https://placehold.co/800x400/b2569f/ffffff?text=Dashboard+Overview" class="d-block w-100 img-fluid rounded-3 mb-3" alt="Feature 1" style="max-height: 250px; object-fit: cover;">
                                <h5 class="fw-bold text-body">Premium Dashboard</h5>
                                <p class="small text-secondary mb-0">Monitor categories, available stock, borrowed counts, and monthly trends at a single glance.</p>
                            </div>
                            <!-- Slide 2 -->
                            <div class="carousel-item text-center p-4">
                                <img src="https://placehold.co/800x400/8271b4/ffffff?text=Asset+Tracking" class="d-block w-100 img-fluid rounded-3 mb-3" alt="Feature 2" style="max-height: 250px; object-fit: cover;">
                                <h5 class="fw-bold text-body">Physical Inventory Circulations</h5>
                                <p class="small text-secondary mb-0">Record physical asset loans, view due dates, and track real-time check-in and checkout logs.</p>
                            </div>
                            <!-- Slide 3 -->
                            <div class="carousel-item text-center p-4">
                                <img src="https://placehold.co/800x400/57a9d8/ffffff?text=Manager+Approval" class="d-block w-100 img-fluid rounded-3 mb-3" alt="Feature 3" style="max-height: 250px; object-fit: cover;">
                                <h5 class="fw-bold text-body">Manager Approval & Rejection Reasons</h5>
                                <p class="small text-secondary mb-0">Approve loan requests or reject them with mandatory feedback reasons directly visible to staff.</p>
                            </div>
                            <!-- Slide 4 -->
                            <div class="carousel-item text-center p-4">
                                <img src="https://placehold.co/800x400/e9c91e/333333?text=QR+Code+Simulation" class="d-block w-100 img-fluid rounded-3 mb-3" alt="Feature 4" style="max-height: 250px; object-fit: cover;">
                                <h5 class="fw-bold text-body">Dynamic QR Codes</h5>
                                <p class="small text-secondary mb-0">Instantly generate and scan dynamic product QR codes to view specifications during demo sessions.</p>
                            </div>
                        </div>
                        
                        <!-- Controls -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#featuresCarousel" data-bs-slide="prev" style="filter: invert(1); width: 8%;">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#featuresCarousel" data-bs-slide="next" style="filter: invert(1); width: 8%;">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <!-- Footer -->
                <div class="modal-footer border-0 pt-0 justify-content-center">
                    <button type="button" class="btn btn-telkomsel px-4 py-2" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
