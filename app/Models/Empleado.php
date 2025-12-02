<?php

namespace App\Models;

use CodeIgniter\Model;

class Empleado extends Model
{
    protected $table = 'empleado';
    protected $primaryKey = 'id_empleado';

    protected $allowedFields = [
        'id_empleado',
        'id_persona',
        'fecha_ingreso',
        'estatus',
    ];

    public function insertarEmpleado($data)
    {
        $builder = $this->db->table('empleado');
        $builder->insert($data);
        return $this->db->insertID();
    }
}