<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
    'serial_number',
    'name',
    'type',
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

}
