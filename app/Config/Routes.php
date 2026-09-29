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

// master-user
$routes->get('/master-user', 'UserController::index', ['filter' => 'role:admin']);
$routes->match(['get', 'post'], '/master-user/data', 'UserController::getData', ['filter' => 'role:admin']);
$routes->get('/master-user/create', 'UserController::create', ['filter' => 'role:admin']);
$routes->post('/master-user/store', 'UserController::store', ['filter' => 'role:admin']);
$routes->get('/master-user/edit/(:num)', 'UserController::edit/$1', ['filter' => 'role:admin']);
$routes->post('/master-user/update', 'UserController::update', ['filter' => 'role:admin']);
$routes->get('/master-user/delete/(:num)', 'UserController::delete/$1', ['filter' => 'role:admin']);

// master-slider
$routes->get('/master-slider', 'SliderController::index', ['filter' => 'role:admin']);
$routes->match(['get', 'post'], '/master-slider/data', 'SliderController::getData', ['filter' => 'role:admin']);
$routes->get('/master-slider/create', 'SliderController::create', ['filter' => 'role:admin']);
$routes->post('/master-slider/store', 'SliderController::store', ['filter' => 'role:admin']);
$routes->get('/master-slider/edit/(:num)', 'SliderController::edit/$1', ['filter' => 'role:admin']);
$routes->post('/master-slider/update', 'SliderController::update', ['filter' => 'role:admin']);
$routes->get('/master-slider/delete/(:num)', 'SliderController::delete/$1', ['filter' => 'role:admin']);