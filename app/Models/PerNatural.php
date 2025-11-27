<?php

namespace App\Models;
use CodeIgniter\Model;

class PerNatural extends Model
{
    protected $table = 'per_natural';
    protected $primaryKey = 'id_per_natural';

    protected $allowedFields = [
        'id_per_natural',
        'id_persona',
        'nombre',
        'apellido',
        'sexo'
    ];

    public function insertarMiPerNatural($data){
        $builder = $this->db->table('per_natural');
        return $builder->insert($data); // No necesita devolver ID, solo el resultado
    }
}