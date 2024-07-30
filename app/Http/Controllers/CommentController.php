<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CommentResource;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;

class CommentController extends Controller
{
    public function index(Request $request){
        $comments = Comment::with(['author', 'commentable'])->paginate();
        return CommentResource::collection($comments);
    }

    public function store(StoreCommentRequest $request){
        try {
            DB::beginTransaction();

            $post = Post::findOrFail($request->post_id);

            $comment = $post->comments()->create([
                'body' => $request->body,
                'user_id' => Auth::id(),
            ]);

            DB::commit();

            return new CommentResource($comment);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Unable to create comment',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id){
        try {
            $comment = Comment::findOrFail($id)->load(['author', 'commentable']);
            return new CommentResource($comment);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Unable to load comment',
            ], 404);
        }
    }


    public function update(UpdateCommentRequest $request,$id){
        try {
            $comment = Comment::findOrFail($id);

            if ($request->user()->cannot('update', $comment)) {
                return response()->json(['message' => 'unauthorized action'], 403);
            }

            if ($request->has('body')) {
                $comment->body = $request->body;
            }

            $comment->save();

            return new CommentResource($comment);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Comment not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $comment = Comment::findOrFail($id);

            if (auth()->user()->cannot('update', $comment)) {
                return response()->json(['message' => 'unauthorized action'], 403);
            }

            $comment->delete();

            return response()->json(['message' => 'Comment deleted successfully']);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Comment not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }
}
