<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kebab extends Model
{
    public function socialMedias()
    {
        return $this->hasMany(KebabSocialMedia::class);
    }
    public function openingHour()
    {
        return $this->hasOne(OpeningHour::class);
    }

    public function meatTypes()
    {
        return $this->belongsToMany(MeatType::class, 'kebabmeattypes');
    }
    public function orderWay()
    {
        return $this->hasMany(OrderWay::class);
    }
    public function sauces()
    {
        return $this->belongsToMany(SauceType::class, 'kebabsauces');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function reports()
    {
        return $this->hasMany(Report::class);
    }
    public function favouritedBy()
    {
        return $this->belongsToMany(User::class, 'favouritekebabs');
    }
}
