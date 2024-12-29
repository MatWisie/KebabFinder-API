<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'user_id',
        'kebab_id',
        'content',
        'status',
    ];

    public function kebab()
    {
        return $this->belongsTo(Kebab::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
