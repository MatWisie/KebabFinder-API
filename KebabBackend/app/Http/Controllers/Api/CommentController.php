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

    public function editComment(Request $request, Comment $comment): JsonResponse
    {
        if ($comment->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'content' => 'required|string',
        ]);

        $comment->content = $request->input('content');
        $comment->save();

        return response()->json(['message' => 'Comment updated successfully', 'comment' => $comment], 200);
    }

    public function getUserComments(): JsonResponse
    {
        $comments = Comment::where('user_id', Auth::id())->get();

        return response()->json($comments);
    }

}
