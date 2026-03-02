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
$routes->get('/computer/detail', 'StaffCtrl::detailcomputer');

$routes->get('/rental', 'StaffCtrl::rental');
$routes->get('/rental/add', 'StaffCtrl::addrental');

$routes->get('/payment', 'StaffCtrl::payment');

$routes->get('/member', 'StaffCtrl::member');
$routes->get('/member/add', 'StaffCtrl::addmember');
$routes->get('/member/edit', 'StaffCtrl::editmember');

$routes->get('/staff', 'StaffCtrl::staff');
$routes->get('/staff/add', 'StaffCtrl::addstaff');
$routes->get('/staff/edit', 'StaffCtrl::editstaff');
