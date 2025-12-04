<?php

namespace App\Models;

use CodeIgniter\Model;

class Producto extends Model
{
    protected $table = 'producto';
    protected $primaryKey = 'id_producto';
    protected $useAutoIncrement = false;

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

    public function getOneProducto($idProducto){
        $builder = $this->db->table('producto');
        $builder->select('producto.* , to.descripcion as tono, ta.descripcion as talla');
        $builder->join('tono to', 'producto.id_tono = to.id_tono', 'inner');
        $builder->join('talla ta', 'producto.id_talla = ta.id_talla', 'inner');
        $builder->where('producto.id_producto', $idProducto);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function actualizarProducto($idProducto, $data){
        $builder = $this->db->table('producto');
        $builder->where('id_producto', $idProducto);
        return $builder->update($data);
    }

    public function eliminarProducto($idProducto){
        // Verificar si el producto está en uso en el inventario
        $inventarioCheck = $this->db->table('inventario')->where('id_producto', $idProducto)->countAllResults();

        if ($inventarioCheck > 0) {
            // El producto está en uso, no se puede eliminar
            return false;
        }

        // Si no está en uso, proceder con la eliminación
        $builder = $this->db->table($this->table);
        return $builder->where($this->primaryKey, $idProducto)->delete();
    }

    public function ListarProductoParaLote(){
        $builder= $this->db->table('producto p');
        $builder->select("p.id_producto, concat(p.descripcion , ' Color ' ,t.descripcion , ' Talla ' , ta.descripcion) as producto_descripcion");
        $builder->join('tono t', 'p.id_tono = t.id_tono', 'inner');
        $builder->join('talla ta', 'p.id_talla = ta.id_talla', 'inner');
        $query= $builder->get();
        return $query->getResultArray();
    }
}