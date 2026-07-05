<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // 1. READ: Tampilkan semua kategori
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    // 2. CREATE: Tampilkan form tambah
    public function create()
    {
        return view('categories.create');
    }

    // 3. STORE: Simpan kategori baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create($request->all());

        return redirect()->route('categories.index')->with('success', 'Category successfully added!');
    }

    // 4. EDIT: Tampilkan form edit data
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    // 5. UPDATE: Simpan perubahan data kategori
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index')->with('success', 'Category successfully updated!');
    }

    // 6. DESTROY: Hapus kategori dari database
    public function destroy(Category $category)
    {
        // Cek jika kategori masih dipakai oleh produk (keamanan relasi)
        if ($category->products()->count() > 0) {
            return redirect()->route('categories.index')->with('error', 'Category cannot be deleted because it is still in use by products!');
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category successfully deleted!');
    }
}