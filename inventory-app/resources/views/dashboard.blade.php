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
        /* Custom hover card scaling for premium feel */
        .card-stat {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        .card-stat:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.06) !important;
        }
        /* Timeline styling */
        .timeline {
            position: relative;
            padding-left: 20px;
        }
        .timeline::before {
            content: '';
            position: absolute;
            left: 5px;
            top: 10px;
            bottom: 10px;
            width: 2px;
            background-color: var(--bs-border-color-translucent);
        }
        .timeline-item {
            position: relative;
            margin-bottom: 24px;
        }
        .timeline-marker {
            position: absolute;
            left: -32px;
            width: 26px;
            height: 26px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--bs-body-bg);
            z-index: 1;
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

    <!-- Alert Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success border-success-subtle rounded-card shadow-sm p-3 mb-4" role="alert">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                <div class="small fw-semibold text-success-emphasis">{{ session('success') }}</div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-danger-subtle rounded-card shadow-sm p-3 mb-4" role="alert">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-exclamation-octagon-fill text-danger fs-5"></i>
                <div class="small fw-semibold text-danger-emphasis">{{ session('error') }}</div>
            </div>
        </div>
    @endif

    <!-- KPI Metric Cards Grid (Primary Metrics Cards) -->
    <div class="row g-4 mb-4">
        <!-- Card 1: Total Jenis Barang -->
        <div class="col-sm-6 col-lg-3">
            <div class="card card-stat rounded-card border-0 bg-body shadow-sm p-4 h-100 d-flex flex-row align-items-center gap-3">
                <div class="p-3 rounded-3" style="background-color: rgba(178, 86, 159, 0.1); color: rgba(178, 86, 159, 1);">
                    <i class="bi bi-boxes" style="font-size: 24px;"></i>
                </div>
                <div>
                    <p class="text-secondary small font-bold uppercase tracking-wider mb-1" style="font-size: 10px;">Product Types</p>
                    <h4 class="fw-extrabold text-body mb-0">{{ $total_products }}</h4>
                    <p class="text-secondary mb-0" style="font-size: 10px;">Registered Items</p>
                </div>
            </div>
        </div>

        <!-- Card 2: Aset Tersedia -->
        <div class="col-sm-6 col-lg-3">
            <div class="card card-stat rounded-card border-0 bg-body shadow-sm p-4 h-100 d-flex flex-row align-items-center gap-3">
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

        <!-- Card 3: Sedang Dipinjam -->
        <div class="col-sm-6 col-lg-3">
            <div class="card card-stat rounded-card border-0 bg-body shadow-sm p-4 h-100 d-flex flex-row align-items-center gap-3">
                <div class="p-3 rounded-3" style="background-color: rgba(87, 169, 216, 0.15); color: rgba(87, 169, 216, 1);">
                    <i class="bi bi-arrow-left-right" style="font-size: 24px;"></i>
                </div>
                <div>
                    <p class="text-secondary small font-bold uppercase tracking-wider mb-1" style="font-size: 10px;">Currently Borrowed</p>
                    <h4 class="fw-extrabold text-body mb-0">{{ $borrowed_count }}</h4>
                    <p class="text-secondary mb-0" style="font-size: 10px;">Active Units Out</p>
                </div>
            </div>
        </div>

        <!-- Card 4: Aset Rusak / Butuh Maintenance -->
        <div class="col-sm-6 col-lg-3">
            <div class="card card-stat rounded-card border-0 bg-body shadow-sm p-4 h-100 d-flex flex-row align-items-center gap-3">
                <div class="p-3 rounded-3" style="background-color: rgba(220, 53, 69, 0.1); color: rgba(220, 53, 69, 1);">
                    <i class="bi bi-tools" style="font-size: 24px;"></i>
                </div>
                <div>
                    <p class="text-secondary small font-bold uppercase tracking-wider mb-1" style="font-size: 10px;">Needs Maintenance</p>
                    <h4 class="fw-extrabold text-body mb-0">{{ $damaged_count }}</h4>
                    <p class="text-danger mb-0 font-bold" style="font-size: 10px;">Damaged / Broken</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Split Screen Dashboard Layout -->
    <div class="row g-4">
        <!-- LEFT COLUMN: Charts & Overdue Return Tracker -->
        <div class="col-lg-8">
            <!-- Chart 1: Monthly Loan Trends -->
            <div class="card rounded-card border-0 bg-body shadow-sm p-4 mb-4">
                <h6 class="fw-bold text-body uppercase tracking-wider mb-4 d-flex align-items-center gap-2" style="font-size: 14px;">
                    <i class="bi bi-graph-up text-telkomsel-red" style="font-size: 16px;"></i>
                    Monthly Asset Loan Trends
                </h6>
                <div class="w-100" style="height: 280px;">
                    <canvas id="borrowingsChart"></canvas>
                </div>
            </div>

            <!-- Double Grid Charts -->
            <div class="row g-4 mb-4">
                <!-- Donut Chart: Categories Distribution -->
                <div class="col-md-6">
                    <div class="card rounded-card border-0 bg-body shadow-sm p-4 h-100">
                        <h6 class="fw-bold text-body uppercase tracking-wider mb-3 d-flex align-items-center gap-2" style="font-size: 13px;">
                            <i class="bi bi-pie-chart text-telkomsel-red"></i>
                            Asset Categories Distribution
                        </h6>
                        <div class="w-100 d-flex align-items-center justify-content-center" style="height: 220px;">
                            @if(count($categories_chart) > 0)
                                <canvas id="categoriesChart"></canvas>
                            @else
                                <div class="text-center text-muted small py-4">No assets found to classify.</div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Horizontal Bar Chart: Top Borrowed Items -->
                <div class="col-md-6">
                    <div class="card rounded-card border-0 bg-body shadow-sm p-4 h-100">
                        <h6 class="fw-bold text-body uppercase tracking-wider mb-3 d-flex align-items-center gap-2" style="font-size: 13px;">
                            <i class="bi bi-bar-chart-steps text-telkomsel-red"></i>
                            Top 5 Most Borrowed Items
                        </h6>
                        <div class="w-100" style="height: 220px;">
                            @if(count($top_borrowed_products) > 0)
                                <canvas id="topBorrowedChart"></canvas>
                            @else
                                <div class="text-center text-muted small py-5">No borrowing logs found yet.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Overdue Return Tracker Table -->
            <div class="card rounded-card border-0 bg-body shadow-sm p-4 mb-4">
                <h6 class="fw-bold text-body uppercase tracking-wider mb-3 d-flex align-items-center gap-2" style="font-size: 14px;">
                    <i class="bi bi-exclamation-triangle text-danger"></i>
                    Overdue Return Tracker
                </h6>
                <div class="table-responsive">
                    <table class="table table-premium mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>Borrower</th>
                                <th>Borrowed Items</th>
                                <th>Due Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($overdue_loans as $loan)
                                <tr>
                                    <td>
                                        <div class="fw-bold text-body">{{ $loan->borrower_name }}</div>
                                        <span class="text-muted small" style="font-size: 10px;">Managed by: {{ $loan->user->name ?? '-' }}</span>
                                    </td>
                                    <td>
                                        @foreach($loan->details as $d)
                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle mb-1">{{ $d->product->name ?? 'Item' }} ({{ $d->qty }} Units)</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <span class="text-danger fw-semibold small animate-pulse-red">{{ $loan->due_date ? $loan->due_date->format('d M Y') : '-' }}</span>
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('loans.remind', $loan->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" style="font-size: 11px;">
                                                <i class="bi bi-bell-fill me-1"></i> Remind Staff
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-secondary small">
                                        <i class="bi bi-shield-check text-success fs-4 d-block mb-1"></i>
                                        All active loans are currently within safe return dates.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: Low Stock Alerts & Recent Activities Timeline -->
        <div class="col-lg-4">
            <!-- Recent Activities Timeline -->
            <div class="card rounded-card border-0 bg-body shadow-sm p-4 mb-4">
                <h6 class="fw-bold text-body uppercase tracking-wider mb-4 d-flex align-items-center gap-2" style="font-size: 14px;">
                    <i class="bi bi-activity text-telkomsel-red"></i>
                    Recent Activities Log
                </h6>
                <div class="timeline ps-3">
                    @forelse($recent_activities as $act)
                        <div class="timeline-item position-relative mb-4">
                            <span class="timeline-marker {{ $act['badge_class'] }} d-flex align-items-center justify-content-center">
                                <i class="{{ $act['icon'] }}" style="font-size: 12px;"></i>
                            </span>
                            <div class="ps-2">
                                <h6 class="fw-bold mb-1 text-body" style="font-size: 12.5px;">{{ $act['title'] }}</h6>
                                <p class="text-secondary small mb-1" style="font-size: 11.5px; line-height: 1.4;">{{ $act['message'] }}</p>
                                <small class="text-muted text-uppercase fw-semibold" style="font-size: 9px; opacity: 0.8;">
                                    <i class="bi bi-clock me-1"></i> {{ $act['date'] ? $act['date']->diffForHumans() : '-' }}
                                </small>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted small py-4">No recent activity logs available.</div>
                    @endforelse
                </div>
            </div>

            <!-- Low Stock Alerts Widget -->
            <div class="card rounded-card border-0 bg-body shadow-sm p-4">
                <h6 class="fw-bold text-body uppercase tracking-wider mb-3 d-flex align-items-center gap-2" style="font-size: 14px;">
                    <i class="bi bi-exclamation-triangle-fill text-warning"></i>
                    Low Stock Alert
                </h6>
                <p class="text-secondary small mb-3" style="font-size: 11.5px;">
                    Items with critical stock levels (less than 5 units) that may need re-stocking:
                </p>
                <div class="d-flex flex-column gap-2">
                    @forelse($low_stock_products as $prod)
                        <a href="{{ route('products.show', $prod->id) }}" class="btn btn-sm btn-light border border-warning-subtle text-start rounded-3 d-flex align-items-center justify-content-between p-2">
                            <span class="fw-semibold text-secondary-emphasis text-truncate me-2" style="font-size: 12px; max-width: 170px;">
                                {{ $prod->name }}
                            </span>
                            <span class="badge bg-warning text-dark rounded-2" style="font-size: 10px;">
                                {{ $prod->stock }} Units
                            </span>
                        </a>
                    @empty
                        <div class="text-center py-4 text-secondary small">
                            <i class="bi bi-shield-check text-success fs-5 d-block mb-1"></i>
                            All inventory assets are fully stocked.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- ChartJS CDN for Visual Excellence -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Line Chart: Monthly Loan Trends
            const ctxTrends = document.getElementById('borrowingsChart').getContext('2d');
            new Chart(ctxTrends, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chart_months) !!},
                    datasets: [{
                        label: 'Loan Frequency',
                        data: {!! json_encode($chart_counts) !!},
                        borderColor: 'rgba(178, 86, 159, 1)',
                        backgroundColor: 'rgba(178, 86, 159, 0.06)',
                        borderWidth: 3,
                        pointBackgroundColor: 'rgba(178, 86, 159, 1)',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        tension: 0.35,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            padding: 10,
                            cornerRadius: 8,
                            backgroundColor: '#212529',
                            titleColor: '#f8fafc',
                            bodyColor: '#e2e8f0',
                            bodyFont: { size: 11 }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0, color: '#6c757d', font: { size: 10 } },
                            grid: { color: 'rgba(108, 117, 125, 0.05)' }
                        },
                        x: {
                            ticks: { color: '#6c757d', font: { size: 10 } },
                            grid: { display: false }
                        }
                    }
                }
            });

            // 2. Donut Chart: Categories Distribution
            @if(count($categories_chart) > 0)
                const ctxCategories = document.getElementById('categoriesChart').getContext('2d');
                new Chart(ctxCategories, {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($categories_chart->pluck('name')) !!},
                        datasets: [{
                            data: {!! json_encode($categories_chart->pluck('stock')) !!},
                            backgroundColor: [
                                'rgba(178, 86, 159, 0.85)',
                                'rgba(130, 113, 180, 0.85)',
                                'rgba(87, 169, 216, 0.85)',
                                'rgba(233, 201, 30, 0.85)',
                                'rgba(40, 167, 69, 0.85)',
                            ],
                            borderColor: '#ffffff',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 8,
                                    padding: 8,
                                    color: '#6c757d',
                                    font: { size: 9 }
                                }
                            }
                        },
                        cutout: '70%'
                    }
                });
            @endif

            // 3. Horizontal Bar Chart: Top Borrowed Items
            @if(count($top_borrowed_products) > 0)
                const ctxTop = document.getElementById('topBorrowedChart').getContext('2d');
                new Chart(ctxTop, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($top_borrowed_products->pluck('name')) !!},
                        datasets: [{
                            label: 'Total Qty Borrowed',
                            data: {!! json_encode($top_borrowed_products->pluck('qty')) !!},
                            backgroundColor: 'rgba(130, 113, 180, 0.8)',
                            hoverBackgroundColor: 'rgba(130, 113, 180, 1)',
                            borderRadius: 4
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                padding: 8,
                                cornerRadius: 6,
                                backgroundColor: '#212529'
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                ticks: { precision: 0, color: '#6c757d', font: { size: 9 } },
                                grid: { color: 'rgba(108, 117, 125, 0.05)' }
                            },
                            y: {
                                ticks: { color: '#6c757d', font: { size: 9 } },
                                grid: { display: false }
                            }
                        }
                    }
                });
            @endif
        });
    </script>
</x-app-layout>
