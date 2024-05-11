<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'ControladoresMarvel::index');

// CRUD Routes
$routes->post('Inicio/busqueda', 'ControladoresMarvel::busqueda');
$routes->post('Inicio/insertar', 'ControladoresMarvel::insertar');
$routes->post('Inicio/eliminar', 'ControladoresMarvel::eliminar');
$routes->post('existe', 'ControladoresMarvel::existe');