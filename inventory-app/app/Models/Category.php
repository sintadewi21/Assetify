<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Mendaftarkan field yang boleh diisi mass-assignment
    protected $fillable = ['name'];

    // Relasi ke Product (digunakan untuk validasi penghapusan di controller)
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}