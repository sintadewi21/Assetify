<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    // Arahkan model ke tabel database borrowings
    protected $table = 'borrowings';

    protected $fillable = [
        'user_id',
        'borrower_name',
        'borrow_date',
        'due_date',
        'return_date',
        'status',
        'reject_reason',
    ];

    protected $casts = [
        'borrow_date' => 'date',
        'due_date'    => 'date',
        'return_date' => 'date',
    ];

    // Cek secara dinamis apakah transaksi sudah melewati batas waktu
    public function isOverdue()
    {
        return in_array($this->status, ['Approved', 'Overdue']) && $this->due_date && $this->due_date->isPast();
    }

    // Relasi ke User (Staff/Admin penanggung jawab input)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke detail items (LoanDetail)
    public function details()
    {
        return $this->hasMany(LoanDetail::class, 'borrowing_id');
    }
}
