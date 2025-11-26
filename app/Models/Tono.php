<?php

namespace App\Models;

use CodeIgniter\Model;

class Tono extends Model{

    protected $table = 'tono';
    protected $primaryKey = 'id_tono';

    public function traerTonos(){

        $builder= $this->db->table('tono');
        $builder->select('*');
        $query= $builder->get();
        return $query->getResultArray();

    }

}