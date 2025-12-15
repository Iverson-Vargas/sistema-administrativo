<?php

namespace App\Models;

use CodeIgniter\Model;

class DetalleVenta extends Model
{
    protected $table = 'detalle_venta';
    protected $primaryKey = 'id_detalle_venta';

    protected $allowedFields = [
        'id_detalle_venta',
        'id_venta',
        'id_producto',
        'cantidad',
        'precio_unitario',
    ];
}