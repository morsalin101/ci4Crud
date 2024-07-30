<?php

use App\Controllers\StudentAdd;
use CodeIgniter\Router\RouteCollection;
use App\Controllers\UsersController;
/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'UsersController::index');

$routes->get('/students', 'Home::index');
$routes->get('/get-students', 'Home::ajax');


$routes->match(['POST','PUT','DELETE'],'ajax/(:any)', 'StudentController::ajax/$1');
// $routes->post('/add','StudentController::save');

$routes->match(['GET','POST'],'login', 'UsersController::do_login');
$routes->get('logout', 'UsersController::logout');
$routes->match(['GET','POST'],'signup', 'UsersController::do_register');