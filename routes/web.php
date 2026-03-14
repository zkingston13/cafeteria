<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductosController;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/','inicio');
Route::view('/registro', 'registro');
Route::view('/contacto','contacto');
Route::view('/nosotros','nosotros');




Route::get('/productos',[ProductosController::class,'index']);
Route::get('/detalle/{id_producto}',[ProductosController::class,'show']);

