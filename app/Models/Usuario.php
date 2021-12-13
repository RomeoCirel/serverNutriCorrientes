<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Model
{
    use HasFactory;
    use HasApiTokens;
    use Notifiable;
    use SoftDeletes;

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
}
