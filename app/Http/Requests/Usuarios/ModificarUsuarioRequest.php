<?php

namespace App\Http\Requests\Usuarios;

use App\Http\Requests\Usuarios\UsuariosRequest;

class ModificarUsuarioRequest extends UsuariosRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $this->nombre();
        $this->apellido();
        $this->dni();
        $this->ignoreDni();
        $this->email();
        $this->ignoreEmail();
        $this->fechaNacimiento();
        $this->genero();

        return $this->reglas;
    }
}
