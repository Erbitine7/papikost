<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'GuestCtrl::index');

$routes->get('/dashboard', 'StaffCtrl::index');
$routes->get('/staff-login', 'StaffCtrl::login');

// Computer routes
$routes->get('/computer', 'StaffCtrl::computer');
$routes->get('/computer/add', 'StaffCtrl::addcomputer');
$routes->post('/computer/store', 'StaffCtrl::storeComputer');
$routes->get('/computer/edit', 'StaffCtrl::editcomputer');
$routes->post('/computer/update', 'StaffCtrl::updateComputer');
$routes->post('/computer/delete', 'StaffCtrl::deleteComputer');
$routes->get('/computer/detail', 'StaffCtrl::detailcomputer');

// Member routes
$routes->get('/member', 'StaffCtrl::member');
$routes->get('/member/add', 'StaffCtrl::addmember');
$routes->post('/member/store', 'StaffCtrl::storeMember');
$routes->get('/member/edit', 'StaffCtrl::editmember');
$routes->post('/member/update', 'StaffCtrl::updateMember');
$routes->post('/member/delete', 'StaffCtrl::deleteMember');

// Staff (Operator) routes
$routes->get('/staff', 'StaffCtrl::staff');
$routes->get('/staff/add', 'StaffCtrl::addstaff');
$routes->post('/staff/store', 'StaffCtrl::storeStaff');
$routes->get('/staff/edit', 'StaffCtrl::editstaff');
$routes->post('/staff/update', 'StaffCtrl::updateStaff');
$routes->post('/staff/delete', 'StaffCtrl::deleteStaff');


$routes->get('rental', 'StaffCtrl::rental');
$routes->get('rental/add', 'StaffCtrl::addrental');
$routes->post('rental/store', 'StaffCtrl::storeRental');

$routes->get('payment/(:num)', 'StaffCtrl::payment/$1');
$routes->post('payment/complete/(:num)', 'StaffCtrl::completePayment/$1');


$routes->get('/payment', 'StaffCtrl::payment');
