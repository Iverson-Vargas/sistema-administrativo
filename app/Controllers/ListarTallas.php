<?php

namespace App\Controllers;

use App\Models\Talla;

class ListarTallas extends BaseController
{
    public function returnTallas(){
        $Tallas = new Talla();
        $datos = $Tallas->traerTallas();
        return json_encode(array('success' => true, 'data' => $datos));
    }
}