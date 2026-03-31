<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expedition extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'phone_number',
        'picture',
    ];

    /**
     * Deliveries handled by this expedition.
     */
    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }
}
