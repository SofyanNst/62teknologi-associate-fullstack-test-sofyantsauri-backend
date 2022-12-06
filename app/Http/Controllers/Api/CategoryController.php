<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'List Data Category',
            'data'    => $categories  
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        $restaurant = Category::create([
            'name'     => $request->name,
        ]);

        if($restaurant) {

            return response()->json([
                'success' => true,
                'message' => 'Category Created',
                'data'    => $restaurant  
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'Category Failed to Save',
        ], 409);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::findOrfail($id);

        return response()->json([
            'success' => true,
            'message' => 'Detail Data Category',
            'data'    => $category 
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {

        $validator = Validator::make($request->all(), [
            'name'    => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $category = Category::findOrFail($category->id);

        if($category) {

            $category->update([
            'name'     => $request->name,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Post Updated',
                'data'    => $category  
            ], 200);

        }

        return response()->json([
            'success' => false,
            'message' => 'Post Not Found',
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $category = Category::findOrfail($id);

        if($category) {


            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Category Deleted',
            ], 200);

        }

        return response()->json([
            'success' => false,
            'message' => 'Category Not Found',
        ], 404);
    }
}
