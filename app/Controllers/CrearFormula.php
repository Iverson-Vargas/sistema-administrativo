<?php

namespace App\Controllers;
use App\Models\FormulaProducto;



class CrearFormula extends BaseController
{
    public function crearUnaFormula()
    {
        try {
            $json = $this->request->getJSON();
            $id_producto = $json->id_producto ?? null;
            $id_talla = $json->id_talla ?? null;
            $ingredientes = $json->ingredientes ?? [];

            // Validación de campos obligatorios
            if (empty($id_producto) || empty($id_talla) || empty($ingredientes)) {
                return $this->response->setJSON(['success' => false, 'message' => 'Los datos obligatorios no pueden estar vacíos']);
            }

            // Iniciar Transacción
            $db = \Config\Database::connect();
            $db->transBegin();

            // 1. Insertar en tabla FormulaProducto
            $formulaProductoModel = new FormulaProducto();
            
            foreach ($ingredientes as $ingrediente) {
                $datosFormula = [
                    'id_producto' => $id_producto,
                    'id_talla' => $id_talla,
                    'id_materia_prima' => $ingrediente->id_materia_prima,
                    'cantidad_requerida' => $ingrediente->cantidad_requerida,
                ];
                $formulaProductoModel->insertarFormula($datosFormula);
            }

            // Confirmar Transacción
            if ($db->transStatus() === false) {
                $db->transRollback();
                return $this->response->setJSON(['success' => false, 'message' => 'Error al crear la fórmula del producto.']);
            } else {
                $db->transCommit();
                return $this->response->setJSON(['success' => true, 'message' => 'Fórmula del producto creada exitosamente.']);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Excepción: ' . $e->getMessage()]);
        }
    }
}