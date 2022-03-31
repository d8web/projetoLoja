<?php
use core\Router;
$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/language/{lang}', 'LanguageController@set');
$router->get('/categories/{id}', 'CategoriesController@index');

$router->get('/product/{id}', 'ProductController@index');

$router->get('/cart', 'CartController@cart');
$router->post('/cart', 'CartController@cart');
$router->post('/cart/add', 'CartController@action');
$router->get('/cart/del/{id}', 'CartController@del');

$router->post('/payment_redirect', 'CartController@payment');

$router->get('/clean', 'CartController@clean');

$router->get('/pscktransparent', 'PagseguroController@checkoutTransparent');
$router->get("/stripe", 'StripeController@stripe');
$router->get("/paypal", 'PaypalController@paypal');

$router->get("/signin", "AuthController@signin");
$router->post("/submitSignin", "AuthController@submitSignin");

// Admin
$router->get("/admin", "Admin\AdminController@index");
$router->get("/admin/signIn", "Admin\AuthController@signInAdmin");
$router->post("/admin/submitSigninAdmin", "Admin\AuthController@submit");
$router->get("/admin/logout", "Admin\AuthController@logout");

$router->get("/admin/permissions", "Admin\PermissionsController@all");

$router->get("/admin/permissions/new", "Admin\PermissionsController@new");
$router->post("/admin/permissions/newSubmit", "Admin\PermissionsController@newSubmit");

$router->get("/admin/permissions/edit/{id}", "Admin\PermissionsController@edit");
$router->post("/admin/permissions/editSubmit", "Admin\PermissionsController@editSubmit");

$router->get("/admin/permissions/del/{id}", "Admin\PermissionsController@delete");