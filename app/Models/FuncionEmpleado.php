<?php

namespace App\Models;

use CodeIgniter\Model;

class FuncionEmpleado extends Model
{
    protected $table = 'funcion_empleado';
    protected $primaryKey = 'id_funcion_empleado';

    protected $allowedFields = [
        'id_funcion_empleado',
        'id_empleado',
        'descripcion_cargo',
    ];

    public function insertarFuncionEmpleao($data){
        $builder = $this->db->table('funcion_empleado');
        return $builder->insert($data); 
    }
}