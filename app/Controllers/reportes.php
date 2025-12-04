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

    /**
     * Obtiene los datos para el reporte de inventario actual.
     */
    public function inventarioActual()
    {
        try {
            $reporteModel = new ReporteModel();
            $data = $reporteModel->getInventarioActual();

            return $this->response->setJSON(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            log_message('error', '[Reportes] Error en inventarioActual: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['success' => false, 'message' => 'Error interno al procesar el reporte de inventario.']);
        }
    }

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

    /**
     * Obtiene los datos para el reporte de rendimiento de vendedores.
     * Acepta un rango de fechas como parámetros GET.
     */
    public function rendimientoVendedores()
    {
        try {
            $fechaDesde = $this->request->getGet('fecha_desde');
            $fechaHasta = $this->request->getGet('fecha_hasta');

            $reporteModel = new ReporteModel();
            $data = $reporteModel->getRendimientoVendedores($fechaDesde, $fechaHasta);

            return $this->response->setJSON(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            log_message('error', '[Reportes] Error en rendimientoVendedores: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['success' => false, 'message' => 'Error interno al procesar el reporte.']);
        }
    }

    /**
     * Obtiene una lista de productos que tienen suficientes datos de ventas
     * para un análisis de correlación (ej. más de 2 ventas).
     */
    public function getProductsForCorrelation()
    {
        try {
            $db = \Config\Database::connect();
            $builder = $db->table('producto p');

            $builder->select('p.id_producto, p.descripcion, COUNT(dv.id_detalle_venta) as num_ventas');
            $builder->join('detalle_venta dv', 'p.id_producto = dv.id_producto', 'inner');
            $builder->groupBy('p.id_producto, p.descripcion');
            $builder->having('num_ventas >', 2); // Necesitamos al menos 3 puntos para un análisis simple

            $query = $builder->get();
            $data = $query->getResultArray();

            return $this->response->setJSON(['success' => true, 'data' => $data]);

        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Obtiene los datos de (precio, cantidad) para un producto específico.
     */
    public function getCorrelationDataForProduct()
    {
        try {
            $productId = $this->request->getGet('id_producto');

            if (empty($productId)) {
                return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'ID de producto no proporcionado.']);
            }

            $db = \Config\Database::connect();
            $builder = $db->table('detalle_venta');

            $builder->select('precio_unitario as x, cantidad as y');
            $builder->where('id_producto', $productId);
            // Opcional: filtrar valores no válidos
            $builder->where('precio_unitario >', 0);
            $builder->where('cantidad >', 0);

            $query = $builder->get();
            $data = $query->getResultArray();

            return $this->response->setJSON(['success' => true, 'data' => $data]);

        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
