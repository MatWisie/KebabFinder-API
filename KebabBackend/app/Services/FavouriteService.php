<?php

namespace App\Services;

use App\Models\Kebab;
use App\Models\User;

class FavouriteService
{
    /**
     * Add a kebab to the user's favourites.
     */
    public function addFavourite(User $user, Kebab $kebab): bool
    {
        if ($this->isFavourite($user, $kebab)) {
            return false;
        }

        $user->favouriteKebabs()->attach($kebab->id);
        return true;
    }

}
