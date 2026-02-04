<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    // Sesuaikan fillable dengan kolom baru di migration
    protected $fillable = [
        'purchase_id',
        'product_id',
        'purchase_price',
        'purchase_amount',
        'subtotal',
        'selling_margin',
    ];

    // Relasi ke Purchase (Induk Nota)
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    // Relasi ke Product (Barang)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
