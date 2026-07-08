<x-guest-layout>
    <h3 class="fw-bold mb-2">{{ __('Confirm Password') }}</h3>
    <p class="text-secondary small mb-4">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </p>

    <form method="POST" action="{{ route('password.confirm') }}" class="d-flex flex-column gap-3">
        @csrf

        <!-- Password -->
        <div>
            <label for="password" class="form-label fw-semibold small mb-1">{{ __('Password') }}</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" class="form-control py-2.5 rounded-3 @error('password') is-invalid @enderror">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-telkomsel w-100 py-2.5 mt-2 rounded-3 shadow-sm">
            {{ __('Confirm') }} <i class="bi bi-shield-lock ms-1"></i>
        </button>
    </form>
</x-guest-layout>
