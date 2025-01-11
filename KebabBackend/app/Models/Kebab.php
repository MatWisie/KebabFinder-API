<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kebab extends Model
{
    protected $fillable = [
        'name',
        'address',
        'coordinates',
        'logo_link',
        'open_year',
        'closed_year',
        'status',
        'is_craft',
        'building_type',
        'is_chain',
        'google_review',
        'pyszne_pl_link',
        'pyszne_pl_review'
    ];

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
        return $this->belongsToMany(MeatType::class, 'kebab_meat_types');
    }
    public function orderWay()
    {
        return $this->hasMany(OrderWay::class);
    }
    public function sauces()
    {
        return $this->belongsToMany(SauceType::class, 'kebab_sauces');
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
        return $this->belongsToMany(User::class, 'favourite_kebabs');
    }
}
