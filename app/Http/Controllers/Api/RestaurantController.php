<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $restaurants = Restaurant::latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'List Data Restaurant',
            'data'    => $restaurants  
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
            'category' => 'required', 
            'address' => 'required', 
            'detail' => 'required', 
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        $restaurant = Restaurant::create([
            'name'     => $request->name,
            'category' => $request->category,
            'address'  => $request->address,
            'detail'   => $request->detail,
        ]);

        if($restaurant) {

            return response()->json([
                'success' => true,
                'message' => 'Restaurant Created',
                'data'    => $restaurant  
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'Restaurant Failed to Save',
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
        $restaurant = Restaurant::findOrfail($id);

        return response()->json([
            'success' => true,
            'message' => 'Detail Data Restaurant',
            'data'    => $restaurant 
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
    public function update(Request $request, Restaurant $restaurant)
    {

        $validator = Validator::make($request->all(), [
            'name'    => 'required',
            'category' => 'required', 
            'address' => 'required', 
            'detail' => 'required', 
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $restaurant = Restaurant::findOrFail($restaurant->id);

        if($restaurant) {

            $restaurant->update([
            'name'     => $request->name,
            'category' => $request->category,
            'address'  => $request->address,
            'detail'   => $request->detail,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Post Updated',
                'data'    => $restaurant  
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
        $restaurant = Restaurant::findOrfail($id);

        if($restaurant) {


            $restaurant->delete();

            return response()->json([
                'success' => true,
                'message' => 'Restaurant Deleted',
            ], 200);

        }

        return response()->json([
            'success' => false,
            'message' => 'Restaurant Not Found',
        ], 404);
    }
}
