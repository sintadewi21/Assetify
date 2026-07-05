<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h2 class="h5 mb-0 fw-bold text-body">
                {{ __('Product Details: ') }} {{ $product->name }}
            </h2>
        </div>
    </x-slot>

    <div class="row justify-content-center mb-5">
        <div class="col-lg-10">
            <div class="card rounded-card border-0 bg-body shadow-sm overflow-hidden">
                <div class="row g-0">
                    
                    <!-- Product Image & QR Code Column -->
                    <div class="col-md-5 bg-body-tertiary d-flex flex-column align-items-center justify-content-center p-4 p-md-5 border-end border-light-subtle text-center">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded-4 shadow-sm border mb-4" style="max-height: 250px; object-fit: contain;">
                        @else
                            <div class="d-flex flex-column align-items-center justify-content-center py-4 text-secondary-50 mb-3">
                                <i class="bi bi-box-seam" style="font-size: 72px;"></i>
                                <span class="small mt-2">No product image available</span>
                            </div>
                        @endif

                        <!-- QR Code Section -->
                        <div class="p-3 bg-body rounded-4 shadow-sm border border-light-subtle w-100 d-flex flex-column align-items-center">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($product->code) }}" alt="QR Code" class="img-fluid rounded border bg-white mb-2" style="width: 120px; height: 120px;">
                            <h6 class="fw-bold mb-1 text-body-emphasis" style="font-size: 13px;">Product QR Code</h6>
                            <p class="text-secondary mb-0 small" style="font-size: 11px;">Scan SKU/Code: <strong>{{ $product->code }}</strong></p>
                        </div>
                    </div>

                    <!-- Product Specifications Column -->
                    <div class="col-md-7 p-4 p-md-5 d-flex flex-column justify-content-between">
                        <div>
                            <div class="mb-3">
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle px-3 py-1.5 rounded-pill font-bold uppercase" style="font-size: 9px; letter-spacing: 0.5px;">
                                    {{ $product->category->name }}
                                </span>
                            </div>

                            <h3 class="fw-black text-body mb-1" style="font-weight: 800;">{{ $product->name }}</h3>
                            <p class="font-monospace text-secondary small mb-4">SKU / Code: {{ $product->code }}</p>

                            <!-- Specifications Table -->
                            <div class="list-group list-group-flush border-top border-bottom py-2">
                                <div class="list-group-item bg-transparent d-flex justify-content-between align-items-center py-3 border-0 border-bottom border-light-subtle">
                                    <span class="text-secondary small">Warehouse Location</span>
                                    <span class="fw-bold text-body-emphasis">{{ $product->location }}</span>
                                </div>
                                <div class="list-group-item bg-transparent d-flex justify-content-between align-items-center py-3 border-0 border-bottom border-light-subtle">
                                    <span class="text-secondary small">Physical Condition</span>
                                    <span class="badge py-1.5 px-2.5 rounded-3 fw-bold
                                        {{ $product->condition == 'Bagus' ? 'bg-success bg-opacity-10 text-success border border-success-subtle' : 
                                           ($product->condition == 'Rusak Ringan' ? 'bg-warning bg-opacity-10 text-warning border border-warning-subtle' : 
                                           'bg-danger bg-opacity-10 text-danger border border-danger-subtle') }}">
                                        {{ $product->condition == 'Bagus' ? 'Good' : ($product->condition == 'Rusak Ringan' ? 'Slightly Damaged' : 'Heavily Damaged') }}
                                    </span>
                                </div>
                                <div class="list-group-item bg-transparent d-flex justify-content-between align-items-center py-3 border-0">
                                    <span class="text-secondary small">Stock Quantity</span>
                                    <span class="h6 mb-0 fw-extrabold {{ $product->stock < 5 ? 'text-danger' : 'text-body-emphasis' }}">
                                        {{ $product->stock }} Units
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Actions Grid -->
                        <div class="row g-2 mt-4 pt-3">
                            <div class="col-6">
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning w-100 py-2.5 rounded-3 fw-semibold shadow-sm">
                                    <i class="bi bi-pencil-square me-1"></i> Edit Product
                                </a>
                            </div>
                            <div class="col-6">
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Delete this product from warehouse?')" class="w-100">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100 py-2.5 rounded-3 fw-semibold shadow-sm">
                                        <i class="bi bi-trash3 me-1"></i> Delete Product
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
