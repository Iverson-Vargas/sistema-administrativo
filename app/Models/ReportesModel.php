<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportesModel extends Model
{
    public function getProductsForCorrelation()
    {
        // Seleccionamos productos que han sido vendidos al menos 3 veces
        // y a por lo menos 2 precios distintos para que el análisis de correlación sea significativo.
        return $this->db->table('detalle_venta dv')
            ->select('p.id_producto, p.descripcion')
            ->join('producto p', 'p.id_producto = dv.id_producto')
            ->groupBy('p.id_producto, p.descripcion')
            ->having('COUNT(dv.id_detalle_venta) >= 3') // Mínimo 3 puntos de datos
            ->having('COUNT(DISTINCT dv.precio_unitario) >= 2') // Mínimo 2 precios diferentes
            ->get()
            ->getResultArray();
    }

    public function getCorrelationDataForProduct(string $productId)
    {
        // Obtenemos los pares de (precio_unitario, cantidad) para un producto específico.
        // Estos serán los ejes X e Y del gráfico de dispersión.
        return $this->db->table('detalle_venta')
            ->select('precio_unitario AS x, cantidad AS y')
            ->where('id_producto', $productId)
            ->get()
            ->getResultArray();
    }
    
    // Nuevo método para obtener un listado de ventas
    public function getListadoVentas(string $fechaDesde = null, string $fechaHasta = null, string $clienteCi = null, int $idEmpleado = null)
    {
        $builder = $this->db->table('venta v');
        // Se hace la consulta más robusta, eliminando la dependencia de la tabla `per_juridica` que podría no existir
        // y usando COALESCE para manejar datos eliminados (clientes o vendedores).
        $builder->select('v.id_venta, v.fecha, v.total,
                          COALESCE(CONCAT(pn_cliente.nombre, " ", pn_cliente.apellido), "Cliente no encontrado") as nombre_cliente,
                          p_cliente.ci_rif as ci_rif_cliente,
                          COALESCE(CONCAT(pn_empleado.nombre, " ", pn_empleado.apellido), "Vendedor no encontrado") as nombre_empleado');
        $builder->join('cliente c', 'c.id_cliente = v.id_cliente', 'left');
        $builder->join('persona p_cliente', 'p_cliente.id_persona = c.id_persona', 'left');
        $builder->join('per_natural pn_cliente', 'pn_cliente.id_persona = p_cliente.id_persona', 'left');
        $builder->join('empleado e', 'e.id_empleado = v.id_empleado', 'left');
        $builder->join('persona p_empleado', 'p_empleado.id_persona = e.id_persona', 'left');
        $builder->join('per_natural pn_empleado', 'pn_empleado.id_persona = p_empleado.id_persona', 'left');

        if ($fechaDesde && $fechaHasta) {
            $builder->where('v.fecha >=', $fechaDesde);
            $builder->where('v.fecha <=', $fechaHasta);
        }

        if ($clienteCi) {
            $builder->where('p_cliente.ci_rif', $clienteCi);
        }

        if ($idEmpleado) {
            $builder->where('v.id_empleado', $idEmpleado);
        }

        return $builder->orderBy('v.fecha', 'DESC')->get()->getResultArray();
    }

    // Nuevo método para obtener los detalles de una venta específica
    public function getDetalleVenta(int $idVenta)
    {
        return $this->db->table('detalle_venta dv')
            // Se usa LEFT JOIN y COALESCE para que el detalle se muestre incluso si el producto fue eliminado.
            ->select('dv.cantidad, dv.precio_unitario, COALESCE(p.descripcion, "Producto eliminado") as producto_descripcion, dv.id_producto')
            ->join('producto p', 'p.id_producto = dv.id_producto', 'left')
            ->where('dv.id_venta', $idVenta)
            ->get()
            ->getResultArray();
    }

    public function getListadoCompras()
    {
        $builder = $this->db->table('compra c');
        $builder->select('c.id_compra, c.fecha, c.numero_factura_fisica, c.total_compra,
                          COALESCE(pj.razon_social, CONCAT(pn_prov.nombre, " ", pn_prov.apellido), "Proveedor no encontrado") as nombre_proveedor,
                          p_prov.ci_rif as rif_proveedor,
                          COALESCE(CONCAT(pn_emp.nombre, " ", pn_emp.apellido), "Empleado no encontrado") as nombre_empleado');
        $builder->join('proveedor prov', 'prov.id_proveedor = c.id_proveedor', 'left');
        $builder->join('persona p_prov', 'p_prov.id_persona = prov.id_persona', 'left');
        $builder->join('per_juridica pj', 'pj.id_persona = p_prov.id_persona', 'left');
        $builder->join('per_natural pn_prov', 'pn_prov.id_persona = p_prov.id_persona', 'left');
        $builder->join('empleado e', 'e.id_empleado = c.id_empleado', 'left');
        $builder->join('persona p_emp', 'p_emp.id_persona = e.id_persona', 'left');
        $builder->join('per_natural pn_emp', 'pn_emp.id_persona = p_emp.id_persona', 'left');
        
        // Aquí se podrían agregar filtros por fecha, proveedor, etc.
        
        return $builder->orderBy('c.fecha', 'DESC')->get()->getResultArray();
    }

    public function getDetalleCompra(int $idCompra)
    {
        return $this->db->table('detalle_compra dc')
            ->select('dc.cantidad, dc.costo_unitario, COALESCE(p.descripcion, "Producto/Insumo eliminado") as producto_descripcion, dc.id_producto')
            ->join('producto p', 'p.id_producto = dc.id_producto', 'left')
            ->select('dc.cantidad, dc.costo_unitario, COALESCE(mp.nombre, "Materia Prima eliminada") as producto_descripcion, dc.id_materia_prima')
            ->join('materia_prima mp', 'mp.id_materia_prima = dc.id_materia_prima', 'left')
            ->where('dc.id_compra', $idCompra)
            ->get()
            ->getResultArray();
    }
}

