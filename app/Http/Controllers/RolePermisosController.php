<?php

namespace App\Http\Controllers;

use App\Auxiliares\MensajeError;
use App\Auxiliares\Respuesta;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class RolePermisosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Role $role
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Role $role): JsonResponse
    {
        try {
            $role->permissions;
            return Respuesta::exito(['role' => $role]);
        } catch (Exception $e) {
            $error = new MensajeError('El rol solicitado no fue encontrado', 'NO_OBTENIDO');
            return Respuesta::error($error);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Role $role
     * @return JsonResponse
     * @throws Exception
     */
    public function store(Request $request, Role $role): JsonResponse
    {
        try {
            $permisos = $request->input('permisos', []);
            $role->syncPermissions($permisos);
            $nuevoRole = Role::findById($role->id);
            $nuevoRole->permissions;
            return Respuesta::exito(['role' => $nuevoRole]);
        } catch (Exception $e) {
            $error = new MensajeError(`No pudimos Asignar los permisos al rol ${$role->name}`, 'PERMISOS_NO_ASIGNADOS');
            return Respuesta::error($error);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Role $role): JsonResponse
    {
        try {
            $role->permissions;
            return Respuesta::exito(['role' => $role]);
        } catch (Exception $e) {
            $error = new MensajeError('El rol solicitado no fue encontrado', 'NO_OBTENIDO');
            return Respuesta::error($error);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Role $role
     * @return JsonResponse
     * @throws Exception
     */
    public function update(Request $request, Role $role): JsonResponse
    {
        try {
            $permisos = $request->input('permisos', []);
            $role->syncPermissions($permisos);
            $nuevoRole = Role::findById($role->id);
            $nuevoRole->permissions;
            return Respuesta::exito(['role' => $nuevoRole]);
        } catch (Exception $e) {
            $error = new MensajeError(`No pudimos modificar los permisos al rol ${$role->name}`, 'PERMISOS_NO_MODIFICADOS');
            return Respuesta::error($error);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return void
     * @throws Exception
     */
    public function destroy(Role $role): void
    {
        //
    }
}
