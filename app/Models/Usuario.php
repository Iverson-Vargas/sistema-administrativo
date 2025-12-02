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
        $builder->insert($data);
        return $this->db->insertID(); // Devolvemos el ID del usuario insertado
    }

    public function getUsuario(){
        $builder= $this->db->table('usuario');
        $builder->select('usuario.* , r.tipo_rol as rol, concat(pn.nombre, " ", pn.apellido) as persona');
        $builder->join('roles r', 'usuario.id_roles = r.id_roles', 'inner');
        $builder->join('persona p', 'usuario.id_persona = p.id_persona', 'inner');
        $builder->join('per_natural pn', 'p.id_persona = pn.id_persona', 'inner');
        $query= $builder->get();
        return $query->getResultArray();
    }

    public function getOneUsuario($nick){
        $builder= $this->db->table('usuario');
        $builder->select('usuario.* , r.tipo_rol as rol, concat(pn.nombre, " ", pn.apellido) as persona');
        $builder->join('roles r', 'usuario.id_roles = r.id_roles', 'inner');
        $builder->join('persona p', 'usuario.id_persona = p.id_persona', 'inner');
        $builder->join('per_natural pn', 'p.id_persona = pn.id_persona', 'inner');
        $builder->where('usuario.nick', $nick);
        $query= $builder->get();
        return $query->getResultObject();
    }
}