<?php

namespace App\Controllers;

use App\Models\Usuario;

class ListarUsuarios extends BaseController
{
     public function returnUsuarios(){
        $Usuarios = new Usuario();
        $datos = $Usuarios->getUsuario();
        return json_encode(array('success' => true, 'data' => $datos));
    }
}