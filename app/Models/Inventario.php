<?php

namespace App\Models;

use CodeIgniter\Model;

class Inventario extends Model
{
    protected $table            = 'inventario';
    protected $primaryKey       = 'codigo_lote';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'codigo_lote',
        'id_producto',
        'id_empleado',
        'fecha_ingreso',
        'cantidad_inicial',
        'cantidad_disponible'
    ];

    public function insertarInventario($data)
    {
        $builder = $this->db->table('inventario');
        return $builder->insert($data);
    }

    public function obtenerProductos()
    {
        $builder = $this->db->table('inventario i');
        $builder->select('i.*, CONCAT(pn.nombre, " ", pn.apellido) as costurero, CONCAT(p.descripcion, " Color ", t.descripcion, " talla ", ta.descripcion) as producto');
        $builder->join('producto p', 'i.id_producto = p.id_producto');
        $builder->join('tono t', 'p.id_tono = t.id_tono', 'inner');
        $builder->join('talla ta', 'p.id_talla = ta.id_talla', 'inner');
        $builder->join('empleado e', 'i.id_empleado = e.id_empleado', 'inner');
        $builder->join('persona pers', 'e.id_persona = pers.id_persona', 'inner');
        $builder->join('per_natural pn', 'pers.id_persona = pn.id_persona', 'inner');
        $query = $builder->get();
        return $query->getResultArray();
    }
}