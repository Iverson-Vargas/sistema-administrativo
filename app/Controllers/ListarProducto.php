<?php

namespace App\Controllers;

use App\Models\Producto;

class ListarProducto extends BaseController
{
    public function returnProductos(){
        $Producto = new Producto();
        $datos = $Producto->traerProductos();
        // Es una mejor práctica usar el objeto de respuesta de CodeIgniter para JSON.
        return $this->response->setJSON(['data' => $datos]);
    }

    public function getOneProducto($idProducto){
        $Producto = new Producto();
        $datos = $Producto->getOneProducto($idProducto);

        if (!$datos) {
            return $this->response->setStatusCode(404)->setJSON(['success' => false, 'message' => 'Producto no encontrado.']);
        }

        return $this->response->setJSON(['success' => true, 'data' => $datos]);
    }
}