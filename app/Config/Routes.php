<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::mostrarLogin');
$routes->get('/home', 'MostrarVistas::mostrarHome');
$routes->get('/reportes', 'MostrarVistas::mostrarReportes');
$routes->get('/generarVenta', 'MostrarVistas::mostrarGenerarVenta');
$routes->get('/generarCompra', 'MostrarVistas::mostrarGenerarCompra');
$routes->get('/reporteVentas', 'MostrarVistas::mostrarReporteVentas');
$routes->get('/reporteCompras', 'MostrarVistas::mostrarReporteCompras');
$routes->get('/crearLote', 'MostrarVistas::mostrarCrearLote');
$routes->get('/crearProducto', 'MostrarVistas::mostrarCrearProducto');
$routes->get('/crearUsuario', 'MostrarVistas::mostrarCrearUsuario');
$routes->get('/crearCosturero', 'MostrarVistas::mostrarCrearCosturero');
$routes->get('/listaTono', 'ListarTonos::returnTonos');
$routes->get('/listaTalla', 'ListarTallas::returnTallas');
$routes->post('/crearProducto', 'CreateProducto::validarProducto');
$routes->get('/listaProducto', 'ListarProducto::returnProductos');
$routes->get('/listaRoles', 'ListarRoles::returnRoles');
$routes->post('/crearUsuario', 'CrearUsuario::CrearUnUsuario');
