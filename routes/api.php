<?php

use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\SuccursaleController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\StockController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\SingUpMiddleware;
use App\Http\Middleware\storeCategoryMiddleware;
use App\Http\Middleware\StoreProductMiddleware;
use App\Http\Middleware\storeStockMiddleware;
use App\Http\Middleware\StoreSuccuraleMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/', function (Request $request){
    return response()->json([
        'message' => 'Bienvenu sur l\'api de ERP-SUPERMARKET',
        'version' => 'C\'est la version beta de cet API merci',
        'Developpeur' => 'Developpée par hobedbayekula@gmail.com',
    ]);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->group(function () {

    //SingIn
    Route::post('/auth', [UserController::class, 'auth'])->middleware(AuthMiddleware::class);

    //SingUp
    Route::post('/singup', [UserController::class, 'singup'])->middleware(SingUpMiddleware::class);

    Route::prefix('')->middleware(['auth:sanctum'])->group(function () {

        Route::prefix("/succursale")->group(function ()
        {
            Route::get("", [SuccursaleController::class, 'index']);
            Route::post("", [SuccursaleController::class, 'store'])->middleware(StoreSuccuraleMiddleware::class);
        });

        Route::prefix("/products")->group(function ()
        {
            Route::get("", [ProductController::class, 'index']);
            Route::post("", [ProductController::class, 'store'])->middleware(StoreProductMiddleware::class);
        });

        Route::prefix("/category")->group(function ()
        {
            Route::get("", [CategoryController::class, 'index']);
            Route::post("", [CategoryController::class, 'store'])->middleware(storeCategoryMiddleware::class);
        });

        Route::prefix("/stock")->group(function ()
        {
            Route::get("/{succursale_id}", [StockController::class, 'index']);
            Route::post("", [StockController::class, 'store'])->middleware(storeStockMiddleware::class);
        });
    });

});