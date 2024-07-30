<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Resources\TagResource;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TagController extends Controller
{
    public function index()
    {
        return TagResource::collection(Tag::with('posts')->paginate());
    }

    public function store(StoreTagRequest $request)
    {
        $tag = Tag::create([
            'name' => $request->name,
        ]);

        return new TagResource($tag->load('posts'));
    }

    public function show($id)
    {
        try {
            $tag = Tag::with('posts')->findOrFail($id);
            return new TagResource($tag);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Tag not found'], 404);
        }

    }

    public function update(UpdateTagRequest $request, $id)
    {
        try {
            $tag=Tag::findorFail($id);
            if ($request->has('name')) {
                $tag->name = $request->name;
            }

            $tag->save();

            return new TagResource($tag->load('posts'));
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Tag not found'], 404);
        }

    }

    public function destroy($id)
    {
        try {
            $tag=Tag::findorFail($id);
            $tag->delete();
            return response()->json(['message' => 'Tag deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Tag not found'], 404);
        }

    }
}
