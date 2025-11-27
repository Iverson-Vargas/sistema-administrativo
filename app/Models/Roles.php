<?php

namespace App\Models;

use CodeIgniter\Model;

class Roles extends Model{

    protected $table = 'roles';
    protected $primaryKey = 'id_roles';

    public function traerRoles(){

        $builder= $this->db->table('roles');
        $builder->select('*');
        $query= $builder->get();
        return $query->getResultArray();

    }

}