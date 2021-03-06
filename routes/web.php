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
Route::post('/ver-cotizacion',[App\Http\Controllers\WEB\Home\CotizacionController::class, 'store'])->name('home.cotizacion');
Route::get('/contacto',[App\Http\Controllers\WEB\Home\IndexController::class, 'contacto'])->name('home.contacto');
Route::post('/contacto',[App\Http\Controllers\WEB\Home\IndexController::class, 'sendMessage'])->name('home.contacto');
Route::get('/servicios',[App\Http\Controllers\WEB\Home\IndexController::class, 'servicios'])->name('home.servicios');
Route::get('/displays',[App\Http\Controllers\WEB\Home\IndexController::class, 'displays'])->name('home.displays');





/* RUTAS DE LOS PRODUCTOS EN EL DASHBOARD */
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/dashboard/productos', [App\Http\Controllers\WEB\Dashboard\ProductoController::class, 'index'])->name('dashboard.productos');
Route::get('/dashboard/delete-product/{id}', [App\Http\Controllers\WEB\Dashboard\ProductoController::class, 'delete'])->name('dashboard.delete.producto');
Route::get('/dashboard/edit-product/{id}', [App\Http\Controllers\WEB\Dashboard\ProductoController::class, 'edit'])->name('dashboard.edit.producto');
Route::post('/dashboard/edit-product/{id}', [App\Http\Controllers\WEB\Dashboard\ProductoController::class, 'update'])->name('dashboard.update.producto');



Route::get('/dashboard/cotizaciones',[App\Http\Controllers\WEB\Dashboard\CotizacionController::class, 'index'])->name('dashboard.cotizaciones');
Route::get('/dashboard/show-cotizacion/{id}',[App\Http\Controllers\WEB\Dashboard\CotizacionController::class, 'show'])->name('dashboard.cotizacion');
Route::get('/dashboard/edit-cotizacion/{id}',[App\Http\Controllers\WEB\Dashboard\CotizacionController::class, 'edit'])->name('dashboard.edit.cotizacion');
Route::post('/dashboard/edit-cotizacion/{id}',[App\Http\Controllers\WEB\Dashboard\CotizacionController::class, 'update'])->name('dashboard.update.cotizacion');
Route::get('/dashboard/download-file/{id}',[App\Http\Controllers\WEB\Dashboard\CotizacionController::class, 'download'])->name('dashboard.download.file');
Route::get('/dashboard/download-cotizacion/{id}',[App\Http\Controllers\WEB\Dashboard\CotizacionController::class, 'preview'])->name('dashboard.download.cotizacion');
Route::get('/dashboard/print-cotizacion/{id}',[App\Http\Controllers\WEB\Dashboard\CotizacionController::class, 'invoice_print'])->name('dashboard.print.cotizacion');


Route::get('/dashboard/ventas',[App\Http\Controllers\WEB\Dashboard\VentaController::class, 'index'])->name('dashboard.ventas');






//PROTECCION DE RUTAS CON PERMISOS PARA LA CREACION DE RECURSOS
Route::group(['middleware' => ['role:Admin|Supervisor|Empleado','permission:all|create']], function () {
    //RUTAS DE LAS IMAGENES
    Route::get('/dashboard/create-image',[App\Http\Controllers\WEB\Dashboard\ImageController::class, 'index'])->name('create.image');
    Route::post('/dashboard/create-image',[App\Http\Controllers\WEB\Dashboard\ImageController::class, 'store']);

    //RUTAS DE LOS USUARIOS
    Route::get('/dashboard/create-users',[App\Http\Controllers\WEB\Dashboard\Users\UserController::class, 'index'])->name('users.create');
    Route::post('/dashboard/create-users',[App\Http\Controllers\WEB\Dashboard\Users\UserController::class, 'store']);   
});

//PROTECCION DE RUTAS CON PERMISOS PARA LA ACTUALIZACION DE RECURSOS
Route::group(['middleware' => ['role:Admin|Supervisor|Empleado','permission:all|update']], function () {
    //RUTAS DE LAS IMAGENES
    Route::get('/dashboard/update-images',[App\Http\Controllers\WEB\Dashboard\ImageController::class, 'edit'])->name('update.images');
    Route::post('/dashboard/update-image/{id}',[App\Http\Controllers\WEB\Dashboard\ImageController::class, 'update']);

});



//PROTECCION DE RUTAS, SOLO  PARA ADMINS CON ROLES
Route::group(['middleware' => ['role:Admin|Supervisor']], function () {
    //RUTAS DE LOS ROLES Y EDICION DE USUARIOS
    Route::get('/dashboard/users',[App\Http\Controllers\WEB\Dashboard\Role\RoleController::class, 'index']);
    Route::post('/dashboard/update-user/{id}',[App\Http\Controllers\WEB\Dashboard\Role\RoleController::class, 'update']);
    //RUTAS DE LAS IMAGENES
    Route::get('/dashboard/delete-images/{id}',[App\Http\Controllers\WEB\Dashboard\ImageController::class, 'delete']);
    //RUTAS DE LOS USUARIOS
    Route::get('/dashboard/delete-users/{id}',[App\Http\Controllers\WEB\Dashboard\Users\UserController::class, 'delete']);

       
});


//CREACCION DE PRODUCTOS

Route::get('/dashboard/create-product', [App\Http\Controllers\WEB\Dashboard\ProductoController::class, 'create']);
Route::post('/dashboard/create-product', [App\Http\Controllers\WEB\Dashboard\ProductoController::class, 'store']);


