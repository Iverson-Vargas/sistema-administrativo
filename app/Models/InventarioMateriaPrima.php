<?php

namespace App\Models;

use CodeIgniter\Model;

class InventarioMateriaPrima extends Model
{
    protected $table = 'inventario_materia_prima';
    protected $primaryKey = 'id_inv_mp';

    protected $allowedFields = [
        'id_inv_mp',
        'id_materia_prima',
        'id_compra',
        'codigo_lote',
        'fecha_ingreso',
        'cantidad_disponible',
    ];

    public function insertarInventarioMateriaPrima($data)
    {
        $builder = $this->db->table('inventario_materia_prima');
        return $builder->insert($data); 
    }
}
