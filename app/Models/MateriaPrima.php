<?php

namespace App\Models;

use CodeIgniter\Model;

class MateriaPrima extends Model
{
    protected $table = 'materia_prima';
    protected $primaryKey = 'id_materia_prima';

    protected $allowedFields = [
        'id_materia_prima',
        'nombre',
        'descripcion',
        'unidad_medida',
        'stock_minimo',
    ];

    public function insertarMateriaPrima($data)
    {
        $builder = $this->db->table('materia_prima');
        $builder->insert($data);
        return $this->db->insertID();
    }

    public function getMateriasPrima()
    {
         $builder= $this->db->table('materia_prima');
        $builder->select('materia_prima.*');
        $query= $builder->get();
        return $query->getResultArray();
    }
}
