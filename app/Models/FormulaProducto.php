<?php

namespace App\Models;

use CodeIgniter\Model;

class FormulaProducto extends Model
{
    protected $table = 'formula_producto';
    protected $primaryKey = 'id_formula';

    protected $allowedFields = [
        'id_formula',
        'id_producto',
        'id_materia_prima',
        'cantidad_requerida',
        'id_talla',
    ];

    public function insertarFormula($data)
    {
        $builder = $this->db->table('formula_producto');
        return $builder->insert($data);
    }

    public function obtenerIngredientes($idProducto, $idTalla)
    {
        return $this->where('id_producto', $idProducto)
                    ->where('id_talla', $idTalla)
                    ->findAll();
    }
}