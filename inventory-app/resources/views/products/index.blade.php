<x-app-layout>
    <style>
        body {
            background-color: #f6f8fb !important;
            background-image: 
                radial-gradient(at 0% 0%, rgba(233, 201, 30, 0.05) 0px, transparent 50%), 
                radial-gradient(at 100% 0%, rgba(178, 86, 159, 0.03) 0px, transparent 50%), 
                radial-gradient(at 100% 100%, rgba(87, 169, 216, 0.03) 0px, transparent 50%) !important;
        }
        [data-bs-theme="dark"] body {
            background-color: #0f1116 !important;
            background-image: 
                radial-gradient(at 0% 0%, rgba(233, 201, 30, 0.08) 0px, transparent 50%), 
                radial-gradient(at 100% 0%, rgba(178, 86, 159, 0.05) 0px, transparent 50%), 
                radial-gradient(at 50% 100%, rgba(87, 169, 216, 0.05) 0px, transparent 50%) !important;
        }
    </style>
    <x-slot name="header">
        <div class="w-100 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
            <h2 class="h5 mb-0 fw-bold text-body">
                {{ __('Office Products') }}
            </h2>
            <a href="{{ route('products.create') }}" class="btn btn-telkomsel shadow-sm d-flex align-items-center gap-2 py-2 px-3">
                <i class="bi bi-plus-circle" style="font-size: 16px;"></i>
                {{ __('Add Product') }}
            </a>
        </div>
    </x-slot>

    <!-- Filter & Search Panel Card -->
    <div class="card rounded-card border-0 bg-body shadow-sm p-4 mb-4">
        <form method="GET" action="{{ route('products.index') }}" class="row g-3 align-items-end">
            <!-- Search Input -->
            <div class="col-lg-5 col-md-6">
                <label for="search" class="form-label fw-bold text-secondary uppercase tracking-wider mb-1" style="font-size: 9px;">Search Products</label>
                <div class="input-group">
                    <span class="input-group-text bg-body-secondary border-end-0 text-secondary">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search name, code, location, or condition..." class="form-control border-start-0 rounded-end-3">
                </div>
            </div>

            <!-- Category Filter -->
            <div class="col-lg-3 col-md-3">
                <label for="category_id" class="form-label fw-bold text-secondary uppercase tracking-wider mb-1" style="font-size: 9px;">Category</label>
                <select name="category_id" id="category_id" class="form-select rounded-3">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Condition Filter -->
            <div class="col-lg-2 col-md-3">
                <label for="condition" class="form-label fw-bold text-secondary uppercase tracking-wider mb-1" style="font-size: 9px;">Condition</label>
                <select name="condition" id="condition" class="form-select rounded-3">
                    <option value="">All Conditions</option>
                    <option value="Bagus" {{ request('condition') == 'Bagus' ? 'selected' : '' }}>Good</option>
                    <option value="Rusak Ringan" {{ request('condition') == 'Rusak Ringan' ? 'selected' : '' }}>Slightly Damaged</option>
                    <option value="Rusak Berat" {{ request('condition') == 'Rusak Berat' ? 'selected' : '' }}>Heavily Damaged</option>
                </select>
            </div>

            <!-- Filter Button -->
            <div class="col-lg-2 col-md-12">
                <button type="submit" class="btn btn-brand-secondary w-100 py-2 rounded-3 fw-semibold">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Products Table Card -->
    <div class="card rounded-card border-0 bg-body shadow-sm overflow-hidden mb-5">
        @if(session('success'))
            <div class="alert alert-success border-0 rounded-0 border-start border-4 border-success p-3 m-0" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-premium align-middle mb-0" style="min-width: 900px;">
                <thead>
                    <tr>
                        <th style="width: 8%">Image</th>
                        <th style="width: 15%">Code</th>
                        <th style="width: 25%">Product Name</th>
                        <th style="width: 15%">Category</th>
                        <th style="width: 10%">Stock</th>
                        <th style="width: 12%">Location</th>
                        <th style="width: 10%">Condition</th>
                        <th class="text-center" style="width: 10%">Actions</th>
                    </tr>
                </thead>
                <tbody class="small text-body">
                    @forelse($products as $product)
                        <tr>
                            <!-- Image Column -->
                            <td class="py-3 px-4">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="object-cover rounded-3 shadow-sm border" style="width: 44px; height: 44px; object-fit: cover;">
                                @else
                                    <div class="rounded-3 bg-body-secondary d-flex align-items-center justify-content-center text-secondary-50" style="width: 44px; height: 44px;">
                                        <i class="bi bi-image" style="font-size: 20px;"></i>
                                    </div>
                                @endif
                            </td>
                            
                            <!-- Code -->
                            <td class="py-3 px-4 font-monospace text-secondary" style="font-size: 11px;">
                                {{ $product->code }}
                            </td>
                            
                            <!-- Name -->
                            <td class="py-3 px-4 fw-bold text-body-emphasis">{{ $product->name }}</td>
                            
                            <!-- Category -->
                            <td class="py-3 px-4">
                                <span class="badge bg-secondary-subtle text-secondary-emphasis px-2.5 py-1.5 rounded-2">
                                    {{ $product->category->name }}
                                </span>
                            </td>
                            
                            <!-- Stock -->
                            <td class="py-3 px-4">
                                @if($product->stock < 5)
                                    <span class="text-danger fw-bold d-inline-flex align-items-center gap-1">
                                        {{ $product->stock }}
                                        <span class="badge bg-danger text-white py-0.5 px-1.5" style="font-size: 8px;">Critical</span>
                                    </span>
                                @else
                                    <span class="fw-semibold text-secondary-emphasis">{{ $product->stock }}</span>
                                @endif
                            </td>
                            
                            <!-- Location -->
                            <td class="py-3 px-4 text-secondary">{{ $product->location }}</td>
                            
                            <!-- Condition -->
                            <td class="py-3 px-4">
                                <span class="badge py-1.5 px-2.5 rounded-3 fw-bold
                                    {{ $product->condition == 'Bagus' ? 'bg-success bg-opacity-10 text-success border border-success-subtle' : 
                                       ($product->condition == 'Rusak Ringan' ? 'bg-warning bg-opacity-10 text-warning border border-warning-subtle' : 
                                       'bg-danger bg-opacity-10 text-danger border border-danger-subtle') }}">
                                    {{ $product->condition == 'Bagus' ? 'Good' : ($product->condition == 'Rusak Ringan' ? 'Slightly Damaged' : 'Heavily Damaged') }}
                                </span>
                            </td>
                            
                            <!-- Actions -->
                            <td class="py-3 px-4 text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <!-- Detail -->
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-light border btn-sm p-1.5 d-flex align-items-center justify-content-center rounded-2 shadow-sm" style="width: 30px; height: 30px;" title="Product Details">
                                        <i class="bi bi-eye text-secondary-emphasis" style="font-size: 14px;"></i>
                                    </a>
                                    <!-- Edit -->
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm p-1.5 d-flex align-items-center justify-content-center rounded-2 shadow-sm" style="width: 30px; height: 30px;" title="Edit Product">
                                        <i class="bi bi-pencil-square text-dark" style="font-size: 14px;"></i>
                                    </a>
                                    <!-- Delete -->
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Delete this product from warehouse?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm p-1.5 d-flex align-items-center justify-content-center rounded-2 shadow-sm" style="width: 30px; height: 30px;" title="Delete Product">
                                            <i class="bi bi-trash3 text-white" style="font-size: 14px;"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-5 text-center text-secondary bg-body-tertiary">
                                <div class="d-flex flex-column align-items-center justify-content-center gap-2 py-3">
                                    <i class="bi bi-box2 text-secondary-50" style="font-size: 36px;"></i>
                                    <span class="fw-semibold">No products in warehouse or search not found.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <div class="card-footer bg-body border-top p-4">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>

    </div>
</x-app-layout>