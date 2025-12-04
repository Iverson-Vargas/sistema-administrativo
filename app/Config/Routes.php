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
$routes->get('/listaProducto', 'ListarProducto::returnProductos');
$routes->get('/listaRoles', 'ListarRoles::returnRoles');
$routes->post('/crearUsuario', 'CrearUsuario::CrearUnUsuario');
$routes->get('/listaUsuarios', 'ListarUsuarios::returnUsuarios');
$routes->post('/validarDatos', 'Login::validarDatos');
$routes->get('/salir', 'CerrarSesion::cerrarSession');
$routes->get('/personal', 'MostrarVistas::mostrarPersonal');
$routes->post('/crearCosturero', 'CrearCosturero::CrearUnCosturero');
$routes->get('/listaCostureros', 'ListarCostureros::returnCostureros');
// Rutas para los reportes
$routes->get('reportes/produccionPorCosturero', 'Reportes::produccionPorCosturero');
$routes->get('reportes/productosMasVendidos', 'Reportes::productosMasVendidos');
$routes->get('reportes/getProductsForCorrelation', 'Reportes::getProductsForCorrelation');
$routes->get('reportes/getCorrelationDataForProduct', 'Reportes::getCorrelationDataForProduct');
$routes->get('/listaEmpleados', 'ListarEmpleados::returnEmpleados');
$routes->get('/getOneEmpleado/(:num)', 'ListarEmpleados::getOneEmpleado/$1');
$routes->post('/actualizarEmpleado/(:num)', 'ListarEmpleados::actualizarEmpleado/$1');
$routes->post('/deshabilitarEmpleado/(:num)', 'ListarEmpleados::deshabilitarEmpleado/$1');
$routes->get('getOneUsuario/(:num)', 'ListarUsuarios::getOneUsuario/$1');
$routes->post('actualizarUsuario/(:num)', 'ListarUsuarios::actualizarUsuario/$1');
