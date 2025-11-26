<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::mostrarLogin');
$routes->get('/home', 'MostrarVistas::mostrarHome');
$routes->get('/reportes', 'MostrarVistas::mostrarReportes');
$routes->get('/generar-venta', 'MostrarVistas::mostrarGenerarVenta');
$routes->get('/reporte-ventas', 'MostrarVistas::mostrarReporteVentas');
$routes->get('/crear-lote', 'MostrarVistas::mostrarCrearLote');
$routes->get('/crear-producto', 'MostrarVistas::mostrarCrearProducto');
$routes->get('/listaTono', 'ListarTonos::returnTonos');
$routes->get('/listaTalla', 'ListarTallas::returnTallas');
$routes->post('/crearProducto', 'CreateProducto::validarProducto');
$routes->get('/listaProducto', 'ListarProducto::returnProductos');
