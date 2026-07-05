<nav class="navbar navbar-expand-lg bg-body border-bottom sticky-top py-3">
    <div class="container">
        <!-- Brand Logo -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo InLife" height="35">
        </a>

        <!-- Hamburger Toggle for Mobile -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-md-4 gap-2">
                <li class="nav-item">
                    <a class="nav-link px-3 fw-semibold {{ request()->routeIs('dashboard') ? 'active text-telkomsel-red' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                </li>
                
                @if(in_array(strtolower(Auth::user()->role), ['admin', 'staff']))
                    <li class="nav-item">
                        <a class="nav-link px-3 fw-semibold {{ request()->routeIs('categories.*') ? 'active text-telkomsel-red' : '' }}" href="{{ route('categories.index') }}">
                            <i class="bi bi-tags me-1"></i> Categories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 fw-semibold {{ request()->routeIs('products.*') ? 'active text-telkomsel-red' : '' }}" href="{{ route('products.index') }}">
                            <i class="bi bi-box-seam me-1"></i> Products
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link px-3 fw-semibold {{ request()->routeIs('loans.*') ? 'active text-telkomsel-red' : '' }}" href="{{ route('loans.index') }}">
                        <i class="bi bi-journal-check me-1"></i> Loans
                    </a>
                </li>
            </ul>

            <!-- Settings Menu & Dark Mode -->
            <div class="d-flex align-items-center gap-3 border-top pt-3 pt-lg-0 mt-3 mt-lg-0 navbar-border-lg-none">
                
                <!-- Dark Mode Toggle Button -->
                <button onclick="toggleDarkMode()" class="btn btn-outline-secondary border-0 rounded-circle p-2 d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px;" title="Toggle Dark/Light Mode">
                    <i id="theme-toggle-dark-icon" class="bi bi-sun-fill text-warning d-none" style="font-size: 18px;"></i>
                    <i id="theme-toggle-light-icon" class="bi bi-moon-stars-fill d-none" style="font-size: 18px;"></i>
                </button>

                <!-- Notifications Dropdown -->
                @php
                    $unreadNotificationsCount = \App\Models\Notification::where('user_id', Auth::id())->where('is_read', false)->count();
                    $notificationsList = \App\Models\Notification::where('user_id', Auth::id())->latest()->take(5)->get();
                @endphp
                <div class="dropdown">
                    <button class="btn btn-outline-secondary border-0 rounded-circle p-2 d-flex align-items-center justify-content-center shadow-sm position-relative" style="width: 40px; height: 40px;" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false" title="Notifications">
                        <i class="bi bi-bell-fill" style="font-size: 18px;"></i>
                        @if($unreadNotificationsCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-white" style="font-size: 9px; padding: 4px 6px;">
                                {{ $unreadNotificationsCount }}
                            </span>
                        @endif
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end rounded-card mt-2 shadow border border-light-subtle p-0" style="width: 320px; max-width: 90vw;" aria-labelledby="notificationDropdown">
                        <li class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light bg-opacity-50">
                            <span class="fw-bold text-body" style="font-size: 14px;">Notifications</span>
                            @if($unreadNotificationsCount > 0)
                                <form action="{{ route('notifications.read') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="btn btn-link p-0 text-telkomsel-red fw-semibold text-decoration-none" style="font-size: 11px;">
                                        Mark all as read
                                    </button>
                                </form>
                            @endif
                        </li>
                        <div style="max-height: 280px; overflow-y: auto;">
                            @forelse($notificationsList as $notif)
                                <li class="p-3 border-bottom @if(!$notif->is_read) bg-light-subtle fw-semibold @endif text-start" style="font-size: 12px;">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <span class="text-body-emphasis">{{ $notif->title }}</span>
                                        <span class="text-secondary small font-monospace" style="font-size: 9px;">{{ $notif->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-secondary mb-0 small" style="line-height: 1.4;">{{ $notif->message }}</p>
                                </li>
                            @empty
                                <li class="p-4 text-center text-secondary small">
                                    <i class="bi bi-bell-slash d-block mb-1 fs-5"></i>
                                    No notifications yet.
                                </li>
                            @endforelse
                        </div>
                    </ul>
                </div>

                <!-- User Dropdown Menu -->
                <div class="dropdown">
                    <button class="btn btn-light dark-btn-dark border rounded-pill py-2 px-3 dropdown-toggle d-flex align-items-center gap-2 shadow-sm" type="button" id="userMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="d-flex align-items-center gap-2 me-1">
                            <span class="fw-bold text-body text-truncate" style="font-size: 13px; max-width: 150px;">{{ Auth::user()->name }}</span>
                            <span class="badge bg-telkomsel-red text-white py-0.5 px-1.5 font-bold uppercase" style="font-size: 9px; letter-spacing: 0.5px;">{{ Auth::user()->role }}</span>
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end rounded-card mt-2 shadow border border-light-subtle" aria-labelledby="userMenuButton">
                        <li>
                            <a class="dropdown-item py-2 px-3 fw-semibold text-body" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person me-2"></i> My Profile
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 px-3 fw-semibold text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Log Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</nav>

<!-- Script Dark Mode Toggle logic -->
<script>
    const darkIcon = document.getElementById('theme-toggle-dark-icon');
    const lightIcon = document.getElementById('theme-toggle-light-icon');

    function updateThemeIcons() {
        const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
        if (isDark) {
            darkIcon.classList.remove('d-none');
            lightIcon.classList.add('d-none');
        } else {
            lightIcon.classList.remove('d-none');
            darkIcon.classList.add('d-none');
        }
    }

    function toggleDarkMode() {
        const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
        if (isDark) {
            document.documentElement.setAttribute('data-bs-theme', 'light');
            localStorage.theme = 'light';
        } else {
            document.documentElement.setAttribute('data-bs-theme', 'dark');
            localStorage.theme = 'dark';
        }
        updateThemeIcons();
    }

    updateThemeIcons();
</script>
