<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // 1. READ: Tampilkan semua barang beserta nama kategorinya dengan pencarian & paginasi
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Pencarian (Search by code, name, location, condition)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('code', 'like', '%' . $search . '%')
                  ->orWhere('location', 'like', '%' . $search . '%')
                  ->orWhere('condition', 'like', '%' . $search . '%');
            });
        }

        // Filter Kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // Filter Kondisi
        if ($request->filled('condition')) {
            $query->where('condition', $request->input('condition'));
        }

        $products = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    // 1.5 DETAIL: Tampilkan detail barang
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    // 2. CREATE: Tampilkan form tambah barang (ambil data kategori untuk dropdown select)
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    // 3. STORE: Simpan data barang baru (termasuk upload gambar)
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'code'        => 'required|string|max:255|unique:products,code',
            'name'        => 'required|string|max:255',
            'stock'       => 'required|integer|min:0',
            'location'    => 'required|string|max:255',
            'condition'   => 'required|in:Bagus,Rusak Ringan,Rusak Berat',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        // Handle upload gambar jika ada
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product successfully added to the warehouse!');
    }

    // 4. EDIT: Tampilkan form edit data barang
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    // 5. UPDATE: Simpan perubahan data barang
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'code'        => 'required|string|max:255|unique:products,code,' . $product->id,
            'name'        => 'required|string|max:255',
            'stock'       => 'required|integer|min:0',
            'location'    => 'required|string|max:255',
            'condition'   => 'required|in:Bagus,Rusak Ringan,Rusak Berat',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product details successfully updated!');
    }

    // 6. DESTROY: Hapus barang dari gudang
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product successfully removed from the warehouse!');
    }
}