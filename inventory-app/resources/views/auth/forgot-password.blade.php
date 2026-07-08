<x-guest-layout>
    @if (session('status'))
        <div class="text-center py-4">
            <!-- Mail Check / Success Icon -->
            <div class="mb-4 text-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-envelope-check mx-auto" viewBox="0 0 16 16" style="color: #198754;">
                    <path d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2zM1 4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2-7-4.2zm14.854 4.854a.5.5 0 0 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l1.5 1.5a.5.5 0 0 0 .708-.708L13.207 12z"/>
                </svg>
            </div>
            
            <h3 class="fw-bold mb-2">{{ __('Check Mailtrap') }}</h3>
            <p class="text-secondary small mb-4">
                {{ __('The password reset email has been successfully sent to Mailtrap. Please contact the server owner or administrator for information and the password reset link.') }}
            </p>
            
            <a href="{{ route('login') }}" class="btn btn-telkomsel w-100 py-2.5 mt-2 rounded-3 shadow-sm text-decoration-none d-block">
                {{ __('Back to Login') }}
            </a>
        </div>
    @else
        <h3 class="fw-bold mb-2">{{ __('Forgot Password') }}</h3>
        <p class="text-secondary small mb-4">
            {{ __('No problem. Let us know your office email address and we will send you a password reset link to choose a new one.') }}
        </p>

        <!-- Session Status Alert -->
        <x-auth-session-status class="mb-4 alert alert-info py-2" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="d-flex flex-column gap-3">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="form-label fw-semibold small mb-1">{{ __('Office Email') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="name@telkomsel.com" class="form-control py-2.5 rounded-3 @error('email') is-invalid @enderror">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-telkomsel w-100 py-2.5 mt-2 rounded-3 shadow-sm">
                {{ __('Email Password Reset Link') }} <i class="bi bi-envelope-at ms-1"></i>
            </button>

            <div class="text-center mt-3">
                <a class="text-decoration-none text-telkomsel-red fw-semibold small" href="{{ route('login') }}">
                    {{ __('Back to Login') }}
                </a>
            </div>
        </form>
    @endif
</x-guest-layout>
