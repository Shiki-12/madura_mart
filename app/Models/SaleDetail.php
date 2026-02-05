<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    protected $fillable = [
        'sale_id',
        'product_id',
        'selling_price', // Harga saat transaksi terjadi
        'quantity',
        'subtotal',
    ];

    // Relasi ke Header Penjualan
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    // Relasi ke Produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}