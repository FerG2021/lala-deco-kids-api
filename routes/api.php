<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;





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
    Route::post('/producto/crear', [ProductController::class,'crear']);
    Route::get('/producto/obtenerTodos', [ProductController::class,'getTodos']);
    Route::get('/producto/obtenerDatos/{id}', [ProductController::class,'getDatos']);



    
    // MI CUENTA
    Route::get('/mi-cuenta/obtenerDatos/{id}', [LoginController::class,'getDatos']);







    


});
