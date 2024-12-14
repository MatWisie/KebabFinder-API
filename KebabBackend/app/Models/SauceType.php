<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SauceType extends Model
{
    protected $fillable = ['name'];
    public function kebabs()
    {
        return $this->belongsToMany(Kebab::class, 'kebab_sauces');
    }
}
