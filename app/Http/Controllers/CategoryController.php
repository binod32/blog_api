<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller
{
    public function __construct()
    {
        if (!Gate::allows('admin')) {
            $this->middleware('admin');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('posts')->paginate();
        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create([
            'name' => $request->name,
        ]);

        return new CategoryResource($category->load('posts'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $category = Category::with('posts')->findOrFail($id);
            return new CategoryResource($category);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Category not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->update([
                'name' => $request->name
            ]);

            return new CategoryResource($category->load('posts'));
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Category not found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return response()->json(['message' => 'Category deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Category not found'], 404);
        }
    }
}
