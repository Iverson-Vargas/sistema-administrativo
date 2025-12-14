<?php

namespace App\Controllers;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\InventarioMateriaPrima;
use App\Models\MateriaPrima;
use App\Models\Empleado;



class CrearCompra extends BaseController
{
    public function generarCompra()
    {
        try {
            $json = $this->request->getJSON();

            if (!$json) {
                return $this->response->setJSON(['success' => false, 'message' => 'No se recibieron datos JSON.']);
            }

            // Obtener datos del JSON
            $id_proveedor = $json->id_proveedor ?? null;
            $id_usuario = $json->id_empleado ?? null; // La vista envía el ID de usuario (sesión)
            $numero_factura = $json->numero_factura_fisica ?? null;
            $total_compra = $json->total_compra ?? null;
            $insumos = $json->insumos ?? [];

            // Validaciones de campos obligatorios
            if (empty($id_proveedor) || empty($id_usuario) || empty($numero_factura) || !isset($total_compra) || empty($insumos)) {
                return $this->response->setJSON(['success' => false, 'message' => 'Faltan datos obligatorios o el carrito está vacío.']);
            }

            // Obtener el ID del empleado usando la función del modelo Empleado
            $empleadoModel = new Empleado();
            $id_empleado = $empleadoModel->retonarIdEmpleado($id_usuario);

            if (!$id_empleado) {
                return $this->response->setJSON(['success' => false, 'message' => 'No se encontró un empleado asociado al usuario actual.']);
            }

            $db = \Config\Database::connect();
            $db->transStart();

            // 1. Insertar en la tabla Compra
            $compraModel = new Compra();
            $datosCompra = [
                'id_proveedor' => $id_proveedor,
                'id_empleado' => $id_empleado,
                'fecha' => date('Y-m-d'),
                'numero_factura_fisica' => $numero_factura,
                'total_compra' => $total_compra
            ];

            if (!$compraModel->insert($datosCompra)) {
                $db->transRollback();
                return $this->response->setJSON(['success' => false, 'message' => 'Error al registrar la compra.']);
            }
            $id_compra = $compraModel->getInsertID();

            // Modelos para los detalles
            $materiaPrimaModel = new MateriaPrima();
            $detalleCompraModel = new DetalleCompra();
            $inventarioMpModel = new InventarioMateriaPrima();

            foreach ($insumos as $insumo) {
                // Validar datos del insumo
                if (empty($insumo->nombre) || !isset($insumo->cantidad) || !isset($insumo->costo_unitario)) {
                    $db->transRollback();
                    return $this->response->setJSON(['success' => false, 'message' => 'Datos de insumo incompletos.']);
                }

                // 2. Gestionar Materia Prima (Buscar o Crear)
                $nombreMp = trim($insumo->nombre);
                $materiaPrimaExistente = $materiaPrimaModel->where('nombre', $nombreMp)->first();

                if ($materiaPrimaExistente) {
                    $id_materia_prima = $materiaPrimaExistente['id_materia_prima'];
                } else {
                    $datosMp = [
                        'nombre' => $nombreMp,
                        'descripcion' => $insumo->descripcion ?? '',
                        'unidad_medida' => $insumo->unidad_medida ?? 'Unidad',
                        'stock_minimo' => $insumo->stock_minimo ?? 0
                    ];
                    if (!$materiaPrimaModel->insert($datosMp)) {
                        $db->transRollback();
                        return $this->response->setJSON(['success' => false, 'message' => 'Error al registrar materia prima: ' . $nombreMp]);
                    }
                    $id_materia_prima = $materiaPrimaModel->getInsertID();
                }

                // 3. Insertar Detalle de Compra
                $datosDetalle = [
                    'id_compra' => $id_compra,
                    'id_materia_prima' => $id_materia_prima,
                    'cantidad' => $insumo->cantidad,
                    'costo_unitario' => $insumo->costo_unitario
                ];
                if (!$detalleCompraModel->insert($datosDetalle)) {
                    $db->transRollback();
                    return $this->response->setJSON(['success' => false, 'message' => 'Error al registrar detalle de compra.']);
                }

                // 4. Insertar en Inventario de Materia Prima (Lote)
                if (!empty($insumo->codigo_lote)) {
                    $datosInventario = [
                        'id_materia_prima' => $id_materia_prima,
                        'id_compra' => $id_compra,
                        'codigo_lote' => $insumo->codigo_lote,
                        'fecha_ingreso' => date('Y-m-d'),
                        'cantidad_disponible' => $insumo->cantidad
                    ];
                    if (!$inventarioMpModel->insert($datosInventario)) {
                        $db->transRollback();
                        return $this->response->setJSON(['success' => false, 'message' => 'Error al registrar inventario (lote).']);
                    }
                }
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                return $this->response->setJSON(['success' => false, 'message' => 'Error al completar la transacción.']);
            }

            return $this->response->setJSON(['success' => true, 'message' => 'Compra procesada exitosamente.']);

        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Error del servidor: ' . $e->getMessage()]);
        }
    }
}