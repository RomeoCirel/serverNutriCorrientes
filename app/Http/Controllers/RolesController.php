<?php

namespace App\Http\Controllers;

use App\Auxiliares\MensajeExito;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Auxiliares\MensajeError;
use App\Auxiliares\Respuesta;
use Exception;
use Illuminate\Http\JsonResponse;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $roles = Role::all();
            return Respuesta::exito(['roles' => $roles]);
        } catch (Exception $e) {
            $mensaje = new MensajeError('ha ocurrido un error al consultar los Roles.', 'NO_OBTENIDOS');
            return Respuesta::error($mensaje, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function store(Request $request)
    {
        try {
            $rol = $request->input('rol', null);
            $role = Role::create($rol);
            return Respuesta::exito(['role' => $role]);
        } catch (Exception $e) {
            $mensaje = new MensajeError('ha ocurrido un error al intentar crear el nuevo rol.', 'NO_GUARDADO');
            return Respuesta::error($mensaje, 500);
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
            $mensaje = new MensajeError(
                'ha ocurrido un error al intentar obtener los datos del rol solicitado.',
                'NO_OBTENIDO'
            );
            return Respuesta::error($mensaje, 500);
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
            $nombre = $request->input('name', null);
            $role->name = $nombre;
            return Respuesta::exito(['role' => $role]);
        } catch (Exception $e) {
            $mensaje = new MensajeError('ha ocurrido un error al intentar modificar el rol.', 'NO_MODIFICADO');
            return Respuesta::error($mensaje, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Role $role): JsonResponse
    {
        try {
            $role->delete();
            $mensajeExito = new MensajeExito('EL rol se a eliminado con exito.', 'ELIMINADO');
            return Respuesta::exito([], $mensajeExito, 200);
        } catch (Exception $e) {
            $mensaje = new MensajeError('ha ocurrido un error al intentar eliminar el rol. Esto puede deberse a que tiene usuarios con este rol asignado', 'NO_ELIMINADO');
            return Respuesta::error($mensaje, 500);
        }
    }
}
