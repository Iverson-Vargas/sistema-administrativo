<?php

namespace App\Controllers;

use App\Models\CompraModel;
use App\Models\ProveedorModel;
use App\Models\Producto;
use CodeIgniter\RESTful\ResourceController;

class CompraController extends ResourceController
{
    protected $format = 'json';

    // Lista todos los productos para ser comprados (no filtra por stock)
    public function listarInsumos()
    {
        $productoModel = new Producto();
        $productos = $productoModel->traerProductos();
        return $this->respond(['data' => $productos]);
    }

    public function procesarCompra()
    {
        $compraData = $this->request->getJSON(true);

        if (empty($compraData['proveedor_rif']) || empty($compraData['productos']) || !is_array($compraData['productos'])) {
            return $this->failValidationErrors('Datos de compra incompletos o inválidos.');
        }

        $proveedorRif = $compraData['proveedor_rif'];
        $proveedorNombre = $compraData['proveedor_nombre'] ?? null; // Nombre del proveedor si es nuevo
        $numeroFactura = $compraData['numero_factura'] ?? null; // Nuevo campo
        $productosEnCompra = $compraData['productos'];
        $totalCompra = 0;

        // Obtener id_empleado de la sesión
        $session = session();
        $idUsuario = $session->get('id_usuario');
        if (!$idUsuario) {
            return $this->failUnauthorized('No hay un usuario autenticado para registrar la compra.');
        }

        $db = \Config\Database::connect();
        $empleadoQuery = $db->table('usuario u')
            ->select('e.id_empleado')
            ->join('persona p', 'p.id_persona = u.id_persona')
            ->join('empleado e', 'e.id_persona = p.id_persona')
            ->where('u.id_usuario', $idUsuario)->get()->getRow();

        if (!$empleadoQuery || !$empleadoQuery->id_empleado) {
            return $this->failServerError('No se pudo determinar el empleado asociado al usuario actual.');
        }
        $idEmpleado = $empleadoQuery->id_empleado;

        // Buscar o crear proveedor
        $proveedorModel = new ProveedorModel();
        $proveedor = $proveedorModel->getProveedorByRif($proveedorRif);

        if (!$proveedor) {
            // Si el proveedor no existe, lo creamos con el nombre proporcionado
            $razonSocial = !empty($proveedorNombre) ? $proveedorNombre : 'Proveedor ' . $proveedorRif;
            $idProveedor = $proveedorModel->crearNuevoProveedor($proveedorRif, $razonSocial);
            if (!$idProveedor) {
                return $this->failServerError('No se pudo crear el nuevo proveedor.');
            }
        } else {
            $idProveedor = $proveedor['id_proveedor'];
        }

        // Preparar detalles y calcular total
        $detallesParaGuardar = [];
        foreach ($productosEnCompra as $prod) {
            $subtotal = $prod['cantidad'] * $prod['costo_unitario'];
            $totalCompra += $subtotal;
            $detallesParaGuardar[] = ['id_producto' => $prod['id_producto'], 'cantidad' => $prod['cantidad'], 'costo_unitario' => $prod['costo_unitario']];
        }

        $compraModel = new CompraModel();
        $compraHeader = [
            'id_proveedor' => $idProveedor, 
            'id_empleado' => $idEmpleado, 
            'fecha' => date('Y-m-d'),
            'numero_factura_fisica' => $numeroFactura,
            'total_compra' => $totalCompra
        ];
        $idCompra = $compraModel->insertarCompraConDetalles($compraHeader, $detallesParaGuardar, $idEmpleado);

        if ($idCompra) {
            return $this->respondCreated(['success' => true, 'message' => 'Compra procesada exitosamente.', 'id_compra' => $idCompra]);
        } else {
            return $this->failServerError('Ocurrió un error al procesar la compra. Por favor, intente de nuevo.');
        }
    }
}

