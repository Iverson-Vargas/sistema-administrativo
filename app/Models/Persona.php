<?php

namespace App\Models;

use CodeIgniter\Model;

class Persona extends Model
{
    protected $table = 'persona';
    protected $primaryKey = 'id_persona';

    protected $allowedFields = [
        'id_persona',
        'tipo',
        'ci_rif',
        'telefono',
        'correo',
        'direccion'
    ];

    public function insertarMiPersona($data){
        $builder = $this->db->table('persona');
        $builder->insert($data);
        return $this->db->insertID();
    }

    public function getCostureros(){
        $builder= $this->db->table('persona p');
        $builder->select('e.id_empleado, pn.nombre, pn.apellido, p.ci_rif, p.telefono, fe.descripcion_cargo');
        $builder->join('empleado e', 'p.id_persona = e.id_persona', 'inner');
        $builder->join('per_natural pn', 'p.id_persona = pn.id_persona', 'inner');
        $builder->join('funcion_empleado fe', 'e.id_empleado = fe.id_empleado', 'inner');
        $builder->where('fe.descripcion_cargo', 'Costurero');
        $builder->where('e.estatus', 'A');
        $query= $builder->get();
        return $query->getResultArray();
    }   
}