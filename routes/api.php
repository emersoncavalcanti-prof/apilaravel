<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/produtos',function (){
    $produtos = [
        [
            'id' => 1,
            'nome' => 'Produto 1',
            'preco' => 10.99
        ],
        [
            'id' => 2,
            'nome' => 'Produto 2',
            'preco' => 20.99
        ],
        [
            'id' => 3,
            'nome' => 'Produto 3',
            'preco' => 30.99
        ]
    ];
    return response()->json($produtos);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
