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
        if ($builder->insert($data)) {
            return $this->db->insertID();
        }
        return false;
    }

    public function buscarPorCiRif($ci_rif){
        return $this->select('persona.*, pr.id_proveedor, pn.nombre, pn.apellido, pn.sexo, pj.razon_social, e.estatus as estatus_empleado')
                    ->join('per_natural pn', 'persona.id_persona = pn.id_persona', 'left')
                    ->join('per_juridica pj', 'persona.id_persona = pj.id_persona', 'left')
                    ->join('empleado e', 'persona.id_persona = e.id_persona', 'left')
                    ->join('proveedor pr', 'persona.id_persona = pr.id_persona', 'left')    
                    ->where('persona.ci_rif', $ci_rif)
                    ->first();
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