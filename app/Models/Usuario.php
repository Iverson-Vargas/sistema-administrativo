<?php

namespace App\Models;
use CodeIgniter\Model;
class Usuario extends Model
{
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';

    protected $allowedFields = [
        'id_usuario',
        'id_roles',
        'id_persona',
        'nick',
        'contrasena'
    ];

    public function insertarMiUsuario($data){
        $builder = $this->db->table('usuario');
        return $builder->insert($data); // No necesita devolver ID, solo el resultado
    }
}