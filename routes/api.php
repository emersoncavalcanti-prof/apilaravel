<?php

use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/registro', [UserController::class,'registro']);
Route::post('/login', [UserController::class,'login']);

Route::middleware('auth:sanctum')->group(function () {
    
    Route::apiResource('/produto',ProdutoController::class);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

