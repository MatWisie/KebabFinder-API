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

    /**
     * Remove a kebab from the user's favourites.
     */
    public function removeFavourite(User $user, Kebab $kebab): bool
    {
        if (!$this->isFavourite($user, $kebab)) {
            return false;
        }

        $user->favouriteKebabs()->detach($kebab->id);
        return true;
    }

    /**
     * Get the user's favourite kebabs.
     */
    public function getFavourites(User $user)
    {
        return $user->favouriteKebabs()->select('name')->get();
    }

    /**
     * Check if a kebab is in the user's favourites.
     */
    public function isFavourite(User $user, Kebab $kebab): bool
    {
        return $user->favouriteKebabs()->where('kebab_id', $kebab->id)->exists();
    }
}
