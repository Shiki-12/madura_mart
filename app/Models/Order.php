<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'user_id',
        'courier_id',
        'delivery_address',
        'order_date',
        'status',
        'payment_method',
        'payment_proof',
        'total_price',
        'notes',
    ];

    // Relasi: Siapa Pembelinya
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi: Siapa Kurirnya
    public function courier()
    {
        return $this->belongsTo(User::class, 'courier_id');
    }

    // Relasi: Apa Barang yang Dibeli
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
