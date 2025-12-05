<?php

namespace App\Models;

use CodeIgniter\Model;

class VentaModel extends Model
{
    protected $table = 'venta';
    protected $primaryKey = 'id_venta';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['id_cliente', 'id_empleado', 'fecha', 'total'];

    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'fecha'; // Usamos 'fecha' como campo de creación

    // Método para insertar una venta y sus detalles dentro de una transacción
    public function insertarVentaConDetalles(array $ventaData, array $detallesVenta)
    {
        $this->db->transStart();

        // Insertar la venta principal
        $this->insert($ventaData);
        $idVenta = $this->insertID();

        // Insertar los detalles de la venta y actualizar el inventario
        $detalleVentaModel = $this->db->table('detalle_venta');
        $inventarioModel = $this->db->table('inventario');

        foreach ($detallesVenta as $detalle) {
            $detalle['id_venta'] = $idVenta;
            $detalleVentaModel->insert($detalle);

            // Actualizar la cantidad disponible en el inventario
            $inventarioModel->set('cantidad_disponible', 'cantidad_disponible - ' . $detalle['cantidad'], false)
                            ->where('id_producto', $detalle['id_producto'])
                            ->update();
        }

        $this->db->transComplete();

        return $this->db->transStatus() ? $idVenta : false;
    }
}
