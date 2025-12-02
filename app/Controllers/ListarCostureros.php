<?php

namespace App\Controllers;

use App\Models\Persona;

class ListarCostureros extends BaseController
{
    public function returnCostureros(){
        $Costureros = new Persona();
        $datos = $Costureros->getCostureros();
        return json_encode(array('success' => true, 'data' => $datos));
    }
}