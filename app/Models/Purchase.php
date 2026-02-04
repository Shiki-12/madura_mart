<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'note_number',
        'purchase_date',
        'distributor_id',
        'total_price',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'total_price' => 'integer',
    ];

    // Relasi ke Distributor (Purchase milik 1 Distributor)
    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }
}