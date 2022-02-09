<?php

use App\Http\Controllers\PasswordController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\UsuariosRolesController;
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
Route::post('password/recuperar', [PasswordController::class, 'recuperar']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    // Sesion
    Route::post('auth/renovar', [AuthController::class, 'renovar']);
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::post('auth/usuario', [AuthController::class, 'usuario']);
    Route::post('auth/logoutgeneral', [AuthController::class, 'logoutAllSessions']);
    Route::get('auth/permisos', [AuthController::class, 'permisos']);

    // Password
    Route::put('password', [PasswordController::class, 'modificar']);

    // Usuarios
    Route::apiResource('usuarios', UsuariosController::class);
    Route::post('usuarios/{usuario}/restaurar', [UsuariosController::class, 'restore']);

    Route::prefix('usuarios/roles')->group(function () {
        // Usuario --> Roles
        Route::get('{usuario}', [UsuariosRolesController::class, 'show']);
        Route::post('{usuario}/asignar', [UsuariosRolesController::class, 'store']);
    });

    // Role --> Permisos
    Route::prefix('roles')->group(function () {

        Route::get('/', [RolesController::class, 'index']);
        Route::post('/', [RolesController::class, 'store']);
        Route::get('/{role}', [RolesController::class, 'show']);
        Route::put('/{role}', [RolesController::class, 'update']);
        Route::delete('/{role}', [RolesController::class, 'destroy']);

        Route::get('{role}/permisos', [RolePermisosController::class, 'index']);
        Route::post('{role}/permisos', [RolePermisosController::class, 'store']);
        Route::get('{role}/permisos', [RolePermisosController::class, 'show']);
        Route::put('{role}/permisos', [RolePermisosController::class, 'update']);

    });
});
