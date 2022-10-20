<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UnidadMedidaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\RubroController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\DepositoArticuloController;
use App\Http\Controllers\ProveedorxrubroController;
use App\Http\Controllers\PrevisionController;
use App\Http\Controllers\VistaPrevisionController;
use App\Http\Controllers\PresupuestacionController;
use App\Http\Controllers\PresupuestacionProveedoresController;
use App\Http\Controllers\PresupuestacionProductosProveedoresController;
use App\Http\Controllers\CondicionPagoController;
use App\Http\Controllers\BorradorPresupuestacionController;
use App\Http\Controllers\OrdenCompraController;
use App\Http\Controllers\TransferenciaController;




use App\Http\Controllers\ProductoController;





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


    //PLANES
    Route::get('/plan/obtenerTodos', [PlanController::class,'getTodos']);
    Route::get('/plan/obtenerTodosSelect', [PlanController::class,'getTodosSelect']);
    Route::get('/plan/obtenerDatos/{id}', [PlanController::class,'getDatos']);



    
    //PRODUCTOS
    Route::get('/producto/obtenerTodos', [ProductoController::class,'getTodos']);
    Route::get('/producto/obtenerDatos/{id}', [ProductoController::class,'getDatos']);

    //PROVEEDORES
    Route::get('/proveedor/obtenerTodos', [ProveedorController::class,'getTodos']);
    // Route::get('/articulo/obtenerTodosSelect', [ArticuloController::class,'getTodosSelect']);
    Route::get('/proveedor/obtenerDatos/{id}', [ProveedorController::class,'getDatos']);
    Route::post('/proveedor/crear', [ProveedorController::class,'crear']);
    Route::post('/proveedor/actualizar', [ProveedorController::class,'actualizar']);
    // Route::delete('/articulo/eliminar/{id}', [ArticuloController::class,'destroy']);
 
    // RUBROS
    Route::get('/rubro/obtenerTodos', [RubroController::class,'getTodos']);
    Route::post('/rubro/crear', [RubroController::class,'crear']);
    Route::get('/rubro/obtenerTodosSelect', [RubroController::class,'getTodosSelect']);

    // DEPOSITOARTICULO
    Route::get('/depositoArticulo/obtenerDatos/{id}', [DepositoArticuloController::class,'getDatos']);

    // PREVISION
    Route::post('/prevision/obtenerCantidad', [PrevisionController::class,'getCantidadAPresupuestar']);

    // PROVEEDORXRUBRO
    Route::post('/proveedorxrubro/crear', [ProveedorxrubroController::class,'crear']);
    Route::get('/proveedorxrubro/obtenerTodos', [ProveedorxrubroController::class,'getTodos']);
    Route::get('/proveedorxrubro/obtenerDatos/{id}', [ProveedorxrubroController::class,'getDatos']);
    Route::get('/proveedorxrubro/obtenerDatos/{id}', [ProveedorxrubroController::class,'getDatos']);
    Route::post('/proveedorxrubro/obtenerProveedorxRubro', [ProveedorxrubroController::class,'getProveedorxRubro']);

    // VISTA PREVISION
    Route::get('/vistaprevision/obtenerTodos', [VistaPrevisionController::class,'getTodos']);
    Route::get('/vistaprevision/obtenerDatos/{id}', [VistaPrevisionController::class,'getDatos']);
    Route::post('/vistaprevision/obtenerDatos', [VistaPrevisionController::class,'getDatos']);

    // PRESUPUESTACION  
    Route::post('/presupuestacion/crear', [PresupuestacionController::class,'crear']);
    Route::get('/presupuestacion/obtenerTodos', [PresupuestacionController::class,'getTodos']);
    Route::get('/presupuestacion/obtenerDatos/{id}', [PresupuestacionController::class,'getDatos']);

    // PRESUPUESTACION PROVEEDORES
    // Route::get('/presupuestacionproveedores/obtenerTodos/{id}', [PresupuestacionProveedoresController::class,'getTodos']);

    // PRESUPUESTACION PRODUCTOS
    Route::post('/presupuestacionproductosproveedor/crear', [PresupuestacionProductosProveedoresController::class,'crear']);
    
    Route::post('/presupuestacionproductosproveedor/crearBorrador', [PresupuestacionProductosProveedoresController::class,'crearBorrador']);
    
    Route::get('/presupuestacionproductosproveedor/obtenerTodosProveedor/{id}', [PresupuestacionProductosProveedoresController::class,'getTodosProveedor']);

    Route::post('/presupuestacionproductosproveedor/obtenerTodos', [PresupuestacionProductosProveedoresController::class,'getTodos']);

    
    Route::post('/presupuestacionproductosproveedor/obtenerTodosDatos', [PresupuestacionProductosProveedoresController::class,'getTodosDatos']);
    
    // Route::get('/presupuestacionproductosproveedor/obtenerTodosProveedores/{id}', [PresupuestacionProductosProveedoresController::class,'getTodosProveedores']);
    Route::post('/presupuestacionproductosproveedor/obtenerTodosProveedores', [PresupuestacionProductosProveedoresController::class,'getTodosProveedores']);


    Route::get('/presupuestacionproductosproveedor/condicionComparativa/{id}', [PresupuestacionProductosProveedoresController::class,'getCondicionComparativa']);



    // BORRADORES
    Route::post('/borradorpresupuestacion/crear', [BorradorPresupuestacionController::class,'crear']);
    
    Route::get('/borradorpresupuestacion/obtenerTodos', [BorradorPresupuestacionController::class,'getTodos']);
    
    Route::get('/borradorpresupuestacion/obtenerDatos/{id}', [BorradorPresupuestacionController::class,'getDatos']);
    
    Route::post('/borradorpresupuestacion/actualizar', [BorradorPresupuestacionController::class,'actualizar']);
    
    Route::post('/borradorpresupuestacion/crearPresupuestacion', [BorradorPresupuestacionController::class,'crearPesupuestacion']);


    // ORDENES DE PAGO
    Route::post('/ordencompra/crear', [OrdenCompraController::class,'crear']);
    Route::get('/ordencompra/obtenerTodos', [OrdenCompraController::class,'getTodos']);
    Route::get('/ordencompra/obtenerDatos/{id}', [OrdenCompraController::class,'getDatos']);

    // TRANSFERENCIAS
    Route::get('/transferencia/obtenerTodos', [TransferenciaController::class,'getTodos']);
    Route::post('/transferencia/actualizar', [TransferenciaController::class,'actualizar']);

    
    
    // CONDICION DE PAGO
    Route::get('/condicionpago/obtenerTodos', [CondicionPagoController::class,'getTodos']);

   
    // USUARIOS
    Route::get('/usuario/obtenerTodos', [UserController::class,'getTodos']);
    Route::post('/usuario/crear', [UserController::class,'crear']);
    Route::post('/usuario/crearUsuarioProveedor', [UserController::class,'crearUsuarioProveedor']);
    Route::get('/usuario/obtenerDatos/{id}', [UserController::class,'getDatos']);
    Route::post('/usuario/obtenerDatosUsuarioLogin', [UserController::class,'getDatosUsuarioLogin']);
    Route::put('/usuario/actualizar/{id}', [UserController::class,'actualizar']);
    Route::delete('/usuario/eliminar/{id}', [UserController::class,'eliminar']);


    // Route::post('/login', [UserController::class,'login']);









   
    // ARTICULOS
    Route::get('/articulo/obtenerTodos', [ArticuloController::class,'index']);
    Route::get('/articulo/obtenerTodosSelect', [ArticuloController::class,'getTodosSelect']);
    Route::get('/articulo/obtenerDatos/{id}', [ArticuloController::class,'getDatos']);
    Route::post('/articulo/crear', [ArticuloController::class,'store']);
    Route::put('/articulo/actualizar/{id}', [ArticuloController::class,'update']);
    Route::delete('/articulo/eliminar/{id}', [ArticuloController::class,'destroy']);

    // CATEGORIAS
    Route::get('/categoria/obtenerTodos', [CategoriaController::class,'getTodos']);
    Route::get('/categoria/obtenerTodosSelect', [CategoriaController::class,'getTodosSelect']);
    Route::get('/categoria/obtenerDatos/{id}', [CategoriaController::class,'getDatos']);
    Route::post('/categoria/crear', [CategoriaController::class,'crear']);
    Route::put('/categoria/actualizar/{id}', [CategoriaController::class,'actualizar']);
    Route::delete('/categoria/eliminar/{id}', [CategoriaController::class,'eliminar']);
 
    // UNIDADES DE MEDIDA
    Route::get('/unidad-medida/obtenerTodos', [UnidadMedidaController::class,'getTodos']);
    Route::get('/unidad-medida/obtenerTodosSelect', [UnidadMedidaController::class,'getTodosSelect']);
    Route::get('/unidad-medida/obtenerDatos/{id}', [UnidadMedidaController::class,'getDatos']);
    Route::post('/unidad-medida/crear', [UnidadMedidaController::class,'crear']);
    Route::put('/unidad-medida/actualizar/{id}', [UnidadMedidaController::class,'actualizar']);
    Route::delete('/unidad-medida/eliminar/{id}', [UnidadMedidaController::class,'eliminar']);

    // MI CUENTA
    Route::get('/mi-cuenta/obtenerDatos/{id}', [LoginController::class,'getDatos']);







    


});
