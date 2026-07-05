<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'code',
        'name',
        'stock',
        'location',
        'condition',
        'image',
    ];

    // Relasi ke Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function loanDetails()
    {
        return $this->hasMany(LoanDetail::class);
    }
}
