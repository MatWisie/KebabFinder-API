<?php

namespace App\Http\Controllers\Api;

use App\Models\Kebab;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;

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

    public function getCommentsByKebabId(Kebab $kebab): JsonResponse
    {
        $comments = $kebab->comments()->with('user:id,name')->get();

        return response()->json($comments);
    }

    public function adminRemoveComment(Comment $comment): JsonResponse
    {
        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully by admin'], 204);
    }
}
