<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

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
Route::get('/categorias',[App\Http\Controllers\WEB\Home\IndexController::class, 'showCategorias'])->name('home.categorias');
Route::get('{categoria}/subcategoria/{slug}',[App\Http\Controllers\WEB\Home\IndexController::class, 'showSubcategoria'])->name('home.subcategoria');
Route::get('/producto/{slug}',[App\Http\Controllers\WEB\Home\IndexController::class, 'showProducto'])->name('home.producto');
Route::post('/newsletter',[App\Http\Controllers\WEB\Home\IndexController::class, 'newsletter'])->name('home.newsletter');

Route::get('/busqueda/{producto}',[App\Http\Controllers\WEB\Home\IndexController::class, 'search'])->name('home.busqueda');
Route::get('/cotizacion-producto',[App\Http\Controllers\WEB\Home\CotizacionController::class, 'index'])->name('home.cotizacion');
Route::post('/cotizacion-producto',[App\Http\Controllers\WEB\Home\CotizacionController::class, 'store'])->name('home.store.cotizacion');
Route::get('/contacto',[App\Http\Controllers\WEB\Home\IndexController::class, 'contacto'])->name('home.contacto');
Route::post('/contacto',[App\Http\Controllers\WEB\Home\IndexController::class, 'sendMessage'])->name('home.sendMsg');
Route::get('/servicios',[App\Http\Controllers\WEB\Home\IndexController::class, 'servicios'])->name('home.servicios');
Route::get('/displays',[App\Http\Controllers\WEB\Home\LineaAlphaController::class, 'displays'])->name('home.displays');
Route::get('/linea-alpha',[App\Http\Controllers\WEB\Home\LineaAlphaController::class, 'hats'])->name('home.linea.alpha');
Route::post('/linea-alpha',[App\Http\Controllers\WEB\Home\LineaAlphaController::class, 'hatCotizacion']);





/* RUTAS DE LOS PRODUCTOS EN EL DASHBOARD */
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/dashboard/productos', [App\Http\Controllers\WEB\Dashboard\ProductoController::class, 'index'])->name('dashboard.productos');
Route::get('/dashboard/delete-product/{id}', [App\Http\Controllers\WEB\Dashboard\ProductoController::class, 'delete'])->name('dashboard.delete.producto');
Route::get('/dashboard/edit-product/{id}', [App\Http\Controllers\WEB\Dashboard\ProductoController::class, 'edit'])->name('dashboard.edit.producto');
Route::post('/dashboard/edit-product/{id}', [App\Http\Controllers\WEB\Dashboard\ProductoController::class, 'update'])->name('dashboard.update.producto');
Route::get('/dashboard/store-product', [App\Http\Controllers\WEB\Dashboard\ProductoController::class, 'create'])->name('dashboard.add.producto');
Route::post('/dashboard/store-product', [App\Http\Controllers\WEB\Dashboard\ProductoController::class, 'store'])->name('dashboard.store.producto');



Route::get('/dashboard/cotizaciones',[App\Http\Controllers\WEB\Dashboard\CotizacionController::class, 'index'])->name('dashboard.cotizaciones');
Route::get('/dashboard/show-cotizacion/{id}',[App\Http\Controllers\WEB\Dashboard\CotizacionController::class, 'show'])->name('dashboard.cotizacion');
Route::get('/dashboard/edit-cotizacion/{id}',[App\Http\Controllers\WEB\Dashboard\CotizacionController::class, 'edit'])->name('dashboard.edit.cotizacion');
Route::post('/dashboard/edit-cotizacion/{id}',[App\Http\Controllers\WEB\Dashboard\CotizacionController::class, 'update'])->name('dashboard.update.cotizacion');
Route::get('/dashboard/edit-cotizacion-invoice/{order_id}',[App\Http\Controllers\WEB\Dashboard\CotizacionController::class, 'editInvoice'])->name('dashboard.edit.cotizacion.invoice');
Route::post('/dashboard/edit-cotizacion-invoice/{order_id}',[App\Http\Controllers\WEB\Dashboard\CotizacionController::class, 'updateInvoice'])->name('dashboard.update.cotizacion.invoice');
Route::post('/dashboard/cotizacion/update-quick',[App\Http\Controllers\WEB\Dashboard\CotizacionController::class, 'updateQuick'])->name('dashboard.update_quick.cotizacion');
Route::get('/dashboard/download-file/{id}',[App\Http\Controllers\WEB\Dashboard\CotizacionController::class, 'download'])->name('dashboard.download.file');
Route::get('/dashboard/download-cotizacion/{id}',[App\Http\Controllers\WEB\Dashboard\CotizacionController::class, 'preview'])->name('dashboard.download.cotizacion');
Route::get('/dashboard/print-cotizacion/{id}',[App\Http\Controllers\WEB\Dashboard\CotizacionController::class, 'invoice_print'])->name('dashboard.print.cotizacion');
Route::get('/dashboard/order-invoice/{id}',[App\Http\Controllers\WEB\Dashboard\CotizacionController::class, 'invoice'])->name('dashboard.order.invoice');
Route::get('/dashboard/delete-order-product/{order_id}/{product_id}',[App\Http\Controllers\WEB\Dashboard\CotizacionController::class, 'deleteOrderProduct']);
Route::post('/dashboard/update-cotizacion-add-product', [App\Http\Controllers\WEB\Dashboard\CotizacionController::class, 'addProduct'])->name('dashboard.add.producto');


Route::get('/dashboard/ventas',[App\Http\Controllers\WEB\Dashboard\VentaController::class, 'index'])->name('dashboard.ventas');

Route::get('/test-command', function () {
    $exitCode = Artisan::call('sitemap:generate');
});






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


