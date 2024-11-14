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

}
