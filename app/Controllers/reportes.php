<?php

namespace App\Controllers;

use App\Models\ReporteModel; // Para reportes operacionales (producción, inventario, más vendidos, vendedores)
use App\Models\ReportesModel; // Para reportes estadísticos (correlación) y de ventas

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

            $reporteModel = new ReporteModel(); // Usa el modelo singular para este reporte
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
            $reporteModel = new ReporteModel(); // Usa el modelo singular para este reporte
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

            $reporteModel = new ReporteModel(); // Usa el modelo singular para este reporte
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

            $reporteModel = new ReporteModel(); // Usa el modelo singular para este reporte
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
            $reportesModel = new ReportesModel(); // Usa el modelo plural para este reporte
            $data = $reportesModel->getProductsForCorrelation();
            return $this->response->setJSON(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            log_message('error', '[ReportesController] getProductsForCorrelation: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['success' => false, 'message' => 'Ocurrió un error en el servidor al obtener los productos.']);
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
            $reportesModel = new ReportesModel(); // Usa el modelo plural para este reporte
            $data = $reportesModel->getCorrelationDataForProduct($productId);
            return $this->response->setJSON(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            log_message('error', '[ReportesController] getCorrelationDataForProduct: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['success' => false, 'message' => 'Ocurrió un error en el servidor al obtener los datos de correlación.']);
        }
    }

    // Nuevo método para obtener el listado de ventas
    public function listadoVentas()
    {
        try {
            $fechaDesde = $this->request->getGet('fecha_desde');
            $fechaHasta = $this->request->getGet('fecha_hasta');
            $clienteCi = $this->request->getGet('cliente_ci');
            $idEmpleado = $this->request->getGet('id_empleado'); // Opcional, si quieres filtrar por empleado

            $reportesModel = new ReportesModel(); // Usa el modelo plural para este reporte
            $data = $reportesModel->getListadoVentas($fechaDesde, $fechaHasta, $clienteCi, $idEmpleado);

            return $this->response->setJSON(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            log_message('error', '[Reportes] Error en listadoVentas: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['success' => false, 'message' => 'Error interno al procesar el reporte de ventas.']);
        }
    }

    // Nuevo método para obtener los detalles de una venta específica
    public function detalleVenta(int $idVenta)
    {
        try {
            $reportesModel = new ReportesModel(); // Usa el modelo plural para este reporte
            $data = $reportesModel->getDetalleVenta($idVenta);

            return $this->response->setJSON(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            log_message('error', '[Reportes] Error en detalleVenta: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['success' => false, 'message' => 'Error interno al obtener los detalles de la venta.']);
        }
    }
}
