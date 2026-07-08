<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Loan;
use App\Models\LoanDetail;
use App\Models\Notification;
use App\Models\Product;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total jenis barang
        $total_products = Product::count();

        // 2. Total barang yang sedang dipinjam (Status = Approved)
        $borrowed_count = LoanDetail::whereHas('loan', function ($q) {
            $q->where('status', 'Approved');
        })->sum('qty');

        // 3. Total barang tersedia (stok fisik saat ini di gudang)
        $available_stock = Product::sum('stock');

        // 4. Total Aset Barang (stok fisik + sedang dipinjam)
        $total_physical_stock = $available_stock + $borrowed_count;

        // 5. Total barang yang rusak / butuh maintenance (Rusak Ringan + Rusak Berat)
        $damaged_count = Product::whereIn('condition', ['Rusak Ringan', 'Rusak Berat'])->sum('stock');

        // 6. Barang dengan stok menipis (stok < 5) - Notifikasi Bonus Fitur
        $low_stock_products = Product::where('stock', '<', 5)
            ->with('category')
            ->get();

        // 7. Grafik peminjaman per bulan (6 bulan terakhir) - Database Agnostic
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

        // 8. Kategori Aset Terbanyak (Donut / Pie Chart)
        $categories_chart = Category::withSum('products', 'stock')
            ->get()
            ->map(function ($cat) {
                return [
                    'name' => $cat->name,
                    'stock' => (int) ($cat->products_sum_stock ?? 0),
                ];
            })
            ->filter(fn ($cat) => $cat['stock'] > 0)
            ->values();

        // 9. Aset Paling Sering Dipinjam (Top 5 - Horizontal Bar Chart)
        $top_borrowed_products = LoanDetail::select('product_id', \DB::raw('SUM(qty) as total_qty'))
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->with('product')
            ->limit(5)
            ->get()
            ->map(function ($detail) {
                return [
                    'name' => $detail->product->name ?? 'Unknown Item',
                    'qty' => (int) $detail->total_qty,
                ];
            });

        // Auto-update status to 'Overdue' for any 'Approved' loans that have passed their due_date
        Loan::where('status', 'Approved')
            ->where('due_date', '<', Carbon::today())
            ->update(['status' => 'Overdue']);

        // 10. Overdue loans
        $overdue_loans = Loan::with(['user', 'details.product'])
            ->where(function ($q) {
                $q->where('status', 'Overdue')
                    ->orWhere(function ($sub) {
                        $sub->where('status', 'Approved')
                            ->where('due_date', '<', Carbon::today());
                    });
            })
            ->orderBy('due_date', 'asc')
            ->get();

        // 11. Log Aktivitas Terbaru (Recent Activities - Products & Loans)
        $recent_products = Product::latest()->limit(5)->get();
        $recent_loans = Loan::with(['user', 'details.product'])->latest()->limit(5)->get();

        $activities = collect();

        foreach ($recent_products as $prod) {
            $activities->push([
                'date' => $prod->created_at,
                'title' => 'New Product Added',
                'message' => 'Product "'.$prod->name.'" (Stock: '.$prod->stock.') was added to '.$prod->location.'.',
                'icon' => 'bi-box-seam',
                'badge_class' => 'bg-info-subtle text-info border-info-subtle',
            ]);
        }

        foreach ($recent_loans as $loan) {
            $status = strtolower($loan->status);
            $icon = 'bi-file-earmark-text';
            $badge_class = 'bg-secondary-subtle text-secondary border-secondary-subtle';

            if ($status === 'pending') {
                $icon = 'bi-clock';
                $badge_class = 'bg-warning-subtle text-warning border-warning-subtle';
                $title = 'Loan Request';
                $msg = 'New request by "'.$loan->borrower_name.'" (Awaiting approval).';
            } elseif ($status === 'approved') {
                $icon = 'bi-check-circle';
                $badge_class = 'bg-success-subtle text-success border-success-subtle';
                $title = 'Loan Approved';
                $msg = 'Loan request for "'.$loan->borrower_name.'" was approved.';
            } elseif ($status === 'returned') {
                $icon = 'bi-arrow-left-right';
                $badge_class = 'bg-primary-subtle text-primary border-primary-subtle';
                $title = 'Items Returned';
                $msg = '"'.$loan->borrower_name.'" returned their borrowed items.';
            } elseif ($status === 'rejected') {
                $icon = 'bi-x-circle';
                $badge_class = 'bg-danger-subtle text-danger border-danger-subtle';
                $title = 'Loan Rejected';
                $msg = 'Loan request for "'.$loan->borrower_name.'" was rejected.';
            } elseif ($status === 'overdue') {
                $icon = 'bi-exclamation-triangle';
                $badge_class = 'bg-danger-subtle text-danger border-danger-subtle';
                $title = 'Loan Overdue';
                $msg = 'Loan for "'.$loan->borrower_name.'" is overdue.';
            }

            $activities->push([
                'date' => $loan->updated_at,
                'title' => $title,
                'message' => $msg,
                'icon' => $icon,
                'badge_class' => $badge_class,
            ]);
        }

        $recent_activities = $activities->sortByDesc('date')->take(6)->values();

        return view('dashboard', compact(
            'total_products',
            'total_physical_stock',
            'borrowed_count',
            'available_stock',
            'damaged_count',
            'low_stock_products',
            'chart_months',
            'chart_counts',
            'categories_chart',
            'top_borrowed_products',
            'overdue_loans',
            'recent_activities'
        ));
    }

    public function remind(Loan $loan)
    {
        if (! in_array($loan->status, ['Approved', 'Overdue'])) {
            return redirect()->back()->with('error', 'This loan is not active or overdue!');
        }

        Notification::create([
            'user_id' => $loan->user_id,
            'title' => 'Overdue Return Warning',
            'message' => 'Please contact borrower "'.$loan->borrower_name.'" immediately. The loan for items (due on '.($loan->due_date ? $loan->due_date->format('d M Y') : '-').') is overdue.',
        ]);

        return redirect()->back()->with('success', 'Reminder notification sent successfully to the staff in charge!');
    }
}
