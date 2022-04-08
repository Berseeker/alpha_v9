<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/',[App\Http\Controllers\WEB\Home\IndexController::class, 'index'])->name('index');
Route::get('/categoria/{slug}',[App\Http\Controllers\WEB\Home\IndexController::class, 'showCategoria'])->name('home.categoria');
Route::get('/subcategoria/{slug}',[App\Http\Controllers\WEB\Home\IndexController::class, 'showSubcategoria'])->name('home.subcategoria');
Route::get('/producto/{slug}',[App\Http\Controllers\WEB\Home\IndexController::class, 'showProducto'])->name('home.producto');

Route::get('/busqueda-resultado',[App\Http\Controllers\WEB\Home\IndexController::class, 'busqueda'])->name('home.busqueda');
Route::get('/ver-cotizacion',[App\Http\Controllers\WEB\Home\CotizacionController::class, 'index'])->name('home.cotizacion');





/* RUTAS DE LOS PRODUCTOS EN EL DASHBOARD */
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/dashboard/productos', [App\Http\Controllers\WEB\Dashboard\ProductoController::class, 'index'])->name('dashboard.productos');
Route::get('/dashboard/delete-product/{id}', [App\Http\Controllers\WEB\Dashboard\ProductoController::class, 'delete'])->name('dashboard.delete.producto');
Route::get('/dashboard/edit-product/{id}', [App\Http\Controllers\WEB\Dashboard\ProductoController::class, 'edit'])->name('dashboard.delete.producto');

Route::get('/dashboard/cotizaciones',[App\Http\Controllers\WEB\Dashboard\CotizacionController::class, 'index'])->name('dashboard.cotizaciones');
Route::get('/dashboard/show-cotizacion/{id}',[App\Http\Controllers\WEB\Dashboard\CotizacionController::class, 'show'])->name('dashboard.cotizaciones');
Route::get('/dashboard/edit-cotizacion/{id}',[App\Http\Controllers\WEB\Dashboard\CotizacionController::class, 'edit'])->name('dashboard.edit.cotizacion');
Route::post('/dashboard/edit-cotizacion/{id}',[App\Http\Controllers\WEB\Dashboard\CotizacionController::class, 'update'])->name('dashboard.update.cotizacion');


Route::get('/dashboard/ventas',[App\Http\Controllers\WEB\Dashboard\VentaController::class, 'index'])->name('dashboard.ventas');