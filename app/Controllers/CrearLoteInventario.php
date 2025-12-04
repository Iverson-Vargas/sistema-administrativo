<?php

namespace App\Controllers;

use App\Models\Inventario;

class CrearLoteInventario extends BaseController
{
    public function createLote()
    {
        $json = $this->request->getJSON();

        // Obtener los datos del JSON enviado desde el frontend
        $codigoLote = $json->codigo_lote ?? null;
        $idProducto = $json->id_producto ?? null;
        $idEmpleado = $json->id_empleado ?? null;
        $fechaIngreso = $json->fecha_ingreso ?? null;
        $cantidad = $json->cantidad ?? null;

        // Validar que todos los campos necesarios estén presentes
        if (empty($codigoLote) || empty($idProducto) || empty($idEmpleado) || empty($fechaIngreso) || empty($cantidad)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Por favor, complete todos los campos.']);
        }

        $datos = [
            'codigo_lote' => $codigoLote,
            'id_producto' => $idProducto,
            'id_empleado' => $idEmpleado,
            'fecha_ingreso' => $fechaIngreso,
            'cantidad_inicial' => $cantidad,
            'cantidad_disponible' => $cantidad, // Al crear, la cantidad disponible es la misma que la inicial
        ];

        try {
            $modeloInventario = new Inventario();
            $resultado = $modeloInventario->insertarInventario($datos);

            if ($resultado) {
                return $this->response->setJSON(['success' => true, 'message' => 'Lote creado correctamente']);
            } else {
                // Esto podría ocurrir si el modelo tiene callbacks que fallen.
                return $this->response->setJSON(['success' => false, 'message' => 'No se pudo crear el lote. Verifique los datos.']);
            }
        } catch (\Exception $e) {
            // Captura errores de la base de datos (ej. clave foránea no válida)
            return $this->response->setStatusCode(500)->setJSON(['success' => false, 'message' => 'Error del servidor: ' . $e->getMessage()]);
        }
    }

    public function obtenerLotes()
    {
        $modeloInventario = new Inventario();
        $lotes = $modeloInventario->obtenerProductos();

        return $this->response->setJSON(['success' => true, 'data' => $lotes]);
    }
}