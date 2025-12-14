<?php

namespace App\Models;

use CodeIgniter\Model;

class Provedor extends Model
{
    protected $table = 'proveedor';
    protected $primaryKey = 'id_proveedor';

    protected $allowedFields = [
        "id_proveedor",
        "id_persona"
    ];

    public function insertarProvedor($data){
        $builder = $this->db->table('proveedor');
        return $builder->insert($data); 
    }
}