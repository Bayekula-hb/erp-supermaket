<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $succursale_id)
    {     
        try {   
            $products = Stock::select(
                                'stocks.id as stock_id',
                                'stocks.quantity as quantity',
                                'stocks.price as price',
                                'stocks.expiryDate as expiryDate',
                                'products.id as productId',
                                'products.nameProduct as nameProduct',
                                'products.imgProduct as imgProduct',
                                'products.descriptionProduct as descriptionProduct',
                                'categories.nameCategory as nameCategory',
                                'categories.descriptionCategory as descriptionCategory',
                                'categories.imgCategory as imgCategory',
                            )
                            ->join('products', 'products.id', '=' , 'stocks.product_id')
                            ->join('categories', 'categories.id', '=' , 'products.category_id')
                            ->where('stocks.succursale_id', $succursale_id)
                            ->get();

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
                
                $productCreated = Product::create([
                    'nameProduct' => $product['nameProduct'],
                    'descriptionProduct' => array_key_exists("descriptionProduct", $product) ? $product['descriptionProduct'] : '',
                    'category_id' => $product['category_id'],
                    'imgProduct' => $request->file('imgProduct') ? $request->file('imgProduct')->store('img', 'public') : '',
                ]);

                $stock = Stock::create([
                    'product_id' => $productCreated->id,
                    'succursale_id' => $product['succursale_id'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                    'expiryDate' => array_key_exists("expiryDate", $product) ? $product['expiryDate'] : null,
                ]);
                array_push($products_created, $productCreated);
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

    public function addStock(Request $request)
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
