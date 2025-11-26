<?php

namespace App\Models;

use CodeIgniter\Model;

class Talla extends Model{

    protected $table = 'talla';
    protected $primaryKey = 'id_talla';

    public function traerTallas(){

        $builder= $this->db->table('talla');
        $builder->select('*');
        $query= $builder->get();
        return $query->getResultArray();

    }

}