<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderWay extends Model
{
    protected $fillable = [
        'kebab_id',
        'app_name',
        'phone_number',
        'website',
    ];
    public function kebab()
    {
        return $this->belongsTo(Kebab::class);
    }
}
