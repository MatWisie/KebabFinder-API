<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SauceType extends Model
{
    public function kebabs()
    {
        return $this->belongsToMany(Kebab::class, 'kebabsauces');
    }
}
