<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'GuestCtrl::index');

$routes->get('/dashboard', 'StaffCtrl::index');
$routes->get('/staff-login', 'StaffCtrl::login');

$routes->get('/computer', 'StaffCtrl::computer');
$routes->get('/computer/add', 'StaffCtrl::addcomputer');
$routes->get('/computer/edit', 'StaffCtrl::editcomputer');

$routes->get('/rental', 'StaffCtrl::rental');
$routes->get('/rental/add', 'StaffCtrl::addrental');
