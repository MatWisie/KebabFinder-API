<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KebabSocialMedia extends Model
{
    protected $fillable = [
        'kebab_id',
        'social_media_link',
    ];

    public function kebab()
    {
        return $this->belongsTo(Kebab::class);
    }
}
