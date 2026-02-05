<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'sale_date',
        'total_price',
        'user_id', // Kasir yang melayani
    ];

    protected $casts = [
        'sale_date' => 'date',
    ];

    // Relasi ke User (Kasir)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Detail Penjualan
    public function details()
    {
        return $this->hasMany(SaleDetail::class);
    }
}