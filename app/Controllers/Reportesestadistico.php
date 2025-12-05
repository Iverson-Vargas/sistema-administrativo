<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ReportesModel;

class Reportesestadistico extends BaseController
{
    protected $reportesModel;

    public function __construct()
    {
        $this->reportesModel = new ReportesModel();
    }

    public function getProductsForCorrelation()
    {
        try {
            $data = $this->reportesModel->getProductsForCorrelation();
            return $this->response->setJSON(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            log_message('error', '[ReportesController] getProductsForCorrelation: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['success' => false, 'message' => 'Ocurrió un error en el servidor al obtener los productos.']);
        }
    }

    public function getCorrelationDataForProduct()
    {
        $productId = $this->request->getGet('id_producto');

        if (!$productId) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'El ID del producto es requerido.']);
        }

        try {
            $data = $this->reportesModel->getCorrelationDataForProduct($productId);
            return $this->response->setJSON(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            log_message('error', '[ReportesController] getCorrelationDataForProduct: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['success' => false, 'message' => 'Ocurrió un error en el servidor al obtener los datos de correlación.']);
        }
    }
}

