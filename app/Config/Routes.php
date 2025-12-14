<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'MostrarVistas::mostrarLogin');
$routes->get('/home', 'MostrarVistas::mostrarHome');
$routes->get('/reportes', 'MostrarVistas::mostrarReportes');
$routes->get('/generarVenta', 'MostrarVistas::mostrarGenerarVenta');
$routes->get('/generarCompra', 'MostrarVistas::mostrarGenerarCompra');
$routes->get('/reporteVentas', 'MostrarVistas::mostrarReporteVentas');
$routes->get('/reporteCompras', 'MostrarVistas::mostrarReporteCompras');
$routes->get('/crearLote', 'MostrarVistas::mostrarCrearLote');
$routes->get('/producto', 'MostrarVistas::mostrarProducto');
$routes->get('/usuario', 'MostrarVistas::mostrarUsuario');
$routes->get('/costurero', 'MostrarVistas::mostrarCosturero');
$routes->get('/listaTono', 'ListarTonos::returnTonos');
$routes->get('/listaTalla', 'ListarTallas::returnTallas');
$routes->post('/crearProducto', 'CreateProducto::validarProducto');
$routes->get('listaProductoLote', 'ListarProducto::ProductoParaLote'); // Para el formulario de crear lote
$routes->get('/listaProducto', 'ListarProducto::returnProductos');
$routes->get('/listaRoles', 'ListarRoles::returnRoles');
$routes->post('/crearUsuario', 'CrearUsuario::CrearUnUsuario');
$routes->get('/listaUsuarios', 'ListarUsuarios::returnUsuarios');
$routes->post('/validarDatos', 'Login::validarDatos');
$routes->get('/salir', 'CerrarSesion::cerrarSession');
$routes->get('/personal', 'MostrarVistas::mostrarPersonal');
$routes->post('/crearCosturero', 'CrearCosturero::CrearUnCosturero');
$routes->get('/listaCostureros', 'ListarCostureros::returnCostureros');
$routes->post('crearLote', 'CrearLoteInventario::createLote'); // Acción de crear un lote
$routes->get('listaLotes', 'CrearLoteInventario::obtenerLotes'); // Para el dashboard y la gestión de lotes
$routes->get('/listaEmpleados', 'ListarEmpleados::returnEmpleados');
$routes->get('/getOneEmpleado/(:num)', 'ListarEmpleados::getOneEmpleado/$1');
$routes->post('/actualizarEmpleado/(:num)', 'ListarEmpleados::actualizarEmpleado/$1');
$routes->post('ventas/procesar', 'VentaController::procesarVenta'); // Nueva
$routes->get('ventas/listarDisponibles', 'VentaController::listarProductosDisponibles');
$routes->post('crearProvedor', 'CrearProvedor::CrearUnProvedor');
$routes->post('buscarProvedor', 'BuscarProvedor::buscarPorCiRif');
$routes->post('procesarCompra', 'CrearCompra::generarCompra');
$routes->get('getOneProducto/(:segment)', 'ListarProducto::getOneProducto/$1');
$routes->post('actualizarProducto/(:segment)', 'ListarProducto::actualizarProducto/$1');
$routes->post('eliminarProducto/(:segment)', 'ListarProducto::eliminarProducto/$1');

// Rutas para Compras
$routes->post('compra/procesar', 'CompraController::procesarCompra');
$routes->get('compra/listarInsumos', 'CompraController::listarInsumos');

// Grupo de rutas para los reportes, más organizado
$routes->group('reportes', function ($routes) {
    // Reportes de la vista principal de reportes (reportes.php)
    $routes->get('produccionPorCosturero', 'Reportes::produccionPorCosturero');
    $routes->get('inventarioActual', 'Reportes::inventarioActual');
    $routes->get('productosMasVendidos', 'Reportes::productosMasVendidos');
    $routes->get('rendimientoVendedores', 'Reportes::rendimientoVendedores');
    $routes->get('getProductsForCorrelation', 'Reportes::getProductsForCorrelation');
    $routes->get('getCorrelationDataForProduct', 'Reportes::getCorrelationDataForProduct');
    
    // Rutas para la vista de reporte de ventas (reporteVentas.php)
    $routes->get('listadoVentas', 'Reportes::listadoVentas');
    $routes->get('detalleVenta/(:num)', 'Reportes::detalleVenta/$1');

    // Rutas para la vista de reporte de compras (reporteCompras.php)
    $routes->get('listadoCompras', 'Reportes::listadoCompras');
    $routes->get('detalleCompra/(:num)', 'Reportes::detalleCompra/$1');
});
