<section>
    <header class="mb-4">
        <h5 class="fw-bold text-body mb-1">
            {{ __('Delete Account') }}
        </h5>
        <p class="text-secondary small mb-0">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. This action cannot be undone.') }}
        </p>
    </header>

    <button type="button" class="btn btn-danger py-2.5 px-4 rounded-3 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
        {{ __('Delete Account') }} <i class="bi bi-person-x ms-1"></i>
    </button>

    <!-- Bootstrap 5 Centered Modal -->
    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-card border-0 shadow">
                <form method="post" action="{{ route('profile.destroy') }}" class="p-4">
                    @csrf
                    @method('delete')

                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold text-body" id="confirmUserDeletionModalLabel">
                            {{ __('Are you sure you want to delete your account?') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body border-0 py-3">
                        <p class="text-secondary small mb-3">
                            {{ __('Before proceeding, please enter your password to confirm you would like to permanently delete your account.') }}
                        </p>

                        <div>
                            <x-input-label for="password" value="{{ __('Enter Password') }}" />
                            <x-text-input
                                id="password"
                                name="password"
                                type="password"
                                placeholder="{{ __('Your Password') }}"
                                required
                            />
                            <x-input-error :messages="$errors->userDeletion->get('password')" />
                        </div>
                    </div>

                    <div class="modal-footer border-0 pt-0 d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">
                            {{ __('Cancel') }}
                        </button>
                        <button type="submit" class="btn btn-danger px-3">
                            {{ __('Permanently Delete Account') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script to auto-open modal if validation errors exist -->
    @if($errors->userDeletion->isNotEmpty())
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const myModal = new bootstrap.Modal(document.getElementById('confirmUserDeletionModal'));
                myModal.show();
            });
        </script>
    @endif
</section>
