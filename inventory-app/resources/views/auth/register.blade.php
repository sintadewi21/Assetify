<x-guest-layout>
    <h3 class="fw-bold mb-2">Register New Account</h3>
    <p class="text-secondary small mb-4">Create an account to manage warehouse inventory assets.</p>

    <form method="POST" action="{{ route('register') }}" class="d-flex flex-column gap-3">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="form-label fw-semibold small mb-1">Full Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="e.g., Sinta Dewi Rahmawati" class="form-control py-2.5 rounded-3 @error('name') is-invalid @enderror">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="form-label fw-semibold small mb-1">Office Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="name@gmail.com" class="form-control py-2.5 rounded-3 @error('email') is-invalid @enderror">
            <span class="text-secondary small mt-1 d-block" style="font-size: 11px;">* Must be a valid Gmail address (@gmail.com)</span>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="form-label fw-semibold small mb-1">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" class="form-control py-2.5 rounded-3 @error('password') is-invalid @enderror">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="form-label fw-semibold small mb-1">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" class="form-control py-2.5 rounded-3 @error('password_confirmation') is-invalid @enderror">
            @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-telkomsel w-100 py-2.5 mt-2 rounded-3 shadow-sm">
            Register Account <i class="bi bi-person-plus ms-1"></i>
        </button>

        <div class="text-center mt-3">
            <a class="text-decoration-none text-telkomsel-red fw-semibold small" href="{{ route('login') }}">
                Already have an account? Login here
            </a>
        </div>
    </form>
</x-guest-layout>
