<?php

namespace App\Models;

use CodeIgniter\Model;

class DetalleCompra extends Model
{
    protected $table = 'detalle_compra';
    protected $primaryKey = 'id_detalle_compra';

    protected $allowedFields = [
        'id_detalle_compra',
        'id_compra',
        'id_materia_prima',
        'cantidad',
        'costo_unitario',
    ];

    public function insertarDetalleCompra($data)
    {
        $builder = $this->db->table('detalle_compra');
        return $builder->insert($data); 
    }
}
