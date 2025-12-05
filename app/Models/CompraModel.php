<?php

namespace App\Models;

use CodeIgniter\Model;

class CompraModel extends Model
{
    protected $table = 'compra';
    protected $primaryKey = 'id_compra';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['id_proveedor', 'id_empleado', 'fecha', 'numero_factura_fisica', 'total_compra'];

    public function insertarCompraConDetalles(array $compraData, array $detallesCompra, int $idEmpleado)
    {
        $this->db->transStart();

        // 1. Insertar la compra principal
        $this->insert($compraData);
        $idCompra = $this->insertID();

        // 2. Insertar los detalles de la compra y crear lotes en inventario
        $detalleCompraModel = $this->db->table('detalle_compra');
        $inventarioModel = new Inventario();

        foreach ($detallesCompra as $detalle) {
            $detalle['id_compra'] = $idCompra;
            $detalleCompraModel->insert($detalle);

            // 3. Crear un nuevo lote en el inventario por cada item comprado
            $codigoLote = 'COMPRA-' . $idCompra . '-' . $detalle['id_producto'];
            $loteData = [
                'codigo_lote' => $codigoLote, 'id_producto' => $detalle['id_producto'],
                'id_empleado' => $idEmpleado, 'fecha_ingreso' => date('Y-m-d'),
                'cantidad_inicial' => $detalle['cantidad'], 'cantidad_disponible' => $detalle['cantidad'],
            ];
            $inventarioModel->insert($loteData);
        }

        $this->db->transComplete();
        return $this->db->transStatus() ? $idCompra : false;
    }
}
