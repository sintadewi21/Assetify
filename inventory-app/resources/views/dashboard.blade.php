<x-app-layout>
    <style>
        @keyframes pulse-red {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }
        .animate-pulse-red {
            animation: pulse-red 1.5s infinite ease-in-out;
        }
        .animate-pulse-red-icon {
            animation: pulse-red 1.5s infinite ease-in-out;
        }
    </style>

    <x-slot name="header">
        <h2 class="h5 mb-0 fw-bold text-body">
            {{ __('InLife Inventory Dashboard') }}
        </h2>
    </x-slot>

    <!-- Welcome Banner Card -->
    <div class="card bg-telkomsel-red text-white border-0 rounded-card shadow-sm p-4 p-md-5 mb-4 position-relative overflow-hidden">
        <div class="position-relative z-1">
            <h3 class="fw-bold mb-2">Welcome, {{ Auth::user()->name }}!</h3>
            <p class="mb-0 text-white-50 small" style="max-width: 600px;">
                You are logged in as <strong class="text-white uppercase">{{ Auth::user()->role }}</strong>. 
                Manage PT Telkomsel office inventory items systematically and easily monitor asset loan logs through this dashboard.
            </p>
        </div>
        <!-- Abstract design shapes -->
        <div class="position-absolute end-0 bottom-0 translate-middle-y rounded-circle bg-white opacity-10 blur-md" style="width: 150px; height: 150px; filter: blur(40px);"></div>
        <div class="position-absolute end-0 top-0 rounded-circle bg-white opacity-5 blur-lg" style="width: 250px; height: 250px; filter: blur(60px);"></div>
    </div>

    <!-- Overdue Loans Notification -->
    @if(in_array(strtolower(Auth::user()->role), ['admin', 'staff']) && count($overdue_loans) > 0)
        <div class="alert alert-danger border-danger-subtle rounded-card shadow-sm p-4 mb-4" role="alert">
            <div class="d-flex align-items-start gap-3">
                <div class="p-2 bg-danger bg-opacity-25 text-danger rounded-3 animate-pulse-red-icon">
                    <i class="bi bi-clock-history" style="font-size: 24px;"></i>
                </div>
                <div class="flex-grow-1">
                    <h5 class="alert-heading fw-bold mb-1 text-danger-emphasis" style="font-size: 14px;">Warning: Overdue Loans Detected!</h5>
                    <p class="small mb-3">The following loan transactions have passed their due date and require immediate return:</p>
                    <div class="row g-3">
                        @foreach($overdue_loans as $loan)
                            <div class="col-md-6 col-lg-4">
                                <div class="card p-3 border border-danger-subtle bg-danger bg-opacity-5 h-100 shadow-none">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="fw-bold text-danger">{{ $loan->borrower_name }}</span>
                                        <span class="badge animate-pulse-red badge-custom bg-danger text-white">Overdue</span>
                                    </div>
                                    <p class="small text-secondary mb-1" style="font-size: 11px;">
                                        <strong>Due Date:</strong> <span class="text-danger fw-semibold">{{ $loan->due_date ? $loan->due_date->format('d M Y') : '-' }}</span>
                                    </p>
                                    <div class="small text-secondary mb-2" style="font-size: 11px;">
                                        <strong>Items:</strong>
                                        @foreach($loan->details as $d)
                                            <span class="d-block text-secondary-emphasis font-bold">• {{ $d->product->name ?? 'Item' }} ({{ $d->qty }} Units)</span>
                                        @endforeach
                                    </div>
                                    <p class="small mb-0 text-danger-emphasis fw-bold" style="font-size: 11px;">
                                        Not returned yet
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Low-Stock Alerts Notification (Bonus Feature) -->
    @if(count($low_stock_products) > 0)
        <div class="alert alert-warning border-warning-subtle rounded-card shadow-sm p-4 mb-4" role="alert">
            <div class="d-flex align-items-start gap-3">
                <div class="p-2 bg-warning bg-opacity-25 text-warning rounded-3">
                    <i class="bi bi-exclamation-triangle-fill" style="font-size: 24px;"></i>
                </div>
                <div class="flex-grow-1">
                    <h5 class="alert-heading fw-bold mb-1" style="font-size: 14px;">Warning: Low Stock Alert!</h5>
                    <p class="small mb-3">There are several inventory assets with critical stock levels (under 5 units):</p>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($low_stock_products as $prod)
                            <a href="{{ route('products.show', $prod->id) }}" class="btn btn-sm btn-light border border-warning-subtle text-warning fw-semibold rounded-2 d-flex align-items-center gap-2">
                                {{ $prod->name }} 
                                <span class="badge bg-warning text-dark font-bold">
                                    {{ $prod->stock }} Units
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- KPI Metric Cards Grid -->
    <div class="row g-4 mb-4">
        <!-- Card 1: Total Jenis Barang (Orchid Color) -->
        <div class="col-sm-6 col-lg-3">
            <div class="card rounded-card border-0 bg-body shadow-sm p-4 h-100 d-flex flex-row align-items-center gap-3">
                <div class="p-3 rounded-3" style="background-color: rgba(178, 86, 159, 0.1); color: rgba(178, 86, 159, 1);">
                    <i class="bi bi-boxes" style="font-size: 24px;"></i>
                </div>
                <div>
                    <p class="text-secondary small font-bold uppercase tracking-wider mb-1" style="font-size: 10px;">Product Types</p>
                    <h4 class="fw-extrabold text-body mb-0">{{ $total_products }}</h4>
                    <p class="text-secondary mb-0" style="font-size: 10px;">Registered Categories</p>
                </div>
            </div>
        </div>

        <!-- Card 2: Total Unit di Gudang (Slate Purple Color) -->
        <div class="col-sm-6 col-lg-3">
            <div class="card rounded-card border-0 bg-body shadow-sm p-4 h-100 d-flex flex-row align-items-center gap-3">
                <div class="p-3 rounded-3" style="background-color: rgba(130, 113, 180, 0.1); color: rgba(130, 113, 180, 1);">
                    <i class="bi bi-box-seam" style="font-size: 24px;"></i>
                </div>
                <div>
                    <p class="text-secondary small font-bold uppercase tracking-wider mb-1" style="font-size: 10px;">Total Physical Assets</p>
                    <h4 class="fw-extrabold text-body mb-0">{{ $total_physical_stock }}</h4>
                    <p class="text-secondary mb-0" style="font-size: 10px;">Units in Warehouse</p>
                </div>
            </div>
        </div>

        <!-- Card 3: Barang Dipinjam (Sky Blue Color) -->
        <div class="col-sm-6 col-lg-3">
            <div class="card rounded-card border-0 bg-body shadow-sm p-4 h-100 d-flex flex-row align-items-center gap-3">
                <div class="p-3 rounded-3" style="background-color: rgba(87, 169, 216, 0.15); color: rgba(87, 169, 216, 1);">
                    <i class="bi bi-calendar-event" style="font-size: 24px;"></i>
                </div>
                <div>
                    <p class="text-secondary small font-bold uppercase tracking-wider mb-1" style="font-size: 10px;">Currently Borrowed</p>
                    <h4 class="fw-extrabold text-body mb-0">{{ $borrowed_count }}</h4>
                    <p class="text-secondary mb-0" style="font-size: 10px;">Active Units Out</p>
                </div>
            </div>
        </div>

        <!-- Card 4: Barang Tersedia (Gold/Yellow Color) -->
        <div class="col-sm-6 col-lg-3">
            <div class="card rounded-card border-0 bg-body shadow-sm p-4 h-100 d-flex flex-row align-items-center gap-3">
                <div class="p-3 rounded-3" style="background-color: rgba(233, 201, 30, 0.18); color: rgba(200, 170, 20, 1);">
                    <i class="bi bi-check-circle" style="font-size: 24px;"></i>
                </div>
                <div>
                    <p class="text-secondary small font-bold uppercase tracking-wider mb-1" style="font-size: 10px;">Available Assets</p>
                    <h4 class="fw-extrabold text-body mb-0">{{ $available_stock }}</h4>
                    <p class="text-success mb-0 font-bold" style="font-size: 10px;">Ready for Use</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Block Card -->
    <div class="card rounded-card border-0 bg-body shadow-sm p-4 p-md-5 mb-5">
        <h5 class="fw-bold text-body uppercase tracking-wider mb-4 d-flex align-items-center gap-2" style="font-size: 15px;">
            <i class="bi bi-graph-up text-telkomsel-red" style="font-size: 18px;"></i>
            Monthly Asset Loans Chart
        </h5>
        
        <div class="w-100 relative" style="height: 320px;">
            <canvas id="borrowingsChart"></canvas>
        </div>
    </div>

    <!-- ChartJS CDN for Visual Excellence -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('borrowingsChart').getContext('2d');
            
            // Konfigurasi Chart dengan Warna Merah Telkomsel yang Premium
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chart_months) !!},
                    datasets: [{
                        label: 'Loan Transaction Frequency',
                        data: {!! json_encode($chart_counts) !!},
                        borderColor: 'rgba(178, 86, 159, 1)',
                        backgroundColor: 'rgba(178, 86, 159, 0.08)',
                        borderWidth: 3,
                        pointBackgroundColor: 'rgba(178, 86, 159, 1)',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        tension: 0.35, // Membuat garis melengkung lembut
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            padding: 12,
                            cornerRadius: 10,
                            backgroundColor: '#212529',
                            titleColor: '#f8fafc',
                            bodyColor: '#e2e8f0',
                            bodyFont: {
                                size: 12
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                color: '#6c757d'
                            },
                            grid: {
                                color: 'rgba(108, 117, 125, 0.08)'
                            }
                        },
                        x: {
                            ticks: {
                                color: '#6c757d'
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
