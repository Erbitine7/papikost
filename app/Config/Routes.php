<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'GuestCtrl::index');

$routes->get('/dashboard', 'StaffCtrl::index');
$routes->get('/staff-login', 'StaffCtrl::login');
