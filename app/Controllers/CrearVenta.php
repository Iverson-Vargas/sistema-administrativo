<?php

namespace App\Controllers;


use App\Models\Empleado;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Inventario;


class CrearVenta extends BaseController
{
    /**
     * Lista los productos disponibles en inventario para ser vendidos.
     * Retorna un JSON con los datos necesarios para el select de la vista.
     */
    public function listarProductosVenta()
    {
        try {
            $db = \Config\Database::connect();
            // Consultamos el inventario uniendo con producto, talla y tono
            $builder = $db->table('inventario i');
            // Agrupamos por producto, talla y tono para mostrar el stock total disponible
            $builder->select('p.id_producto, t.id_talla, tn.id_tono, MAX(i.codigo_lote) as codigo_lote, p.nombre as producto, t.descripcion as talla, tn.descripcion as tono, p.precio_unitario as precio, SUM(i.cantidad_disponible) as stock');
            $builder->join('producto p', 'p.id_producto = i.id_producto');
            $builder->join('talla t', 't.id_talla = i.id_talla');
            $builder->join('tono tn', 'tn.id_tono = i.id_tono');
            // Filtramos solo los que tienen stock positivo
            $builder->where('i.cantidad_disponible >', 0);
            $builder->groupBy(['p.id_producto', 't.id_talla', 'tn.id_tono']);
            $builder->orderBy('p.nombre', 'ASC');
            
            $query = $builder->get();
            $productos = $query->getResultArray();

            return $this->response->setJSON(['success' => true, 'data' => $productos]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Error al cargar productos: ' . $e->getMessage()]);
        }
    }

    /**
     * Procesa la venta: crea el registro en venta, sus detalles y descuenta inventario.
     */
    public function generarVenta()
    {
        $db = \Config\Database::connect();
        
        try {
            $json = $this->request->getJSON();

            // 1. Validar datos de entrada
            $idCliente = $json->id_cliente ?? null;
            $totalVenta = $json->total_venta ?? 0;
            $productos = $json->productos ?? [];

            if (empty($idCliente) || empty($productos)) {
                return $this->response->setJSON(['success' => false, 'message' => 'Datos de venta incompletos.']);
            }

            // 2. Obtener ID del empleado (vendedor) desde la sesión
            $session = session();
            $idUsuario = $session->get('id_usuario');

            if (!$idUsuario) {
                return $this->response->setJSON(['success' => false, 'message' => 'Usuario no autenticado.']);
            }

            $empleadoModel = new Empleado();
            // Intentamos usar el método del modelo si existe (como en CrearCompra), sino fallback manual
            if (method_exists($empleadoModel, 'retonarIdEmpleado')) {
                $idEmpleado = $empleadoModel->retonarIdEmpleado($idUsuario);
            } else {
                // Búsqueda manual: Usuario -> Persona -> Empleado
                $query = $db->table('usuario u')
                            ->select('e.id_empleado')
                            ->join('persona p', 'p.id_persona = u.id_persona')
                            ->join('empleado e', 'e.id_persona = p.id_persona')
                            ->where('u.id_usuario', $idUsuario)
                            ->get();
                $row = $query->getRow();
                $idEmpleado = $row ? $row->id_empleado : null;
            }

            if (!$idEmpleado) {
                return $this->response->setJSON(['success' => false, 'message' => 'No se pudo identificar al empleado vendedor.']);
            }

            $db->transBegin();

            // 3. Insertar Venta
            $ventaModel = new Venta();
            $datosVenta = [
                'id_cliente' => $idCliente,
                'id_empleado' => $idEmpleado,
                'fecha' => date('Y-m-d H:i:s'),
                'total' => $totalVenta
            ];
            
            if (!$ventaModel->insert($datosVenta)) {
                $errors = $ventaModel->errors() ? implode(', ', $ventaModel->errors()) : 'Error desconocido al insertar venta';
                throw new \Exception($errors);
            }
            $idVenta = $ventaModel->getInsertID();

            // 4. Procesar Detalles y Descontar Inventario
            $detalleVentaModel = new DetalleVenta();
            $inventarioModel = new Inventario();

            foreach ($productos as $prod) {
                // 1. Validar que vengan los IDs necesarios
                if (empty($prod->id_producto) || empty($prod->id_talla) || empty($prod->id_tono)) {
                    throw new \Exception("Datos insuficientes para identificar el producto (Lote: " . ($prod->codigo_lote ?? '?') . ")");
                }

                // 2. Buscar todos los lotes disponibles EXACTAMENTE de ese producto/talla/tono (FIFO)
                // Ya no buscamos por codigo_lote, sino por la combinación única de características
                $lotesDisponibles = $inventarioModel->where([
                    'id_producto' => $prod->id_producto,
                    'id_talla'    => $prod->id_talla,
                    'id_tono'     => $prod->id_tono,
                    'cantidad_disponible >' => 0
                ])->orderBy('id_inventario', 'ASC')->findAll();

                // Validar stock total antes de procesar
                $stockTotalDisponible = 0;
                foreach ($lotesDisponibles as $lote) {
                    $stockTotalDisponible += (float)$lote['cantidad_disponible'];
                }

                $cantidadRequerida = (float)$prod->cantidad;

                if ($stockTotalDisponible < $cantidadRequerida) {
                    throw new \Exception("Stock insuficiente para el producto (Ref: {$prod->codigo_lote}). Solicitado: {$cantidadRequerida}, Disponible: {$stockTotalDisponible}");
                }

                foreach ($lotesDisponibles as $lote) {
                    if ($cantidadRequerida <= 0) break;

                    $stockLote = (float)$lote['cantidad_disponible'];
                    $cantidadADescontar = min($cantidadRequerida, $stockLote);
                    
                    // Actualizar stock del lote específico
                    $nuevoStock = $stockLote - $cantidadADescontar;
                    if (!$inventarioModel->update($lote['id_inventario'], ['cantidad_disponible' => $nuevoStock])) {
                        throw new \Exception("Error al actualizar stock del lote " . $lote['codigo_lote']);
                    }

                    // Registrar detalle de venta con el lote real usado
                    $datosDetalle = [
                        'id_venta' => $idVenta,
                        'id_producto' => $lote['id_producto'],
                        'codigo_lote' => $lote['codigo_lote'],
                        'cantidad' => $cantidadADescontar,
                        'precio_unitario' => $prod->precio_unitario,
                        'subtotal' => $cantidadADescontar * $prod->precio_unitario
                    ];
                    if (!$detalleVentaModel->insert($datosDetalle)) {
                        $errors = $detalleVentaModel->errors() ? implode(', ', $detalleVentaModel->errors()) : 'Error al insertar detalle';
                        throw new \Exception($errors);
                    }

                    $cantidadRequerida -= $cantidadADescontar;
                }

                if ($cantidadRequerida > 0) {
                    throw new \Exception("Stock insuficiente para el producto: " . $infoReferencia['codigo_lote']);
                }
            }

            if ($db->transStatus() === false) {
                $db->transRollback();
                $dbError = $db->error();
                throw new \Exception('Error de transacción: ' . ($dbError['message'] ?? 'Error desconocido'));
            }

            $db->transCommit();
            return $this->response->setJSON(['success' => true, 'message' => 'Venta registrada exitosamente.']);

        } catch (\Exception $e) {
            $db->transRollback();
            return $this->response->setJSON(['success' => false, 'message' => 'Error del servidor: ' . $e->getMessage()]);
        }
    }
}