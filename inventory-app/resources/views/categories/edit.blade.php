<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h2 class="h5 mb-0 fw-bold text-body">
                {{ __('Edit Category') }}
            </h2>
        </div>
    </x-slot>

    <div class="row justify-content-center mb-5">
        <div class="col-lg-6">
            <div class="card rounded-card border-0 bg-body shadow-sm p-4 p-md-5">
                
                <form action="{{ route('categories.update', $category->id) }}" method="POST" class="d-flex flex-column gap-4">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label for="name" class="form-label fw-bold text-secondary uppercase tracking-wider mb-1" style="font-size: 10px;">Category Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required class="form-control py-2.5 rounded-3 @error('name') is-invalid @enderror">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Actions -->
                    <div class="pt-4 border-top d-flex justify-content-end gap-2">
                        <a href="{{ route('categories.index') }}" class="btn btn-light border py-2.5 px-4 rounded-3 fw-bold">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-telkomsel py-2.5 px-4 shadow rounded-3">
                            Update Category <i class="bi bi-check-circle ms-1"></i>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>