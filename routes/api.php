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
use App\Http\Controllers\API\Users\UserController;


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

#v2 APIS PROVIDERS
Route::get('new-innova-v2',[InnovationController::class,'v2']); // Solo se puede testear en PROD
Route::get('new-promoopcion-v2', [PromoOpcionController::class, 'v2']);
Route::get('forpromotional-v2',[forPromotionalController::class,'v2']);
Route::get('doblevela-v2',[DobleVelaController::class,'v2']);
Route::get('doblevela-imgs-v2',[DobleVelaController::class,'imgsV2']);
Route::get('doblevela-images-v2',[DobleVelaController::class,'updateImgV2']);
Route::get('doblevela-count-images-v2',[DobleVelaController::class,'empty']);
Route::get('doblevela-test-product',[DobleVelaController::class,'test']);



Route::get('slug-categorias',[SlugController::class,'categoriaSlug']);
Route::get('slug-subcategorias',[SlugController::class,'subcategoriaSlug']);
Route::get('slug-productos',[SlugController::class,'productoSlug']);
Route::get('slug-productos-v2',[SlugController::class,'productoV2Slug']);


Route::get('all-products',[ProductoController::class,'index']);
Route::get('producto/{sdk}',[ProductoController::class,'producto']);
Route::get('producto-slug/{slug}',[ProductoController::class,'slug']);
Route::get('searc-producto/{string}',[ProductoController::class,'slug']);


Route::post('store-cotizacion',[CotizacionController::class,'store']);
Route::post('update-cotizacion/{id}',[CotizacionController::class,'update']);
Route::post('delete-cotizacion/{id}',[CotizacionController::class,'delete']);
Route::get('all-cotizaciones',[CotizacionController::class,'index']);


Route::get('all-ventas',[VentasController::class,'index']);

Route::get('search-productos/{search}',[BuscadorController::class,'search']);

Route::get('update-null-items',[ActualizarController::class,'index']);
Route::get('restore-null-items',[ActualizarController::class,'restore']);

Route::get('get-subcategorias/{id}',[BuscadorController::class,'getSubcategorias']);


Route::get('get-users',[UserController::class,'empleados']);

#Searchable ALGOLIA
Route::get('search/{phrase}', [BuscadorController::class, 'buscador']);