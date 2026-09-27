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

//master-user
$routes->get('/master-user', 'UserController::index', ['filter' => 'role:admin', 'as' => 'master.user']);
$routes->match(['get', 'post'], '/master-user/data', 'UserController::getData', ['filter' => 'role:admin', 'as' => 'master.user.data']);
$routes->get('/master-user/create', 'UserController::create', ['filter' => 'role:admin', 'as' => 'master.user.create']);
$routes->post('/master-user/store', 'UserController::store', ['filter' => 'role:admin', 'as' => 'master.user.store']);
$routes->get('/master-user/edit/(:num)', 'UserController::edit/$1', ['filter' => 'role:admin', 'as' => 'master.user.edit']);
$routes->post('/master-user/update', 'UserController::update', ['filter' => 'role:admin', 'as' => 'master.user.update']);
$routes->get('/master-user/delete/(:num)', 'UserController::delete/$1', ['filter' => 'role:admin', 'as' => 'master.user.delete']);