<?php

namespace App\Http\Requests\Usuarios;

use App\Http\Requests\Usuarios\UsuariosRequest;

class CrearUsuariosRequest extends UsuariosRequest
{


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $this->nombre();
        $this->apellido();
        $this->dniUnico();
        $this->uniqueEmail();
        $this->fechaNacimiento();
        $this->genero();

        return $this->reglas;
    }
}
