<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {        
        try {

            $categories = Category::all();

            return response()->json([
                'error'=>false,
                'message'=> 'The Category recevied on successful', 
                'data' => $categories
            ], 200); 

        } catch (\Throwable $e) {
            return response()->json([
                'error'=>true,
                'message' => 'Request failed, please try again',
                'data' => $e,
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            
            DB::beginTransaction();

            $category = Category::create([
                'nameCategory' => $request->nameCategory,
                'descriptionCategory' => $request->descriptionCategory ? $request->descriptionCategory : '',
                'imgCategory' => $request->file('imgCategory') ? $request->file('imgCategory')->store('img', 'public') : '',
            ]);

            DB::commit();
            return response()->json([
                'error'=>false,
                'message'=> 'Category created successfully', 
                'data'=>$category
            ], 200);
            
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'error'=>true,
                'message' => 'Request failed, please try again',
                'data' => $th->getMessage(),
            ], 400);        
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
