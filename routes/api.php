<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CurrentAccountController;



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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/articulos', 'App\Http\Controllers\ArticuloControllers@index'); // mostrar todos los registros
// Route::post('/articulos', 'App\Http\Controllers\ArticuloControllers@store'); // crear un registro
// Route::put('/articulos/{id}', 'App\Http\Controllers\ArticuloControllers@update'); // actualizar un registro
// Route::delete('/articulos/{id}', 'App\Http\Controllers\ArticuloControllers@destroy'); // crear un registro




Route::group(['middleware' => ['web']], function () {
    // your routes here
    // LOGIN
    // Route::post('/login', [LoginController::class, 'login']);

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });


    // USUARIOS
    Route::get('/usuario/obtenerTodos', [UserController::class,'getTodos']);
    Route::post('/usuario/crear', [UserController::class,'crear']);
    Route::post('/usuario/crearUsuarioProveedor', [UserController::class,'crearUsuarioProveedor']);
    Route::get('/usuario/obtenerDatos/{id}', [UserController::class,'getDatos']);
    Route::post('/usuario/obtenerDatosUsuarioLogin', [UserController::class,'getDatosUsuarioLogin']);
    Route::put('/usuario/actualizar/{id}', [UserController::class,'actualizar']);
    Route::delete('/usuario/eliminar/{id}', [UserController::class,'eliminar']);

    // PRODUCTOS
    Route::get('/producto/obtenerTodos', [ProductController::class,'getTodos']);
    Route::post('/producto/crear', [ProductController::class,'crear']);
    Route::post('/producto/actualizar', [ProductController::class,'actualizar']);
    Route::get('/producto/obtenerDatos/{id}', [ProductController::class,'getDatos']);

    // CLIENTES
    Route::get('/cliente/obtenerTodos', [ClientController::class,'getTodos']);
    Route::get('/cliente/obtenerDatos/{id}', [ClientController::class,'getDatos']);
    Route::post('/cliente/crear', [ClientController::class,'crear']);
    Route::put('/cliente/actualizar/{id}', [ClientController::class,'actualizar']);


    // VENTAS
    Route::get('/venta/obtenerTodos', [SaleController::class,'getTodos']);
    Route::post('/venta/crear', [SaleController::class,'crear']);
    Route::get('/venta/obtenerDatos/{id}', [SaleController::class,'getDatos']);
    Route::get('/venta/exportarPDF/{id}', [SaleController::class,'exportarPDF']);
    Route::get('/venta/datosWhatsApp/{id}', [SaleController::class,'datosWhatsApp']);
    Route::post('/venta/enviarMail', [SaleController::class,'enviarMail']);


    // CUENTA CORRIENTE
    Route::get('/cuentacorriente/obtenerTodos', [CurrentAccountController::class,'getTodos']);
    Route::get('/cuentacorriente/obtenerDatos/{id}', [CurrentAccountController::class,'getDatos']);
    Route::post('/cuentacorriente/nuevoPagoCliente', [CurrentAccountController::class,'nuevoPagoCliente']);
    Route::get('/cuentacorriente/exportarPDF/{id}', [CurrentAccountController::class,'exportarPDF']);
    Route::get('/cuentacorriente/datosWhatsApp/{id}', [CurrentAccountController::class,'datosWhatsApp']);
    Route::post('/cuentacorriente/enviarMail', [CurrentAccountController::class,'enviarMail']);

    
    // MI CUENTA
    Route::get('/mi-cuenta/obtenerDatos/{id}', [LoginController::class,'getDatos']);
});
