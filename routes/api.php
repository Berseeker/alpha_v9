<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\Proveedores\forPromotionalController;
use App\Http\Controllers\API\Proveedores\DobleVelaController;
use App\Http\Controllers\API\Proveedores\InnovationController;
use App\Http\Controllers\API\Proveedores\PromoOpcionController;
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
Route::get('innovation',[InnovationController::class,'index']);
Route::get('doble-vela',[DobleVelaController::class,'index']);
Route::get('doble-vela-update-imgs',[DobleVelaController::class,'update']);
Route::get('promoopcion',[PromoOpcionController::class,'index']);


Route::get('slug-categorias',[SlugController::class,'categoriaSlug']);
Route::get('slug-subcategorias',[SlugController::class,'subcategoriaSlug']);
Route::get('slug-productos',[SlugController::class,'productoSlug']);


