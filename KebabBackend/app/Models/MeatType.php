<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeatType extends Model
{
    protected $fillable = ['name'];
    public function kebabs()
    {
        return $this->belongsToMany(Kebab::class, 'kebab_meat_types');
    }
}
