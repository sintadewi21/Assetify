<x-app-layout>
    <x-slot name="header">
        <h2 class="h5 mb-0 fw-bold text-body">
            {{ __('My Profile Settings') }}
        </h2>
    </x-slot>

    <div class="row justify-content-center mb-5">
        <div class="col-lg-8 d-flex flex-column gap-4">
            
            <!-- Update Profile Info Card -->
            <div class="card rounded-card border-0 bg-body shadow-sm p-4 p-md-5">
                <div class="w-100" style="max-width: 600px;">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password Card -->
            <div class="card rounded-card border-0 bg-body shadow-sm p-4 p-md-5">
                <div class="w-100" style="max-width: 600px;">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete User Card -->
            <div class="card rounded-card border-0 bg-body shadow-sm p-4 p-md-5">
                <div class="w-100" style="max-width: 600px;">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
