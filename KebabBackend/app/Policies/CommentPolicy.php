<?php

namespace App\Policies;

class CommentPolicy
{
    /**
     * Determine if the authenticated user can edit a comment.
     */
    public function update(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id;
    }
}
