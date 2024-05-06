<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $succursale_id)
    {
        try {
            DB::beginTransaction();

            $stocks = Stock::where('succursale_id', $succursale_id)->get();
            
                        
            $productsSale = [];

            foreach ($request->productList as $product) {
                foreach ($stocks as $stock) {
                    if($product['product_id'] == $stock->product_id){

                        $saleCreated = Sale::create([
                            'quantity' => (integer) $product['quantity'],
                            'user_id' => $request->user()->id,
                            'stock_id' => $stock->id,
                            'succursale_id' => $succursale_id,
                        ]);
                        
                        $stock->quantity -= $product['quantity'];
                        $stock->save();

                        $productSale = Sale::select(
                                            'sales.id as saleId',
                                            'products.id as productId',
                                            'products.nameProduct as nameProduct',
                                            'products.imgProduct as imgProduct',
                                            'products.descriptionProduct as descriptionProduct',
                                            'sales.quantity as quantity',
                                            'sales.stock_id as stock_id',
                                            'stocks.price as price',
                                            'stocks.expiryDate as expiryDate',
                                        )
                                        ->where('sales.id', $saleCreated->id)
                                        ->join('stocks', 'stocks.id', '=', 'sales.stock_id')
                                        ->join('products', 'products.id', '=', 'stocks.product_id')
                                        ->first();
                        array_push($productsSale, $productSale);
                    }                        
                }
            }              

            DB::commit();
            return response()->json([
                'error'=>false,
                'message'=> 'Product.s salle with successfully', 
                'data'=> $productsSale
            ], 200); 
            return response()->json([
                'error'=>true,
                'message' => 'Request failed, because your are not access to sale stocks'
            ], 400);      
            
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
