<?php

namespace App\Controllers;

use App\Models\ReporteModel;

class Reportes extends BaseController
{
    /**
     * Obtiene los datos para el reporte de producción por costurero.
     * Acepta un rango de fechas como parámetros GET.
     */
    public function produccionPorCosturero()
    {
        try {
            $fechaDesde = $this->request->getGet('fecha_desde');
            $fechaHasta = $this->request->getGet('fecha_hasta');

            $reporteModel = new ReporteModel();
            $data = $reporteModel->getProduccionPorCosturero($fechaDesde, $fechaHasta);

            return $this->response->setJSON(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['success' => false, 'message' => 'Error interno del servidor: ' . $e->getMessage()]);
        }
    }

    // --- Aquí puedes agregar los métodos para los otros 8 reportes ---
    // --- Aquí puedes agregar los métodos para los otros 8 reportes ---
    // public function productosMasVendidos() { ... }
    // public function ventasMensuales() { ... }
    /**
     * Obtiene los datos para el reporte de productos más vendidos.
     * Acepta un rango de fechas como parámetros GET.
     */
    public function productosMasVendidos()
    {
        try {
            $fechaDesde = $this->request->getGet('fecha_desde');
            $fechaHasta = $this->request->getGet('fecha_hasta');

            $reporteModel = new ReporteModel();
            $data = $reporteModel->getProductosMasVendidos($fechaDesde, $fechaHasta);

            return $this->response->setJSON(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            log_message('error', '[Reportes] Error en productosMasVendidos: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['success' => false, 'message' => 'Error interno al procesar el reporte.']);
        }
    }

}
