<?php

namespace App\Models;

use CodeIgniter\Model;

class LoteModel extends Model
{
    protected $table            = 'inventario';
    protected $primaryKey       = 'codigo_lote';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = ['codigo_lote', 'id_producto', 'id_empleado', 'fecha_ingreso', 'cantidad_inicial', 'cantidad_disponible'];

    public function getLotesConDetalles()
    {
        return $this->select('inventario.*, producto.descripcion as producto, CONCAT(per_natural.nombre, " ", per_natural.apellido) as costurero')
            ->join('producto', 'producto.id_producto = inventario.id_producto')
            ->join('empleado', 'empleado.id_empleado = inventario.id_empleado')
            ->join('persona', 'persona.id_persona = empleado.id_persona')
            ->join('per_natural', 'per_natural.id_persona = persona.id_persona')
            ->orderBy('inventario.fecha_ingreso', 'DESC')
            ->findAll();
    }
}