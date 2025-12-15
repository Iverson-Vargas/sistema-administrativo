<?php

namespace App\Models;

use CodeIgniter\Model;

class InventarioMateriaPrima extends Model
{
    protected $table = 'inventario_materia_prima';
    protected $primaryKey = 'id_inv_mp';

    protected $allowedFields = [
        'id_inv_mp',
        'id_materia_prima',
        'id_compra',
        'codigo_lote',
        'fecha_ingreso',
        'cantidad_disponible',
    ];

    public function insertarInventarioMateriaPrima($data)
    {
        $builder = $this->db->table('inventario_materia_prima');
        return $builder->insert($data); 
    }

    public function descontarStock($idMateriaPrima, $cantidadRequerida)
    {
        // Buscar lotes disponibles (FIFO - Primero en entrar, primero en salir)
        $lotesMp = $this->where('id_materia_prima', $idMateriaPrima)
                        ->where('cantidad_disponible >', 0)
                        ->orderBy('fecha_ingreso', 'ASC')
                        ->findAll();

        $pendienteDescontar = $cantidadRequerida;

        foreach ($lotesMp as $loteMp) {
            if ($pendienteDescontar <= 0) break;

            $disponible = $loteMp['cantidad_disponible'];
            $descontar = min($disponible, $pendienteDescontar);

            // Actualizar lote MP
            $nuevoDisponible = $disponible - $descontar;
            $this->update($loteMp['id_inv_mp'], ['cantidad_disponible' => $nuevoDisponible]);

            $pendienteDescontar -= $descontar;
        }

        if ($pendienteDescontar > 0) {
            throw new \Exception("Stock insuficiente de Materia Prima ID: $idMateriaPrima. Faltan $pendienteDescontar unidades.");
        }
    }
}
