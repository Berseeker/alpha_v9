<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\Actualizar\ActualizarController;
use App\Http\Controllers\API\Proveedores\forPromotionalController;
use App\Http\Controllers\API\Proveedores\DobleVelaController;
use App\Http\Controllers\API\Proveedores\InnovationController;
use App\Http\Controllers\API\Proveedores\PromoOpcionController;
use App\Http\Controllers\API\Cotizaciones\CotizacionController;
use App\Http\Controllers\API\Productos\ProductoController;
use App\Http\Controllers\API\Ventas\VentasController;
use App\Http\Controllers\API\Buscador\BuscadorController;
use App\Http\Controllers\API\Slug\SlugController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('for-promotional',[forPromotionalController::class,'index']);
Route::get('innova-productos',[InnovationController::class,'index']);
Route::get('doble-vela',[DobleVelaController::class,'index']);
Route::get('doble-vela-update-imgs',[DobleVelaController::class,'update']);
Route::get('promoopcion',[PromoOpcionController::class,'index']);


Route::get('slug-categorias',[SlugController::class,'categoriaSlug']);
Route::get('slug-subcategorias',[SlugController::class,'subcategoriaSlug']);
Route::get('slug-productos',[SlugController::class,'productoSlug']);


Route::get('all-products',[ProductoController::class,'index']);
Route::get('producto/{sdk}',[ProductoController::class,'producto']);


Route::post('store-cotizacion',[CotizacionController::class,'store']);
Route::post('update-cotizacion/{id}',[CotizacionController::class,'update']);
Route::post('delete-cotizacion/{id}',[CotizacionController::class,'delete']);
Route::get('all-cotizaciones',[CotizacionController::class,'index']);


Route::get('all-ventas',[VentasController::class,'index']);

Route::get('search-productos/{search}',[BuscadorController::class,'search']);

Route::get('update-null-items',[ActualizarController::class,'index']);
Route::get('restore-null-items',[ActualizarController::class,'restore']);

Route::get('get-subcategorias/{id}',[BuscadorController::class,'getSubcategorias']);