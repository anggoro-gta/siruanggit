<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

/**
 * ROUTES HALAMAN LANDING PAGE
 */
$routes->get('/', 'Landing::index');

/**
 * ROUTES HALAMAN ADMIN
 */
$routes->get('/home', 'Home::index', ['filter' => 'role:admin,useropd']);
