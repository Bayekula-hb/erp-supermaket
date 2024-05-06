<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {     
        try {   
            $products = Product::all();

            return response()->json([
                'error'=>false,
                'message'=> 'The product recevied on successful', 
                'data' => $products
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
            $products_created = [];

            foreach ($request->productList as $product) {
                
                $product = Product::create([
                    'nameProduct' => $product['nameProduct'],
                    'descriptionProduct' => $product['descriptionProduct'],
                    'category_id' => $product['category_id'],
                    'imgProduct' => $request->file('imgProduct') ? $request->file('imgProduct')->store('img', 'public') : '',
                ]);
                array_push($products_created, $product);
            }

            DB::commit();
            return response()->json([
                'error'=>false,
                'message'=> 'Products created successfully', 
                'data'=>$products_created
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
