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
}