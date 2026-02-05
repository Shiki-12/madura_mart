<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'product_id', 'product_name', 'quantity', 'price', 'subtotal'
    ];

    // Relasi ke Produk (untuk ambil gambar/info terbaru)
    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed(); // withTrashed jaga2 kalau produk dihapus
    }
}
