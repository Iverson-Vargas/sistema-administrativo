<?php

namespace App\Models;

use CodeIgniter\Model;

class Compra extends Model
{
    protected $table = 'compra';
    protected $primaryKey = 'id_compra';

    protected $allowedFields = [
        'id_compra',
        'id_proveedor',
        'id_empleado',
        'fecha',
        'numero_factura_fisica',
        'total_compra',
    ];

    public function insertarCompra($data)
    {
        $builder = $this->db->table('compra');
        $builder->insert($data);
        return $this->db->insertID();
    }
}
