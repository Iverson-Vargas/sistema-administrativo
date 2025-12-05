<?php

namespace App\Models;

use CodeIgniter\Model;

class PerJuridicaModel extends Model
{
    protected $table            = 'per_juridica';
    protected $primaryKey       = 'id_per_juridica';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['id_persona', 'razon_social'];
}
