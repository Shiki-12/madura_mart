<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    protected $table = 'distributors';

    protected $fillable = ['name', 'address', 'phone_number'];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
