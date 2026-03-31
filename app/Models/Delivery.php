<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;
    protected $fillable = [
        'delivery_date',
        'expedition_id',
        'order_id',
        'courier_id',
        'picture_proof',
        'invoice',
        'status',
        'notes',
    ];

    protected $casts = [
        'delivery_date' => 'date',
    ];

    /**
     * The expedition/logistics company handling this delivery.
     */
    public function expedition()
    {
        return $this->belongsTo(Expedition::class);
    }

    /**
     * The order being delivered.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * The courier assigned to this delivery.
     */
    public function courier()
    {
        return $this->belongsTo(User::class, 'courier_id');
    }
}
