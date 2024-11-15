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
    /**
     * Add a new comment to a specific kebab.
     *
     * @OA\Post(
     *     path="/kebabs/{kebab}/comments",
     *     summary="Add a new comment to a kebab",
     *     tags={"Comments"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="kebab",
     *         in="path",
     *         required=true,
     *         description="ID of the kebab",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="content", type="string", example="Great kebab!")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Comment added successfully"),
     *     @OA\Response(response=400, description="Validation error"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
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

    /**
     * Remove a comment belonging to the authenticated user.
     *
     * @OA\Delete(
     *     path="/user/comments/{comment}",
     *     summary="Remove user's comment",
     *     tags={"Comments"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="comment",
     *         in="path",
     *         required=true,
     *         description="ID of the comment",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Comment deleted successfully"),
     *     @OA\Response(response=403, description="Unauthorized"),
     *     @OA\Response(response=404, description="Comment not found")
     * )
     */
    public function removeComment(Comment $comment): JsonResponse
    {
        if ($comment->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully'], 204);
    }

    /**
     * Edit a comment belonging to the authenticated user.
     *
     * @OA\Put(
     *     path="/user/comments/{comment}",
     *     summary="Edit user's comment",
     *     tags={"Comments"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="comment",
     *         in="path",
     *         required=true,
     *         description="ID of the comment",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="content", type="string", example="Updated comment text")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Comment updated successfully"),
     *     @OA\Response(response=403, description="Unauthorized"),
     *     @OA\Response(response=404, description="Comment not found")
     * )
     */
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

    /**
     * Get all comments belonging to the authenticated user.
     *
     * @OA\Get(
     *     path="/user/comments",
     *     summary="Get all user's comments",
     *     tags={"Comments"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, description="List of comments"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function getUserComments(): JsonResponse
    {
        $comments = Comment::where('user_id', Auth::id())->get();

        return response()->json($comments);
    }

    /**
     * Get all comments for a specific kebab.
     *
     * @OA\Get(
     *     path="/kebabs/{kebab}/comments",
     *     summary="Get all comments for a specific kebab",
     *     tags={"Comments"},
     *     @OA\Parameter(
     *         name="kebab",
     *         in="path",
     *         required=true,
     *         description="ID of the kebab",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="List of comments"),
     *     @OA\Response(response=404, description="Kebab not found")
     * )
     */
    public function getCommentsByKebabId(Kebab $kebab): JsonResponse
    {
        $comments = $kebab->comments()->with('user:id,name')->get();

        return response()->json($comments);
    }

    /**
     * Admin can remove any comment.
     *
     * @OA\Delete(
     *     path="/comments/{comment}/admin",
     *     summary="Admin can remove any comment",
     *     tags={"Comments"},
     *     security={{"sanctum":{}, "admin":{}}},
     *     @OA\Parameter(
     *         name="comment",
     *         in="path",
     *         required=true,
     *         description="ID of the comment",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Comment deleted successfully"),
     *     @OA\Response(response=403, description="Unauthorized"),
     *     @OA\Response(response=404, description="Comment not found")
     * )
     */
    public function adminRemoveComment(Comment $comment): JsonResponse
    {
        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully by admin'], 204);
    }
}
