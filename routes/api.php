<?php

use App\Http\Controllers\API\UserController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\SingUpMiddleware;
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

});