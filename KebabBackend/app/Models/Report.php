<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public function kebab()
    {
        return $this->belongsTo(Kebab::class);
    }

}
