<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\LoanDetail;
use App\Models\Notification;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    // 1. Tampilkan log riwayat peminjaman (dengan Pencarian & Paginasi)
    public function index(Request $request)
    {
        // Auto-update status to 'Overdue' for any 'Approved' loans that have passed their due_date
        Loan::where('status', 'Approved')
            ->where('due_date', '<', Carbon::today())
            ->update(['status' => 'Overdue']);

        $query = Loan::with(['user', 'details.product']);

        // Pencarian Nama Peminjam
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('borrower_name', 'like', '%'.$search.'%');
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $loans = $query->latest()->paginate(10)->withQueryString();

        return view('loans.index', compact('loans'));
    }

    // 2. Tampilkan form untuk mencatat peminjaman baru
    public function create()
    {
        // Hanya ambil barang yang stoknya lebih dari 0
        $products = Product::where('stock', '>', 0)->get();

        return view('loans.create', compact('products'));
    }

    // 3. Simpan transaksi peminjaman baru (Master-Detail Transactional)
    public function store(Request $request)
    {
        $request->validate([
            'borrower_name' => 'required|string|max:255',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:borrow_date',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.qty' => 'required|integer|min:1',
        ]);

        // Validasi Stok Awal sebelum memproses
        foreach ($request->products as $item) {
            $product = Product::findOrFail($item['product_id']);
            if ($item['qty'] > $product->stock) {
                return redirect()->back()
                    ->withErrors(['products' => 'Stok barang "'.$product->name.'" tidak mencukupi! Tersedia: '.$product->stock])
                    ->withInput();
            }
        }

        try {
            DB::transaction(function () use ($request) {
                // 1. Simpan data Master (ke tabel borrowings)
                $loan = Loan::create([
                    'user_id' => Auth::id(), // Staff yang login
                    'borrower_name' => $request->borrower_name,
                    'borrow_date' => $request->borrow_date,
                    'due_date' => $request->due_date,
                    'status' => 'Pending', // Awalnya butuh approval
                ]);

                // 2. Simpan data Detail & Potong Stok (ke tabel borrowing_details)
                foreach ($request->products as $item) {
                    $product = Product::findOrFail($item['product_id']);
                    $product->decrement('stock', $item['qty']);

                    LoanDetail::create([
                        'borrowing_id' => $loan->id,
                        'product_id' => $item['product_id'],
                        'qty' => $item['qty'],
                    ]);
                }

                // 3. Kirim notifikasi ke semua Manager
                $managers = User::where('role', 'manager')->get();
                foreach ($managers as $manager) {
                    Notification::create([
                        'user_id' => $manager->id,
                        'title' => 'New Loan Request',
                        'message' => 'Staff "'.Auth::user()->name.'" requested a loan for "'.$loan->borrower_name.'".',
                    ]);
                }
            });

            return redirect()->route('loans.index')->with('success', 'Loan transaction successfully recorded! Awaiting Manager approval.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while saving data: '.$e->getMessage())->withInput();
        }
    }

    // 4. Proses Setujui Peminjaman (Approval Manager/Admin)
    public function approve(Loan $loan)
    {
        if ($loan->status !== 'Pending') {
            return redirect()->back()->with('error', 'This transaction has already been processed!');
        }

        try {
            DB::transaction(function () use ($loan) {
                $loan->update(['status' => 'Approved']);

                // Kirim notifikasi ke Staff terkait
                Notification::create([
                    'user_id' => $loan->user_id,
                    'title' => 'Loan Request Approved',
                    'message' => 'Your loan request for "'.$loan->borrower_name.'" has been approved!',
                ]);
            });

            return redirect()->route('loans.index')->with('success', 'Loan successfully approved!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: '.$e->getMessage());
        }
    }

    // 5. Proses Tolak Peminjaman (Reject Manager/Admin - Kembalikan Stok)
    public function reject(Request $request, Loan $loan)
    {
        if ($loan->status !== 'Pending') {
            return redirect()->back()->with('error', 'This transaction has already been processed!');
        }

        $request->validate([
            'reject_reason' => 'required|string|max:1000',
        ]);

        try {
            DB::transaction(function () use ($request, $loan) {
                $loan->update([
                    'status' => 'Rejected',
                    'reject_reason' => $request->reject_reason,
                ]);

                // Kembalikan stok barang yang sudah sempat dipotong
                foreach ($loan->details as $detail) {
                    $product = $detail->product;
                    $product->increment('stock', $detail->qty);
                }

                // Kirim notifikasi ke Staff terkait
                Notification::create([
                    'user_id' => $loan->user_id,
                    'title' => 'Loan Request Rejected',
                    'message' => 'Your loan request for "'.$loan->borrower_name.'" has been rejected. Reason: '.$request->reject_reason,
                ]);
            });

            return redirect()->route('loans.index')->with('success', 'Loan request declined, item stock has been returned to the warehouse.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: '.$e->getMessage());
        }
    }

    // 6. Proses Pengembalian Barang (Staff/Admin - Kembalikan Stok & Tandai Selesai)
    public function returnItems(Loan $loan)
    {
        if ($loan->status !== 'Approved') {
            return redirect()->back()->with('error', 'Only approved transactions can be marked as returned!');
        }

        try {
            DB::transaction(function () use ($loan) {
                $loan->update([
                    'status' => 'Returned',
                    'return_date' => Carbon::today(),
                ]);

                // Kembalikan stok barang ke gudang
                foreach ($loan->details as $detail) {
                    $product = $detail->product;
                    $product->increment('stock', $detail->qty);
                }
            });

            return redirect()->route('loans.index')->with('success', 'Items successfully returned to the warehouse and loan status updated!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: '.$e->getMessage());
        }
    }

    // 7. BONUS: Export data peminjaman ke format Excel (CSV)
    public function exportExcel()
    {
        $loans = Loan::with(['user', 'details.product'])->latest()->get();

        $headers = [
            'Content-type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename=Log_Peminjaman_Aset_'.date('Ymd_His').'.csv',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($loans) {
            $file = fopen('php://output', 'w');

            // Tambahkan BOM UTF-8 agar Excel membaca aksen / format tulisan dengan benar
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Judul Kolom
            fputcsv($file, [
                'ID Transaksi',
                'Nama Peminjam',
                'Tanggal Pinjam',
                'Tanggal Kembali',
                'Status',
                'Staff Penanggung Jawab',
                'Daftar Barang & Jumlah',
            ]);

            foreach ($loans as $l) {
                $items = [];
                foreach ($l->details as $detail) {
                    $items[] = ($detail->product->name ?? 'Barang Terhapus').' ('.$detail->qty.' Unit)';
                }

                fputcsv($file, [
                    $l->id,
                    $l->borrower_name,
                    $l->borrow_date ? $l->borrow_date->format('Y-m-d') : '-',
                    $l->return_date ? $l->return_date->format('Y-m-d') : '-',
                    $l->status,
                    $l->user->name ?? '-',
                    implode(', ', $items),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // 8. BONUS: Cetak Laporan / Export PDF (Print Mode layout)
    public function exportPdf()
    {
        $loans = Loan::with(['user', 'details.product'])->latest()->get();

        return view('loans.print', compact('loans'));
    }
}
