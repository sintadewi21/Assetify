<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h2 class="h5 mb-0 fw-bold text-body">
                {{ __('Register New Product') }}
            </h2>
        </div>
    </x-slot>

    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <div class="card rounded-card border-0 bg-body shadow-sm p-4 p-md-5">
                
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="d-flex flex-column gap-4">
                    @csrf
                    
                    <div class="row g-3">
                        <!-- Code -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary uppercase tracking-wider mb-1" style="font-size: 10px;">Item Code (Unique)</label>
                            <input type="text" name="code" value="{{ old('code') }}" required placeholder="e.g., TSEL-LP-001" class="form-control py-2.5 rounded-3 @error('code') is-invalid @enderror">
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Category -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary uppercase tracking-wider mb-1" style="font-size: 10px;">Select Category (Shelf)</label>
                            <select name="category_id" required class="form-select py-2.5 rounded-3 @error('category_id') is-invalid @enderror">
                                <option value="" disabled selected>-- Select Shelf/Category --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Name -->
                    <div>
                        <label class="form-label fw-bold text-secondary uppercase tracking-wider mb-1" style="font-size: 10px;">Product Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g., Laptop ASUS ExpertBook v2" class="form-control py-2.5 rounded-3 @error('name') is-invalid @enderror">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3">
                        <!-- Stock -->
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary uppercase tracking-wider mb-1" style="font-size: 10px;">Initial Stock Quantity</label>
                            <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0" required class="form-control py-2.5 rounded-3 @error('stock') is-invalid @enderror">
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Location -->
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary uppercase tracking-wider mb-1" style="font-size: 10px;">Storage Location</label>
                            <input type="text" name="location" value="{{ old('location') }}" required placeholder="Warehouse A, 2nd Fl" class="form-control py-2.5 rounded-3 @error('location') is-invalid @enderror">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Condition -->
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary uppercase tracking-wider mb-1" style="font-size: 10px;">Physical Condition</label>
                            <select name="condition" required class="form-select py-2.5 rounded-3 @error('condition') is-invalid @enderror">
                                <option value="Bagus" {{ old('condition') == 'Bagus' ? 'selected' : '' }}>Good</option>
                                <option value="Rusak Ringan" {{ old('condition') == 'Rusak Ringan' ? 'selected' : '' }}>Slightly Damaged</option>
                                <option value="Rusak Berat" {{ old('condition') == 'Rusak Berat' ? 'selected' : '' }}>Heavily Damaged</option>
                            </select>
                            @error('condition')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <label class="form-label fw-bold text-secondary uppercase tracking-wider mb-1" style="font-size: 10px;">Upload Product Image (Optional)</label>
                        <input type="file" name="image" class="form-control py-2 rounded-3 @error('image') is-invalid @enderror">
                        <div class="form-text small text-secondary-50 mt-1">Supports JPEG, PNG, JPG (Max. 2MB)</div>
                        @error('image')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Actions -->
                    <div class="pt-4 border-top d-flex justify-content-end gap-2">
                        <a href="{{ route('products.index') }}" class="btn btn-light border py-2.5 px-4 rounded-3 fw-bold">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-telkomsel py-2.5 px-4 shadow rounded-3">
                            Save Product Data <i class="bi bi-check-circle ms-1"></i>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>