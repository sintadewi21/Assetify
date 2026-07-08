<x-guest-layout>
    <h3 class="fw-bold mb-2">{{ __('Verify Email') }}</h3>
    <p class="text-secondary small mb-4">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </p>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success py-2 rounded-3 text-center mb-4" style="font-size: 13px;">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="d-flex flex-column gap-2 mt-4">
        <form method="POST" action="{{ route('verification.send') }}" class="w-100">
            @csrf
            <button type="submit" class="btn btn-telkomsel w-100 py-2.5 rounded-3 shadow-sm">
                {{ __('Resend Verification Email') }} <i class="bi bi-send ms-1"></i>
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="w-100 text-center">
            @csrf
            <button type="submit" class="btn btn-link text-decoration-none text-telkomsel-red fw-semibold small py-2 w-100">
                {{ __('Log Out') }} <i class="bi bi-box-arrow-right ms-1"></i>
            </button>
        </form>
    </div>
</x-guest-layout>
