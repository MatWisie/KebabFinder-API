<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'kebab_id',
        'message',
        'status',
    ];

    public function kebab()
    {
        return $this->belongsTo(Kebab::class);
    }

}
