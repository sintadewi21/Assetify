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
        @keyframes pulse-red {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }
        .animate-pulse-red {
            animation: pulse-red 1.5s infinite ease-in-out;
        }
    </style>
    <x-slot name="header">
        <div class="w-100 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
            <h2 class="h5 mb-0 fw-bold text-body">
                {{ __('Item Transactions & Loans') }}
            </h2>
            
            <!-- Tombol "+ Catat Peminjaman Baru" HANYA muncul jika user yang login adalah Admin atau Staff -->
            @if(in_array(strtolower(Auth::user()->role), ['admin', 'staff']))
                <a href="{{ route('loans.create') }}" class="btn btn-telkomsel shadow-sm d-flex align-items-center gap-2 py-2 px-3">
                    <i class="bi bi-plus-circle" style="font-size: 16px;"></i>
                    {{ __('Record New Loan') }}
                </a>
            @endif
        </div>
    </x-slot>

    <!-- Filters & Export Bar -->
    <div class="card rounded-card border-0 bg-body shadow-sm p-4 mb-4">
        <div class="row align-items-end g-3 justify-content-between">
            
            <!-- Search & Status Filter Form -->
            <div class="col-xl-8">
                <form method="GET" action="{{ route('loans.index') }}" class="row g-3">
                    <!-- Search Borrower Name -->
                    <div class="col-sm-5">
                        <label for="search" class="form-label fw-bold text-secondary uppercase tracking-wider mb-1" style="font-size: 9px;">Borrower Name</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search borrower name..." class="form-control rounded-3">
                    </div>

                    <!-- Status Filter -->
                    <div class="col-sm-4">
                        <label for="status" class="form-label fw-bold text-secondary uppercase tracking-wider mb-1" style="font-size: 9px;">Status</label>
                        <select name="status" id="status" class="form-select rounded-3">
                            <option value="">All Statuses</option>
                            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending (Approval)</option>
                            <option value="Approved" {{ request('status') == 'Approved' ? 'selected' : '' }}>Approved (Borrowed)</option>
                            <option value="Returned" {{ request('status') == 'Returned' ? 'selected' : '' }}>Returned (Completed)</option>
                            <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected (Declined)</option>
                            <option value="Overdue" {{ request('status') == 'Overdue' ? 'selected' : '' }}>Overdue (Late)</option>
                        </select>
                    </div>

                    <div class="col-sm-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-brand-secondary w-100 py-2 rounded-3 fw-semibold">
                            <i class="bi bi-filter me-1"></i> Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Export Buttons (Admin & Manager) -->
            @if(in_array(strtolower(Auth::user()->role), ['admin', 'manager']))
                <div class="col-xl-4 text-xl-end d-flex gap-2 justify-content-xl-end">
                    <!-- Export CSV (Excel) -->
                    <a href="{{ route('loans.export.excel') }}" class="btn btn-success py-2 px-3 rounded-3 fw-semibold shadow-sm d-flex align-items-center gap-1.5">
                        <i class="bi bi-file-earmark-excel"></i> Excel (.csv)
                    </a>
                    
                    <!-- Laporan PDF -->
                    <a href="{{ route('loans.export.pdf') }}" target="_blank" class="btn btn-outline-secondary py-2 px-3 rounded-3 fw-semibold shadow-sm d-flex align-items-center gap-1.5">
                        <i class="bi bi-printer"></i> PDF Report
                    </a>
                </div>
            @endif

        </div>
    </div>

    <!-- Log Table Card -->
    <div class="card rounded-card border-0 bg-body shadow-sm overflow-hidden mb-5">
        
        <!-- Alerts notification inside card header -->
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
            <table class="table table-premium align-middle mb-0" style="min-width: 900px;">
                <thead>
                    <tr>
                        <th style="width: 10%">Borrow Date</th>
                        <th style="width: 10%">Due Date</th>
                        <th style="width: 15%">Borrower Name</th>
                        <th style="width: 25%">Items List</th>
                        <th style="width: 12%">Return Date</th>
                        <th class="text-center" style="width: 12%">Status</th>
                        <th style="width: 8%">By Staff</th>
                        <th class="text-center" style="width: 8%">Actions</th>
                    </tr>
                </thead>
                <tbody class="small text-body">
                    @forelse($loans as $loan)
                        <tr>
                            <!-- Tanggal Pinjam -->
                            <td class="py-3 px-4 fw-semibold text-secondary">
                                {{ $loan->borrow_date->format('d M Y') }}
                            </td>

                            <!-- Tanggal Tenggat -->
                            <td class="py-3 px-4 text-secondary">
                                @if($loan->due_date)
                                    <span class="{{ $loan->isOverdue() ? 'text-danger fw-bold' : '' }}">
                                        {{ $loan->due_date->format('d M Y') }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            
                            <!-- Nama Peminjam -->
                            <td class="py-3 px-4 fw-bold">{{ $loan->borrower_name }}</td>
                            
                            <!-- Daftar Barang -->
                            <td class="py-3 px-4">
                                <div class="d-flex flex-column gap-1.5">
                                    @foreach($loan->details as $detail)
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="d-inline-block rounded-circle bg-danger" style="width: 6px; height: 6px;"></span>
                                            <span class="fw-semibold text-secondary-emphasis">
                                                {{ $detail->product->name ?? 'Deleted Item' }}
                                            </span>
                                            <span class="text-secondary small">
                                                ({{ $detail->qty }} Units)
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            
                            <!-- Tanggal Kembali -->
                            <td class="py-3 px-4 text-secondary">
                                @if($loan->status === 'Returned' && $loan->return_date)
                                    <span class="text-success fw-bold">
                                        {{ $loan->return_date->format('d M Y') }}
                                    </span>
                                @elseif($loan->status === 'Rejected')
                                    <span class="text-danger fw-semibold">Declined</span>
                                @else
                                    <span class="text-muted italic">Not returned yet</span>
                                @endif
                            </td>
                            
                            <!-- Status Badge -->
                            <td class="py-3 px-4 text-center">
                                @if($loan->isOverdue())
                                    <span class="badge py-1.5 px-2.5 rounded-3 fw-bold animate-pulse-red bg-danger text-white border border-danger-subtle d-inline-block">
                                        Overdue
                                    </span>
                                @else
                                    <span class="badge py-1.5 px-2.5 rounded-3 fw-bold
                                        {{ $loan->status == 'Pending' ? 'bg-warning bg-opacity-10 text-warning border border-warning-subtle' : 
                                           ($loan->status == 'Approved' ? 'bg-primary bg-opacity-10 text-primary border border-primary-subtle' : 
                                           ($loan->status == 'Returned' ? 'bg-success bg-opacity-10 text-success border border-success-subtle' : 
                                           'bg-danger bg-opacity-10 text-danger border border-danger-subtle')) }}">
                                        {{ $loan->status }}
                                    </span>
                                @endif

                                @if($loan->status === 'Rejected' && $loan->reject_reason)
                                    <div class="text-danger mt-1 small" style="font-size: 10px; max-width: 150px; word-wrap: break-word; margin: 0 auto;">
                                        <strong>Reason:</strong> {{ $loan->reject_reason }}
                                    </div>
                                @endif
                            </td>
                            
                            <!-- Staff Penanggung Jawab -->
                            <td class="py-3 px-4 text-secondary fw-semibold">
                                {{ $loan->user->name ?? '-' }}
                            </td>
                            
                            <!-- Actions -->
                            <td class="py-3 px-4 text-center">
                                @if($loan->status === 'Pending')
                                    <!-- Tombol Setujui/Tolak HANYA untuk Admin/Manager -->
                                    @if(in_array(strtolower(Auth::user()->role), ['admin', 'manager']))
                                        <div class="d-flex justify-content-center gap-1">
                                            <form action="{{ route('loans.approve', $loan->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-success btn-sm px-2 py-1" style="font-size: 11px; border-radius: 6px;">
                                                    Approve
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-danger btn-sm px-2 py-1" style="font-size: 11px; border-radius: 6px;"
                                                data-bs-toggle="modal" data-bs-target="#rejectModal"
                                                data-action="{{ route('loans.reject', $loan->id) }}">
                                                Reject
                                            </button>
                                        </div>
                                    @else
                                        <!-- Jika yang login adalah Staff, tampilkan teks "Selesai diproses / Menunggu Approval" -->
                                        <span class="text-warning fw-bold" style="font-size: 11px;">
                                            Recorded / Awaiting Approval
                                        </span>
                                    @endif
                                @elseif(($loan->status === 'Approved' || $loan->status === 'Overdue') && in_array(strtolower(Auth::user()->role), ['admin', 'staff']))
                                    @if($loan->status === 'Approved')
                                        <!-- Staff/Admin Return Action -->
                                        <form action="{{ route('loans.return', $loan->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-primary btn-sm px-3 py-1" style="font-size: 11px; border-radius: 6px;" onclick="return confirm('Confirm return of these items?')">
                                                Return Items
                                            </button>
                                        </form>
                                    @else
                                        <!-- Staff/Admin Cancel Action -->
                                        <form action="{{ route('loans.cancel', $loan->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-danger btn-sm px-3 py-1" style="font-size: 11px; border-radius: 6px;" onclick="return confirm('Cancel this loan? Item stock will be returned to the warehouse.')">
                                                Cancel Loan
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <span class="text-muted italic" style="font-size: 11px;">Processed</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-5 text-center text-secondary bg-body-tertiary">
                                <div class="d-flex flex-column align-items-center justify-content-center gap-2 py-3">
                                    <i class="bi bi-inboxes text-secondary-50" style="font-size: 36px;"></i>
                                    <span class="fw-semibold">No loan transactions recorded yet.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <div class="card-footer bg-body border-top p-4">
            {{ $loans->links('pagination::bootstrap-5') }}
        </div>

    </div>

    <!-- Reject Reason Input Modal (Required field) -->
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-card">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-body" id="rejectModalLabel">Reject Loan Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="rejectForm" method="POST" action="">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body py-3 text-start">
                        <p class="small text-secondary mb-3">Please specify the reason for declining this loan request. This reason will be visible to the staff.</p>
                        <div class="mb-3">
                            <label for="reject_reason" class="form-label fw-bold text-secondary uppercase tracking-wider mb-1" style="font-size: 9px;">Reject Reason</label>
                            <textarea class="form-control rounded-3" name="reject_reason" id="reject_reason" rows="3" required placeholder="Write rejection reason here..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-secondary py-2 px-3 rounded-3 fw-semibold small" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger py-2 px-3 rounded-3 fw-semibold small">Submit Rejection</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const rejectModal = document.getElementById('rejectModal');
            if (rejectModal) {
                rejectModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const action = button.getAttribute('data-action');
                    const form = rejectModal.querySelector('#rejectForm');
                    form.setAttribute('action', action);
                    
                    // Reset input field
                    rejectModal.querySelector('#reject_reason').value = '';
                });
            }
        });
    </script>
</x-app-layout>
