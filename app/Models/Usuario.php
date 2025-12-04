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
        $builder->select('usuario.* , r.tipo_rol as rol, concat(pn.nombre, " ", pn.apellido) as persona, e.estatus');
        $builder->join('roles r', 'usuario.id_roles = r.id_roles', 'inner');
        $builder->join('persona p', 'usuario.id_persona = p.id_persona', 'inner');
        $builder->join('per_natural pn', 'p.id_persona = pn.id_persona', 'inner');
        $builder->join('empleado e', 'p.id_persona = e.id_persona', 'inner');
        $builder->where('e.estatus', 'A');
        $query= $builder->get();
        return $query->getResultArray();
    }

    public function getOneUsuario($id_usuario){
        $builder= $this->db->table('usuario');
        $builder->select('usuario.* , r.tipo_rol as rol, pn.nombre, pn.apellido');
        $builder->join('roles r', 'usuario.id_roles = r.id_roles', 'inner');
        $builder->join('persona p', 'usuario.id_persona = p.id_persona', 'inner');
        $builder->join('per_natural pn', 'p.id_persona = pn.id_persona', 'inner');
        $builder->where('usuario.id_usuario', $id_usuario);
        $query= $builder->get();
        return $query->getRowObject();
    }

    public function actualizarUsuario($id_usuario, $data){
        $builder = $this->db->table('usuario');
        $builder->where('id_usuario', $id_usuario);
        return $builder->update($data);
    }

    public function getOneUsuarioValidar($nick){
        $builder= $this->db->table('usuario');
        $builder->select('usuario.* , r.tipo_rol as rol, concat(pn.nombre, " ", pn.apellido) as persona');
        $builder->join('roles r', 'usuario.id_roles = r.id_roles', 'inner');
        $builder->join('persona p', 'usuario.id_persona = p.id_persona', 'inner');
        $builder->join('per_natural pn', 'p.id_persona = pn.id_persona', 'inner');
        $builder->join('empleado e', 'p.id_persona = e.id_persona', 'inner');
        $builder->where('e.estatus', 'A');
        $builder->where('usuario.nick', $nick);
        $query= $builder->get();
        return $query->getResultObject();
    }
}