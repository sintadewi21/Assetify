<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanDetail extends Model
{
    // Arahkan ke tabel database borrowing_details
    protected $table = 'borrowing_details';

    protected $fillable = [
        'borrowing_id',
        'product_id',
        'qty',
    ];

    // Relasi ke master Loan
    public function loan()
    {
        return $this->belongsTo(Loan::class, 'borrowing_id');
    }

    // Relasi ke Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
