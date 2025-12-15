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
        'nombre',
        'descripcion',
        'precio_unitario'
    ];

    public function insertarMiProducto($data){
        $builder = $this->db->table('producto');
        return $builder->insert($data);
    }

    public function traerProductos(){

        $builder= $this->db->table('producto');
        $builder->select('producto.*');
        $query= $builder->get();
        return $query->getResultArray();

    }

    public function getOneProducto($idProducto){
        $builder = $this->db->table('producto');
        $builder->select('producto.*');
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
        // Si la tabla está vacía, countAllResults() devuelve 0, no genera error.
        $inventarioCheck = $this->db->table('inventario')->where('id_producto', $idProducto)->countAllResults();

        if ($inventarioCheck > 0) {
            // El producto está en uso, no se puede eliminar
            return false;
        }

        // Si no está en uso, proceder con la eliminación
        try {
            $builder = $this->db->table($this->table);
            return $builder->where($this->primaryKey, $idProducto)->delete();
        } catch (\Exception $e) {
            // Captura errores de integridad referencial (ej. si el producto está en ventas históricas)
            return false;
        }
    }

    public function ListarProductoParaLote(){
        $builder= $this->db->table('producto p');
        $builder->select("p.id_producto, p.nombre, p.descripcion");
        $query= $builder->get();
        return $query->getResultArray();
    }
}