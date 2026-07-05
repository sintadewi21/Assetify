<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('loans.index') }}" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h2 class="h5 mb-0 fw-bold text-body">
                {{ __('Record New Loan') }}
            </h2>
        </div>
    </x-slot>

    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <div class="card rounded-card border-0 bg-body shadow-sm p-4 p-md-5">
                
                <!-- Validation Error Alert -->
                @if($errors->any())
                    <div class="alert alert-danger border-0 rounded-3 p-4 mb-4" role="alert">
                        <h6 class="alert-heading fw-bold mb-2">The following errors occurred:</h6>
                        <ul class="mb-0 small ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('loans.store') }}" class="d-flex flex-column gap-4">
                    @csrf

                    <!-- Borrower Name -->
                    <div>
                        <label for="borrower_name" class="form-label fw-bold text-secondary uppercase tracking-wider mb-1" style="font-size: 10px;">Borrower Full Name</label>
                        <input type="text" name="borrower_name" id="borrower_name" value="{{ old('borrower_name') }}" required placeholder="e.g., Andi Wijaya (IT Division)" class="form-control py-2.5 rounded-3">
                    </div>

                    <!-- Borrow Date -->
                    <div>
                        <label for="borrow_date" class="form-label fw-bold text-secondary uppercase tracking-wider mb-1" style="font-size: 10px;">Borrow Date</label>
                        <input type="date" name="borrow_date" id="borrow_date" value="{{ old('borrow_date', date('Y-m-d')) }}" required class="form-control py-2.5 rounded-3">
                    </div>

                    <!-- Due Date (Deadline) -->
                    <div>
                        <label for="due_date" class="form-label fw-bold text-secondary uppercase tracking-wider mb-1" style="font-size: 10px;">Due Date (Return Deadline)</label>
                        <input type="date" name="due_date" id="due_date" value="{{ old('due_date', date('Y-m-d', strtotime('+7 days'))) }}" required class="form-control py-2.5 rounded-3">
                    </div>

                    <!-- AlpineJS Multi-item Dynamic Form Section -->
                    <div x-data="{ items: {{ json_encode(old('products', [['product_id' => '', 'qty' => 1]])) }} }">
                        
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                            <h6 class="fw-bold text-secondary uppercase tracking-wider mb-0" style="font-size: 11px;">List of Borrowed Items</h6>
                            <button type="button" @click="items.push({ product_id: '', qty: 1 })" class="btn btn-outline-danger btn-sm fw-bold px-3 py-1.5 rounded-3 d-flex align-items-center gap-1">
                                <i class="bi bi-plus-lg"></i> Add Row
                            </button>
                        </div>

                        <!-- Rows list -->
                        <div class="d-flex flex-column gap-3">
                            <template x-for="(item, index) in items" :key="index">
                                <div class="row g-2 align-items-center bg-light-subtle p-3 rounded-3 border">
                                    <!-- Select Product -->
                                    <div class="col-md-8 col-sm-7">
                                        <select :name="'products['+index+'][product_id]'" x-model="item.product_id" required class="form-select py-2 rounded-3">
                                            <option value="" disabled selected>Select Item...</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}">
                                                    {{ $product->name }} (Stock: {{ $product->stock }} | Location: {{ $product->location }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Qty -->
                                    <div class="col-md-3 col-sm-3">
                                        <input type="number" :name="'products['+index+'][qty]'" x-model="item.qty" min="1" required class="form-control py-2 rounded-3 text-center" placeholder="Qty">
                                    </div>

                                    <!-- Remove Button -->
                                    <div class="col-md-1 col-sm-2 text-end">
                                        <button type="button" @click="items.splice(index, 1)" :disabled="items.length === 1" class="btn btn-outline-danger border-0 rounded-circle p-2 d-flex align-items-center justify-content-center shadow-sm" style="width: 38px; height: 38px;">
                                            <i class="bi bi-trash3" style="font-size: 16px;"></i>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>

                    </div>

                    <!-- Submit Actions -->
                    <div class="pt-4 border-top d-flex justify-content-end gap-2">
                        <a href="{{ route('loans.index') }}" class="btn btn-light border py-2.5 px-4 rounded-3 fw-bold">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-telkomsel py-2.5 px-4 shadow rounded-3">
                            Save Transaction <i class="bi bi-check2-circle ms-1"></i>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
