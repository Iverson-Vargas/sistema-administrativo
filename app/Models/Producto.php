<?php

namespace App\Models;

use CodeIgniter\Model;

class Producto extends Model
{
    protected $table = 'producto';
    protected $primaryKey = 'id_producto';

    protected $allowedFields = [
        'id_producto',
        'id_tono',
        'id_talla',
        'descripcion',
        'precio_unitario'
    ];

    public function insertarMiProducto($data){
        $builder = $this->db->table('producto');
        return $builder->insert($data);
    }

    public function traerProductos(){

        $builder= $this->db->table('producto');
        $builder->select('producto.* , to.descripcion as tono, ta.descripcion as talla');
        $builder->join('tono to', 'producto.id_tono = to.id_tono', 'inner');
        $builder->join('talla ta', 'producto.id_talla = ta.id_talla', 'inner');
        $query= $builder->get();
        return $query->getResultArray();

    }

}