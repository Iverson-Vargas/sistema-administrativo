<?php

namespace App\Controllers;

use App\Models\LoteModel;
use CodeIgniter\RESTful\ResourceController;

class CrearLoteInventario extends ResourceController
{
    protected $modelName = 'App\Models\LoteModel';
    protected $format    = 'json';

    public function createLote()
    {
        try {
            $data = $this->request->getJSON(true);

            // Validación simple
            if (empty($data['codigo_lote']) || empty($data['id_producto']) || empty($data['id_empleado']) || empty($data['fecha_ingreso']) || empty($data['cantidad'])) {
                return $this->failValidationErrors('Todos los campos son requeridos.');
            }

            $loteData = [
                'codigo_lote'         => $data['codigo_lote'],
                'id_producto'         => $data['id_producto'],
                'id_empleado'         => $data['id_empleado'],
                'fecha_ingreso'       => $data['fecha_ingreso'],
                'cantidad_inicial'    => $data['cantidad'],
                'cantidad_disponible' => $data['cantidad'], // Al crear, la cantidad disponible es la inicial
            ];

            if ($this->model->insert($loteData) === false) {
                return $this->fail($this->model->errors());
            }

            return $this->respondCreated(['success' => true, 'message' => 'Lote creado exitosamente.']);
        } catch (\Exception $e) {
            log_message('error', '[CrearLoteInventario] Error en createLote: ' . $e->getMessage());
            return $this->failServerError('Ocurrió un error en el servidor al intentar crear el lote.');
        }
    }

    public function obtenerLotes()
    {
        try {
            $data = $this->model->getLotesConDetalles(); 
            return $this->respond(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            log_message('error', '[CrearLoteInventario] Error en obtenerLotes: ' . $e->getMessage());
            return $this->failServerError('Ocurrió un error en el servidor al obtener los lotes.');
        }
    }
}
