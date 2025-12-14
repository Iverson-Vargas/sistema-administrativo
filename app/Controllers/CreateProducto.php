<?php

namespace App\Controllers;

use App\Models\Producto;

class CreateProducto extends BaseController
{
    public function validarProducto()
    {
        $json = $this->request->getJSON();
        $idProducto = $json->idProducto ?? null;
        $nombre = $json->nombre ?? null;
        $descripcion = $json->descripcion ?? null;
        $precioUnitario = $json->precioUnitario ?? null;

        if(empty($idProducto) || empty($nombre) || empty($descripcion) || empty($precioUnitario)){
            return $this->response->setJSON(['success' => false, 'message' => 'Los datos no pueden estar vacíos']);
        }

        $datos = [

            'id_producto' => $idProducto,
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'precio_unitario' => $precioUnitario

        ];

        $CrearMiProducto = new Producto();
        $resultado = $CrearMiProducto->insertarMiProducto($datos);
        if ($resultado) {
            return $this->response->setJSON(['success' => true, 'message' => 'Mi producto fue creada correctamente']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Error al crear mi producto']);
        }
    }

}