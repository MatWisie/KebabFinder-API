<?php

namespace App\Http\Controllers\Api;

use App\Models\Kebab;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Http\Requests\CommentRequest;
use App\Services\CommentService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentController extends Controller
{
    use AuthorizesRequests;

    protected CommentService $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
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
        $comments = $this->commentService->getUserComments();

        return response()->json($comments);
    }

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
     *     @OA\Response(response=422, description="Unprocessable Content"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function addComment(CommentRequest $request, Kebab $kebab): JsonResponse
    {
        $validated = $request->validated();

        $comment = $this->commentService->addComment($kebab, $validated['content']);

        return response()->json(['message' => 'Comment added successfully', 'comment' => $comment], 201);
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
    public function editComment(CommentRequest $request, Comment $comment): JsonResponse
    {
        $this->authorize('update', $comment);

        $validated = $request->validated();

        $updatedComment = $this->commentService->updateComment($comment, $validated['content']);

        return response()->json([
            'message' => 'Comment updated successfully',
            'comment' => $updatedComment,
        ], 200);
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
        $this->authorize('delete', $comment);

        $this->commentService->deleteComment($comment);

        return response()->json(['message' => 'Comment deleted successfully'], 204);
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
        $comments = $this->commentService->getCommentsByKebabId($kebab);

        return response()->json($comments);
    }

    /**
     * Admin can remove any comment.
     *
     * @OA\Delete(
     *     path="/admin/delete-comment/{comment}",
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
        $this->authorize('delete', $comment);

        $this->commentService->deleteComment($comment);

        return response()->json(['message' => 'Comment deleted successfully by admin'], 204);
    }
}
