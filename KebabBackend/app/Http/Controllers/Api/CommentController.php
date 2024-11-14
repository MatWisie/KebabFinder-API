<?php

namespace App\Http\Controllers\Api;


class CommentController extends Controller
{
    public function addComment(Request $request, Kebab $kebab): JsonResponse
    {
        $validated = $request->validated();

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
        ]);

        $kebab->comments()->save($comment);

        return response()->json(['message' => 'Comment added successfully', 'comment' => $comment], 201);
    }

    public function removeComment(Comment $comment): JsonResponse
    {
        if ($comment->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully'], 204);
    }

}
