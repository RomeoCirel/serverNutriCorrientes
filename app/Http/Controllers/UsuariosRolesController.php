<?php

namespace App\Http\Controllers;

use App\Auxiliares\MensajeError;
use App\Auxiliares\Respuesta;
use App\Models\Usuario;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;

class UsuariosRolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Role $role
     * @return void
     * @throws Exception
     */
    public function index(Request $request, Role $role)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Usuario $usuario
     * @return JsonResponse
     * @throws Exception
     */
    public function store(Request $request, Usuario $usuario): JsonResponse
    {
        try {
            $roles = $request->input('roles', null);
            $usuario->roles()->sync($roles);
            $guardado = $usuario->roles;
            return Respuesta::exito(['usuario' => $guardado]);
        } catch (Exception $e) {
            $mensaje = new MensajeError('ha ocurrido un error al asignar los Roles.', 'NO_OBTENIDOS');
            return Respuesta::error($mensaje, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Usuario $usuario
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Usuario $usuario): JsonResponse
    {
        try {
            $roles = $usuario->roles;
            $permisos = $usuario->getPermisos();
            return Respuesta::exito(['roles' => $roles, 'permisos' => $permisos]);
        } catch (Exception $e) {
            $mensaje = new MensajeError('ha ocurrido un error al consultar sus Roles.', 'NO_OBTENIDOS');
            return Respuesta::error($mensaje, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Usuario $usuario
     * @return Response
     * @throws Exception
     */
    public function update(Request $request, Usuario $usuario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Usuario $usuario
     * @return Response
     */
    public function destroy(Usuario $usuario)
    {
        //
    }
}
