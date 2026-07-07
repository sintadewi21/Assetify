<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\LoanDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LoanApiController extends Controller
{
    // GET /api/loans
    public function index()
    {
        $loans = Loan::with(['user', 'details.product'])->latest()->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Daftar transaksi peminjaman berhasil diambil',
            'data' => $loans,
        ], 200);
    }

    // POST /api/loans
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id', // Staff penanggung jawab
            'borrower_name' => 'required|string|max:255',
            'borrow_date' => 'required|date',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.qty' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Cek kecukupan stok
        foreach ($request->products as $item) {
            $product = Product::find($item['product_id']);
            if ($item['qty'] > $product->stock) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Stok produk "'.$product->name.'" tidak mencukupi. Tersedia: '.$product->stock,
                ], 400);
            }
        }

        try {
            $loan = DB::transaction(function () use ($request) {
                // 1. Simpan Master Peminjaman (ke tabel borrowings)
                $loan = Loan::create([
                    'user_id' => $request->user_id,
                    'borrower_name' => $request->borrower_name,
                    'borrow_date' => $request->borrow_date,
                    'status' => 'Pending',
                ]);

                // 2. Simpan Detail Peminjaman & Kurangi Stok (ke tabel borrowing_details)
                foreach ($request->products as $item) {
                    $product = Product::find($item['product_id']);
                    $product->decrement('stock', $item['qty']);

                    LoanDetail::create([
                        'borrowing_id' => $loan->id,
                        'product_id' => $item['product_id'],
                        'qty' => $item['qty'],
                    ]);
                }

                return $loan;
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi peminjaman berhasil dicatat (Pending)',
                'data' => $loan->load('details.product'),
            ], 210);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem: '.$e->getMessage(),
            ], 500);
        }
    }
}
