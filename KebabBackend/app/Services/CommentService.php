<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Kebab;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    public function addComment(Kebab $kebab, string $content): Comment
    {
        $comment = new Comment([
            'user_id' => Auth::id(),
            'content' => $content,
        ]);

        $kebab->comments()->save($comment);

        return $comment;
    }

    public function updateComment(Comment $comment, string $content): Comment
    {
        $comment->update(['content' => $content]);

        return $comment;
    }

    public function deleteComment(Comment $comment): void
    {
        $comment->delete();
    }

    public function getUserComments(): \Illuminate\Database\Eloquent\Collection
    {
        return Comment::where('user_id', Auth::id())->get();
    }

    public function getCommentsByKebabId(Kebab $kebab): \Illuminate\Database\Eloquent\Collection
    {
        return $kebab->comments()->with('user:id,name,is_admin')->get();
    }
}
