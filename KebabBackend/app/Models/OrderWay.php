<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderWay extends Model
{
    public function kebab()
    {
        return $this->belongsTo(Kebab::class);
    }
}
