<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'status' => 200,
            'message' => 'User created successfully!',
            'data' => Category::where('parent_id', null)->withCount(['subcategories'])->get(),
            'listCategory' => Category::where('parent_id', null)->get(),
        ], 200);
    }

    public function show(Request $request, Category $category)
    {
        return response()->json([
            'status' => 200,
            'message' => 'User created successfully!',
            'data' => Category::where('parent_id', $category->id)->with('category')->get(),
            'listCategory' => Category::where('parent_id', null)->get(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate Data
        $request->validate([
//            'name' => 'required|string|max:255',
            'name' => 'sometimes|required',
        ]);
        if (Category::where(['name' => $request->name, 'parent_id' => $request->parent_id])->count() > 0) {
            return response()->json([
                'status' => 422,
                'message' => 'Some error occurred . Please try again!',
                'errors' => (object)['name' => ['The name has already been taken.']],
            ], 422);
        }
        //Set Data Object
        $category = new Category();
        $category->name = $request->name;
        $category->parent_id = $request->parent_id;
        //Check status HTTP
        if ($category->save()) {
            return response()->json([
                'status' => 200,
                'message' => 'User created successfully!',
                'data' => Category::with('category')->withCount(['subcategories'])->orderBy('id', 'desc')->get(),
                'listCategory' => Category::where('parent_id', null)->get(),
            ], 200);
        }
        return response()->json([
            'status' => 500,
            'message' => 'Some error occurred . Please try again!',
            'data' => Category::with('category')->orderBy('id', 'desc')->get(),
            'listCategory' => Category::where('parent_id', null)->get(),
        ], 500);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //Validate Data
        $request->validate([
            'name' => 'required | string | max:255',
        ]);
        if (Category::where(['name' => $request->name, 'parent_id' => $request->parent_id])->whereNotIn('id', [$category->id])->count() > 0) {
            return response()->json([
                'status' => 422,
                'message' => 'Some error occurred . Please try again!',
                'errors' => (object)['name' => ['The name has already been taken.']],
            ], 422);
        }
        if (empty($category->parent_category)) {
            $data = Category::with('category')->where('parent_id', $category->parent_category)->orderBy('id', 'desc')->get();
        } else {
            $data = Category::where('parent_id', null)->withCount(['subcategories'])->get();
        }
        //Set Data Object
        $category->name = $request->name;
        $category->parent_id = $request->parent_id;
        //Check status HTTP
        if ($category->save()) {
            return response()->json([
                'status' => 200,
                'message' => 'Category updated successfully!',
                'data' => $data,
            ], 200);
        }
        return response()->json([
            'status' => 500,
            'message' => 'Some error occurred . Please try again!',
            'data' => Category::with('category')->orderBy('id', 'desc')->get(),
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($category->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'Category deleted successfully!',
                'data' => Category::with('category')->get(),
            ], 200);
        }
        return response()->json([
            'status' => 500,
            'message' => 'Some error occurred . Please try again!',
            'data' => Category::with('category')->get(),
        ], 500);
    }
}
