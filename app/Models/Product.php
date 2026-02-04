<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'distributor_id', // Tambahan
        'serial_number',
        'name',
        'type',
        'description',    // Tambahan
        'expiration_date',
        'price',
        'stock',
        'picture',
        'is_active',
    ];

    protected $casts = [
        'expiration_date' => 'date',
        'price' => 'integer',
        'stock' => 'integer',
        'is_active' => 'boolean',
    ];

    // Relasi: Produk dimiliki oleh satu Distributor
    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }
}
