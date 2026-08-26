<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index', ['filter' => 'role:admin,useropd']);
$routes->get('/landingsiruang', 'Landing::index');