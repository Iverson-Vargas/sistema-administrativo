<?php

namespace App\Controllers;

use App\Models\VentaModel;
use App\Models\ClienteModel;
use App\Models\Producto; // Usamos el modelo Producto para obtener detalles
use CodeIgniter\RESTful\ResourceController;

class VentaController extends ResourceController
{
    protected $format = 'json';

    public function buscarProductos()
    {
        $searchTerm = $this->request->getGet('term');

        if (empty($searchTerm)) {
            return $this->respond(['success' => true, 'data' => []]);
        }

        $db = \Config\Database::connect();
        $builder = $db->table('producto p');
        $builder->select('p.id_producto, p.descripcion, p.precio_unitario, SUM(i.cantidad_disponible) as stock_disponible');
        $builder->join('inventario i', 'p.id_producto = i.id_producto', 'left');
        $builder->like('p.descripcion', $searchTerm);
        $builder->orLike('p.id_producto', $searchTerm);
        $builder->groupBy('p.id_producto, p.descripcion, p.precio_unitario');
        $builder->having('stock_disponible >', 0); // Solo productos con stock disponible
        $productos = $builder->get()->getResultArray();

        return $this->respond(['success' => true, 'data' => $productos]);
    }

    public function listarProductosDisponibles()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('producto p');
        $builder->select('p.id_producto, p.descripcion, p.precio_unitario, SUM(i.cantidad_disponible) as stock_disponible');
        $builder->join('inventario i', 'p.id_producto = i.id_producto', 'left');
        $builder->groupBy('p.id_producto, p.descripcion, p.precio_unitario');
        $builder->having('stock_disponible >', 0); // Solo productos con stock disponible
        $productos = $builder->get()->getResultArray();

        // Se devuelve en un formato compatible con DataTables
        return $this->respond(['data' => $productos]);
    }

    public function procesarVenta()
    {
        $ventaData = $this->request->getJSON(true);

        // Validaciones básicas
        if (empty($ventaData['cliente_ci']) || empty($ventaData['productos']) || !is_array($ventaData['productos'])) {
            return $this->failValidationErrors('Datos de venta incompletos o inválidos.');
        }

        $clienteCi = $ventaData['cliente_ci'];
        $productosEnVenta = $ventaData['productos'];
        $totalVenta = 0;

        // Obtener id_empleado de la sesión
        $session = session();
        $idUsuario = $session->get('id_usuario');
        if (!$idUsuario) {
            return $this->failUnauthorized('No hay un usuario autenticado para registrar la venta.');
        }

        // Necesitamos el id_empleado a partir del id_usuario
        $db = \Config\Database::connect();
        $empleadoQuery = $db->table('usuario u')
                            ->select('e.id_empleado')
                            ->join('persona p', 'p.id_persona = u.id_persona')
                            ->join('empleado e', 'e.id_persona = p.id_persona')
                            ->where('u.id_usuario', $idUsuario)
                            ->get()
                            ->getRow();

        if (!$empleadoQuery || !$empleadoQuery->id_empleado) {
            return $this->failServerError('No se pudo determinar el empleado asociado al usuario actual.');
        }
        $idEmpleado = $empleadoQuery->id_empleado;

        $clienteModel = new ClienteModel();
        $cliente = $clienteModel->getClienteByCiRif($clienteCi);

        if (!$cliente) {
            // Si el cliente no existe, creamos uno genérico o devolvemos un error
            // Por simplicidad, vamos a crear un cliente genérico si no existe.
            // En un sistema real, se pedirían más datos o se usaría un cliente "consumidor final".
            $personaData = ['tipo' => 'N', 'ci_rif' => $clienteCi, 'telefono' => 'N/A', 'correo' => 'N/A', 'direccion' => 'N/A'];
            $perNaturalData = ['nombre' => 'Cliente', 'apellido' => 'Generico', 'sexo' => 'N/A'];
            $idCliente = $clienteModel->crearNuevoCliente($personaData, $perNaturalData);
            if (!$idCliente) {
                return $this->failServerError('No se pudo crear el cliente.');
            }
        } else {
            $idCliente = $cliente['id_cliente'];
        }

        $detallesParaGuardar = [];
        foreach ($productosEnVenta as $prod) {
            $subtotal = $prod['cantidad'] * $prod['precio_unitario'];
            $totalVenta += $subtotal;
            $detallesParaGuardar[] = [
                'id_producto' => $prod['id_producto'],
                'cantidad' => $prod['cantidad'],
                'precio_unitario' => $prod['precio_unitario'],
            ];
        }

        $ventaModel = new VentaModel();
        $ventaHeader = [
            'id_cliente' => $idCliente,
            'id_empleado' => $idEmpleado,
            'fecha' => date('Y-m-d'),
            'total' => $totalVenta,
        ];

        $idVenta = $ventaModel->insertarVentaConDetalles($ventaHeader, $detallesParaGuardar);

        if ($idVenta) {
            return $this->respondCreated(['success' => true, 'message' => 'Venta procesada exitosamente.', 'id_venta' => $idVenta]);
        } else {
            return $this->failServerError('Ocurrió un error al procesar la venta. Por favor, intente de nuevo.');
        }
    }
}
