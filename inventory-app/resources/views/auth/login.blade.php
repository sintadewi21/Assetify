<x-guest-layout>
    <!-- Session Status Alert -->
    <x-auth-session-status class="mb-4 alert alert-info py-2" :status="session('status')" />

    <h3 class="fw-bold mb-2">Account Login</h3>
    <p class="text-secondary small mb-4">Please sign in using your registered email.</p>

    <!-- Error Alerts -->
    @if(session('error'))
        <div class="alert alert-danger py-2 rounded-3 text-center mb-4" style="font-size: 13px;">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="d-flex flex-column gap-3">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="form-label fw-semibold small mb-1">Office Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="name@telkomsel.com" class="form-control py-2.5 rounded-3 @error('email') is-invalid @enderror">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <label for="password" class="form-label fw-semibold small mb-0">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-xs text-decoration-none text-telkomsel-red fw-bold small" href="{{ route('password.request') }}" style="font-size: 12px;">
                        Forgot password?
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" class="form-control py-2.5 rounded-3 @error('password') is-invalid @enderror">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="form-check my-1">
            <input id="remember_me" type="checkbox" name="remember" class="form-check-input border-telkomsel">
            <label for="remember_me" class="form-check-label text-secondary small select-none">
                Remember me on this device
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-telkomsel w-100 py-2.5 mt-2 rounded-3 shadow-sm">
            Sign In <i class="bi bi-box-arrow-in-right ms-1"></i>
        </button>

        <div class="text-center mt-3">
            @if (Route::has('register'))
                <a class="text-decoration-none text-telkomsel-red fw-semibold small" href="{{ route('register') }}">
                    Don't have an account? Sign up here
                </a>
            @endif
        </div>
    </form>
</x-guest-layout>
