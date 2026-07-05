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
                {{ __('Item Categories') }}
            </h2>
            <a href="{{ route('categories.create') }}" class="btn btn-telkomsel shadow-sm d-flex align-items-center gap-2 py-2 px-3">
                <i class="bi bi-plus-circle" style="font-size: 16px;"></i>
                {{ __('Add Category') }}
            </a>
        </div>
    </x-slot>

    <!-- Category List Card -->
    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <div class="card rounded-card border-0 bg-body shadow-sm overflow-hidden">
                
                <!-- Action Flash Alerts -->
                @if(session('success'))
                    <div class="alert alert-success border-0 rounded-0 border-start border-4 border-success p-3 m-0" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger border-0 rounded-0 border-start border-4 border-danger p-3 m-0" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-premium align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 15%">No</th>
                                <th style="width: 60%">Category Name</th>
                                <th class="text-end" style="width: 25%">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="small text-body">
                            @forelse($categories as $key => $category)
                                <tr>
                                    <!-- Index -->
                                    <td class="py-3 px-4 text-center text-secondary fw-bold">{{ $key + 1 }}</td>
                                    
                                    <!-- Category Name -->
                                    <td class="py-3 px-4 fw-bold text-body-emphasis">{{ $category->name }}</td>
                                    
                                    <!-- Actions -->
                                    <td class="py-3 px-4 text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <!-- Edit -->
                                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm p-1.5 d-flex align-items-center justify-content-center rounded-2 shadow-sm" style="width: 30px; height: 30px;" title="Edit Category">
                                                <i class="bi bi-pencil-square text-dark" style="font-size: 14px;"></i>
                                            </a>
                                            <!-- Delete -->
                                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Delete this category? All products inside it will be affected.')" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm p-1.5 d-flex align-items-center justify-content-center rounded-2 shadow-sm" style="width: 30px; height: 30px;" title="Delete Category">
                                                    <i class="bi bi-trash3 text-white" style="font-size: 14px;"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-5 text-center text-secondary bg-body-tertiary">
                                        <div class="d-flex flex-column align-items-center justify-content-center gap-2 py-3">
                                            <i class="bi bi-tag text-secondary-50" style="font-size: 36px;"></i>
                                            <span class="fw-semibold">No categories registered yet.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>