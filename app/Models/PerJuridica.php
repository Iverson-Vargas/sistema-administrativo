<?php

namespace App\Models;

use CodeIgniter\Model;

class PerJuridica extends Model
{
    protected $table = 'per_juridica';
    protected $primaryKey = 'id_per_juridica';

    protected $allowedFields = [
        "id_per_juridica",
        "id_persona",
        "razon_social"
    ];  

    public function insertarMiPerJuridica($data){
        $builder = $this->db->table('per_juridica');
        return $builder->insert($data); 
    }
}