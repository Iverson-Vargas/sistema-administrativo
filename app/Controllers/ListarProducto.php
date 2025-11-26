<?php

namespace App\Controllers;

use App\Models\Producto;

class ListarProducto extends BaseController
{
    public function returnProductos(){
        $Producto = new Producto();
        $datos = $Producto->traerProductos();
        return json_encode(array('success' => true, 'data' => $datos));
    }
}