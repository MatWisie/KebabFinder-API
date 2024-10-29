<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function kebab()
    {
        return $this->belongsTo(Kebab::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
