<?php

namespace App\Models;

use CodeIgniter\Model;

class ReporteModel extends Model
{
    /**
     * Obtiene la suma de unidades producidas agrupadas por costurero.
     * Puede ser filtrado por un rango de fechas.
     */
    public function getProduccionPorCosturero($fechaDesde = null, $fechaHasta = null)
    {
        // IMPORTANTE: Ajusta los nombres de tablas y columnas si son diferentes en tu base de datos.
        $builder = $this->db->table('produccion');
        $builder->select("CONCAT(pn.nombre, ' ', pn.apellido) AS costurero, SUM(produccion.cantidad) AS total_producido");
        $builder->join('empleado e', 'produccion.id_empleado = e.id_empleado');
        $builder->join('persona p', 'e.id_persona = p.id_persona');
        $builder->join('per_natural pn', 'p.id_persona = pn.id_persona');

        if ($fechaDesde && $fechaHasta) {
            $builder->where('produccion.fecha_produccion >=', $fechaDesde);
            $builder->where('produccion.fecha_produccion <=', $fechaHasta);
        }

        $builder->groupBy('produccion.id_empleado, costurero');
        $builder->orderBy('total_producido', 'DESC');

        return $builder->get()->getResultArray();
    }

     // --- Aquí puedes agregar los métodos para las consultas de los otros 8 reportes ---
    /**
     * Obtiene el listado de productos con su stock actual.
     */
    public function getInventarioActual()
    {
        // NOTA: Esta consulta asume que tienes una columna 'stock' en tu tabla 'producto'.
        // Si no es así, deberás calcular el stock real sumando las entradas de 'produccion'
        // y restando las salidas de 'detalle_venta' para cada producto.
        // CORRECCIÓN: Esta consulta ahora usa la tabla `inventario` para calcular el stock real.
        // Suma la `cantidad_disponible` de todos los lotes para cada producto.
        $builder = $this->db->table('producto p');
        $builder->select("CONCAT(p.descripcion, ' (', p.id_producto, ')') AS producto_desc, t.descripcion as talla, o.descripcion as tono, p.stock_actual AS stock");
        $builder->select("
            CONCAT(p.descripcion, ' (', p.id_producto, ')') AS producto_desc, 
            t.descripcion as talla, 
            o.descripcion as tono, 
            SUM(i.cantidad_disponible) AS stock
        ");
        $builder->join('inventario i', 'p.id_producto = i.id_producto', 'left');
        $builder->join('talla t', 'p.id_talla = t.id_talla');
        $builder->join('tono o', 'p.id_tono = o.id_tono');
        // ->where('p.stock_actual >', 0) // Descomenta si solo quieres ver productos con stock
        $builder->groupBy('p.id_producto, p.descripcion, t.descripcion, o.descripcion');
        $builder->having('stock >', 0);
        $builder->orderBy('p.descripcion', 'ASC');

        return $builder->get()->getResultArray();
    }

    // --- Aquí puedes agregar los métodos para las consultas de los otros 8 reportes ---
    /**
     * Obtiene el top 10 de productos más vendidos por cantidad.
     * Puede ser filtrado por un rango de fechas.
     */
    public function getProductosMasVendidos($fechaDesde = null, $fechaHasta = null)
    {
        $builder = $this->db->table('detalle_venta dv');
        $builder->select("p.descripcion AS producto, SUM(dv.cantidad) AS total_vendido");
        $builder->join('producto p', 'dv.id_producto = p.id_producto');
        $builder->join('venta v', 'dv.id_venta = v.id_venta'); // Necesario para filtrar por fecha

        if ($fechaDesde && $fechaHasta) {
            $builder->where('v.fecha >=', $fechaDesde);
            $builder->where('v.fecha <=', $fechaHasta);
        }

        $builder->groupBy('p.id_producto, p.descripcion');
        $builder->orderBy('total_vendido', 'DESC');
        $builder->limit(10); // Obtenemos solo el top 10

        return $builder->get()->getResultArray();
    }
    // --- Aquí puedes agregar los métodos para las consultas de los otros 8 reportes ---

}
