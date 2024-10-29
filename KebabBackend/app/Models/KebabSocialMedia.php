<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KebabSocialMedia extends Model
{
    public function kebab()
    {
        return $this->belongsTo(Kebab::class);
    }
}
