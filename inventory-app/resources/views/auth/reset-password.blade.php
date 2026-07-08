<x-guest-layout>
    <h3 class="fw-bold mb-2">{{ __('Reset Password') }}</h3>
    <p class="text-secondary small mb-4">{{ __('Please choose a strong password to secure your account.') }}</p>

    <form method="POST" action="{{ route('password.store') }}" class="d-flex flex-column gap-3">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <label for="email" class="form-label fw-semibold small mb-1">{{ __('Office Email') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" class="form-control py-2.5 rounded-3 @error('email') is-invalid @enderror">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="form-label fw-semibold small mb-1">{{ __('New Password') }}</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" class="form-control py-2.5 rounded-3 @error('password') is-invalid @enderror">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="form-label fw-semibold small mb-1">{{ __('Confirm Password') }}</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" class="form-control py-2.5 rounded-3 @error('password_confirmation') is-invalid @enderror">
            @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-telkomsel w-100 py-2.5 mt-2 rounded-3 shadow-sm">
            {{ __('Reset Password') }} <i class="bi bi-shield-check ms-1"></i>
        </button>
    </form>
</x-guest-layout>
