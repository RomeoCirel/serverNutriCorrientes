<?php

use App\Http\Controllers\UsuariosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/recuperar', [PasswordController::class, 'recuperar']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::post('auth/logoutgeneral', [AuthController::class, 'logoutAllSessions']);
   
    // Usuarios
    Route::apiResource('usuarios', UsuariosController::class);
    Route::post('usuarios/{usuario}/restaurar', [UsuariosController::class, 'restore']);

});
