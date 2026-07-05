<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Loan;
use App\Models\LoanDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total jenis barang
        $total_products = Product::count();

        // 2. Total barang yang sedang dipinjam (Status = Approved)
        $borrowed_count = LoanDetail::whereHas('loan', function($q) {
            $q->where('status', 'Approved');
        })->sum('qty');

        // 3. Total barang tersedia (stok fisik saat ini di gudang)
        $available_stock = Product::sum('stock');

        // 4. Total Aset Barang (stok fisik + sedang dipinjam)
        $total_physical_stock = $available_stock + $borrowed_count;

        // 5. Barang dengan stok menipis (stok < 5) - Notifikasi Bonus Fitur
        $low_stock_products = Product::where('stock', '<', 5)
            ->with('category')
            ->get();

        // 6. Grafik peminjaman per bulan (6 bulan terakhir) - Database Agnostic
        $chart_months = [];
        $chart_counts = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $chart_months[] = $date->translatedFormat('F Y');

            $count = Loan::whereYear('borrow_date', $date->year)
                ->whereMonth('borrow_date', $date->month)
                ->count();
            $chart_counts[] = $count;
        }

        // Auto-update status to 'Overdue' for any 'Approved' loans that have passed their due_date
        Loan::where('status', 'Approved')
            ->where('due_date', '<', Carbon::today())
            ->update(['status' => 'Overdue']);

        // Fetch overdue loans for Admin/Staff dashboard alert
        $overdue_loans = [];
        if (in_array(strtolower(auth()->user()->role), ['admin', 'staff'])) {
            $overdue_loans = Loan::with(['user', 'details.product'])
                ->where(function($q) {
                    $q->where('status', 'Overdue')
                      ->orWhere(function($sub) {
                          $sub->where('status', 'Approved')
                              ->where('due_date', '<', Carbon::today());
                      });
                })->get();
        }

        return view('dashboard', compact(
            'total_products',
            'total_physical_stock',
            'borrowed_count',
            'available_stock',
            'low_stock_products',
            'chart_months',
            'chart_counts',
            'overdue_loans'
        ));
    }
}
