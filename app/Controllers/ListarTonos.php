<?php

namespace App\Controllers;

use App\Models\Tono;

class ListarTonos extends BaseController
{
     public function returnTonos(){
        $Tonos = new Tono();
        $datos = $Tonos->traerTonos ();
        return json_encode(array('success' => true, 'data' => $datos));
    }
}