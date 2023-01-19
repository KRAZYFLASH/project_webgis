<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/dashboard', 'admin\Dashboard::index');
$routes->get('/siuu', 'Home::index2');

$routes->get('/dataKebun', 'admin\DataKebun::index');
$routes->get('/createDataKebun', 'admin\DataKebun::create');
$routes->post('/storeDataKebun', 'admin\DataKebun::store');
$routes->delete('/deleteKebun/(:num)', 'admin\DataKebun::delete/$1');

$routes->get('/dataCabang', 'admin\DataCabang::index');
$routes->get('/createDataCabang', 'admin\DataCabang::create');
$routes->post('/storeDataCabang', 'admin\DataCabang::store');
$routes->delete('/deleteCabang/(:num)', 'admin\DataCabang::delete/$1');
$routes->get('/ambilDataKebun/(:num)', 'admin\DataKebun::ambilDataKebun/$1');

$routes->get('/tampilDataCabang/(:num)', 'admin\Maps::tampilDataCabang/$1');
$routes->get('/maps', 'admin\Maps::index');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
