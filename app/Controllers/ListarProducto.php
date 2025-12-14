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

    public function actualizarProducto($idProducto){
        $Producto = new Producto();
        // Obtener los datos del cuerpo de la solicitud JSON
        $json = $this->request->getJSON();

        if (!$json) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Datos inválidos.']);
        }

        $data = [
            'nombre' => $json->nombre,
            'descripcion' => $json->descripcion,
            'precio_unitario' => $json->precio_unitario
        ];

        if ($Producto->actualizarProducto($idProducto, $data)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Producto actualizado correctamente.']);
        }
        
        return $this->response->setStatusCode(500)->setJSON(['success' => false, 'message' => 'Error al actualizar el producto.']);
    }

    public function eliminarProducto($idProducto){
        $Producto = new Producto();

        if ($Producto->eliminarProducto($idProducto)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Producto eliminado correctamente.']);
        }
        return $this->response->setStatusCode(409)->setJSON(['success' => false, 'message' => 'No se puede eliminar: El producto tiene registros asociados (Ventas, Compras o Inventario).']);
        return $this->response->setStatusCode(409)->setJSON(['success' => false, 'message' => 'No se puede eliminar: El producto tiene registros asociados (Ventas o Inventario).']);
    }

    public function ProductoParaLote(){
        $Producto = new Producto();
        $datos = $Producto->ListarProductoParaLote();
        // Se devuelve una respuesta consistente con lo que espera el frontend (success: true).
        return $this->response->setJSON(['success' => true, 'data' => $datos]);
    }
}