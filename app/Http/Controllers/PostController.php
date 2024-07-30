<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request) {
        $posts = QueryBuilder::for(Post::class)
            ->allowedFilters(['title', 'author.name', 'category.name', 'tags.name'])
            ->paginate();

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $postData=$request->all();
        $postData['user_id']=Auth::id();
        $post = Post::create($postData);

        if ($request->has('tags')) {
            $post->tags()->attach($request->tags);
        }

        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $post = Post::findOrFail($id);
            return new PostResource($post->load(['author', 'category', 'tags','comments']));
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Post not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, $id)
    {
        try {
            $post = Post::findOrFail($id);

            if ($request->user()->cannot('update', $post)) {
                return response()->json(['message' => 'unauthorized action'], 403);
            }

            $post->fill($request->only(['title', 'body', 'category_id']));

            if ($request->has('tags')) {
                $post->tags()->sync($request->tags);
            }

            $post->save();

            return new PostResource($post);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Post not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $post = Post::findOrFail($id);

            if (auth()->user()->cannot('update', $post)) {
                return response()->json(['message' => 'unauthorized action'], 403);
            }

            $post->delete();

            return response()->json(['message' => 'Post deleted successfully']);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Post not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }
}
