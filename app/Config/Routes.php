<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::mostrarLogin');
$routes->get('/home', 'MostrarVistas::mostrarHome');
$routes->get('/ventas', 'MostrarVistas::mostrarVentas');
$routes->get('/produccion', 'MostrarVistas::mostrarProduccion');
$routes->get('/reportes', 'MostrarVistas::mostrarReportes');
