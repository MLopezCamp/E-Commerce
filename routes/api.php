<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/user/{id}', function (Request $request, string $id) {
    return 'User '.$id;
});
// Productos
Route::get('/productos', [ProductoController::class, 'index']);      // Listar productos
Route::get('/productos/{id}', [ProductoController::class, 'show']);  // Mostrar producto por ID
Route::post('/productos', [ProductoController::class, 'store']);     // Crear producto
Route::put('/productos/{id}', [ProductoController::class, 'update']); // Actualizar producto
Route::delete('/productos/{id}', [ProductoController::class, 'destroy']); // Eliminar producto

// Categorías 
Route::get('/categorias', [CategoriaController::class, 'index']);
Route::get('/categorias/{id}', [CategoriaController::class, 'show']);
Route::post('/categorias', [CategoriaController::class, 'store']);
Route::put('/categorias/{id}', [CategoriaController::class, 'update']);
Route::delete('/categorias/{id}', [CategoriaController::class, 'destroy']);

//Paginacion
Route::get('/productos/paginacion', [ProductoController::class, 'paginarPorCantidad']);
Route::get('/productos/paginacion-avanzada', [ProductoController::class, 'paginarPorCantidadYPagina']);
 //Actualizar segun cantidad ingresada
 Route::put('/productos/{id}/actualizar-stock', [ProductoController::class, 'actualizarStock']);
