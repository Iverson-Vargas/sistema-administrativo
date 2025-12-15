<?php

namespace App\Models;

use CodeIgniter\Model;

class Cliente extends Model
{
    protected $table = 'cliente';
    protected $primaryKey = 'id_cliente';

    protected $allowedFields = [
        'id_cliente',
        'id_persona',
    ];
    public function insertarCliente($data){
        $builder = $this->db->table('cliente');
        return $builder->insert($data); 
    }
}