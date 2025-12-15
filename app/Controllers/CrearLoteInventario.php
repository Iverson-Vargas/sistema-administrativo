<?php

namespace App\Controllers;

use App\Models\Inventario;
use App\Models\FormulaProducto;
use App\Models\InventarioMateriaPrima;
use CodeIgniter\API\ResponseTrait;


class CrearLoteInventario extends BaseController
{
    use ResponseTrait;

    public function createLote()
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $data = $this->request->getJSON(true);

            // Validación simple
            if (empty($data['codigo_lote']) || empty($data['id_producto']) || empty($data['id_empleado']) || empty($data['fecha_ingreso']) || empty($data['id_tono']) || empty($data['detalles'])) {
                return $this->failValidationErrors('Todos los campos son requeridos.');
            }

            $inventarioModel = new Inventario();
            
            // Verificar si el código de lote ya existe antes de procesar
            if ($inventarioModel->where('codigo_lote', $data['codigo_lote'])->countAllResults() > 0) {
                return $this->failValidationErrors('El código de lote "' . $data['codigo_lote'] . '" ya existe en el sistema.');
            }

            $formulaModel = new FormulaProducto();
            $invMpModel = new InventarioMateriaPrima();
            
            // Iterar sobre los detalles (tallas)
            foreach ($data['detalles'] as $detalle) {
                if (empty($detalle['id_talla']) || empty($detalle['cantidad'])) {
                    throw new \Exception("Datos de talla incompletos.");
                }

                $cantidadProducir = $detalle['cantidad'];
                $idTalla = $detalle['id_talla'];

                $loteData = [
                    'codigo_lote'         => $data['codigo_lote'],
                    'id_producto'         => $data['id_producto'],
                    'id_empleado'         => $data['id_empleado'],
                    'fecha_ingreso'       => $data['fecha_ingreso'],
                    'id_tono'             => $data['id_tono'],
                    'id_talla'            => $idTalla,
                    'cantidad_inicial'    => $cantidadProducir,
                    'cantidad_disponible' => $cantidadProducir,
                ];

                if (!$inventarioModel->insert($loteData)) {
                    throw new \Exception(implode(", ", $inventarioModel->errors()));
                }

                // Descontar Materia Prima según Fórmula
                $ingredientes = $formulaModel->obtenerIngredientes($data['id_producto'], $idTalla);
                foreach ($ingredientes as $ingrediente) {
                    $totalRequerido = $ingrediente['cantidad_requerida'] * $cantidadProducir;
                    $invMpModel->descontarStock($ingrediente['id_materia_prima'], $totalRequerido);
                }
            }

            $db->transCommit();

            if ($db->transStatus() === false) {
                $db->transRollback();
                return $this->failServerError('Error al guardar el lote. Transacción revertida.');
            }

            return $this->respondCreated(['success' => true, 'message' => 'Lote creado exitosamente y materia prima descontada.']);
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', '[CrearLoteInventario] Error en createLote: ' . $e->getMessage());
            return $this->failServerError('Error: ' . $e->getMessage());
        }
    }

    public function obtenerLotes()
    {
        $inventarioModel = new Inventario();
        try {
            $data = $inventarioModel->obtenerProductos(); 
            return $this->respond(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            log_message('error', '[CrearLoteInventario] Error en obtenerLotes: ' . $e->getMessage());
            return $this->failServerError('Ocurrió un error en el servidor al obtener los lotes.');
        }
    }
}
