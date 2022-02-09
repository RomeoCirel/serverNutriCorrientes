<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;

class Usuario extends Authenticatable
{
    use HasFactory;
    use HasApiTokens;
    use Notifiable;
    use SoftDeletes;
    use HasRoles;

    protected $table = 'usuarios';

    /**
     * atributos que puedes ser asignados de forma masiva.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'apellido',
        'dni',
        'email',
        'fechaNacimiento',
        'genero_id',
        'cambiar_clave',
        'password',
    ];

    /**
     * atributos que quedaran ocultos en las serializaciones.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * atributos que deben ser convertidos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'cambiar_clave' => 'boolean'
    ];

    /**
     *
     * @return BelongsTo
     */

    public function genero(): BelongsTo
    {
        return $this->belongsTo(Genero::class);
    }

    public function getPermisos()
    {
        $puede = $this->getAllPermissions()->mapWithKeys(function ($permisos) {
            return [$permisos['name'] => $permisos['name']];
        });

        $permisos = Permission::all()->mapWithKeys(function ($permisos) {
            return [$permisos['name'] => false];
        });

        if (count($puede) > 0) {
            foreach ($puede as $clave) {
                $permisos[$clave] = true;
            }
        }
        return $permisos;
    }
}
