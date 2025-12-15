<?php

namespace App\Models;

use CodeIgniter\Model;

class Venta extends Model
{
    protected $table = 'venta';
    protected $primaryKey = 'id_venta';

    protected $allowedFields = [
        'id_venta',
        'id_cliente',
        'id_empleado',
        'fecha',
        'total',
    ];
}