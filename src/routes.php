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
$router->get("/admin/permissions/items", "Admin\PermissionsController@items");

$router->get("/admin/permissions/new", "Admin\PermissionsController@new");
$router->get("/admin/permissions/newItem", "Admin\PermissionsController@newItem");

$router->post("/admin/permissions/ItemSubmit", "Admin\PermissionsController@ItemSubmit");
$router->post("/admin/permissions/newSubmit", "Admin\PermissionsController@newSubmit");

$router->get("/admin/permissions/edit/item/{id}", "Admin\PermissionsController@editItem");
$router->post("/admin/permissions/editItemSubmit", "Admin\PermissionsController@editItemSubmit");

$router->get("/admin/permissions/edit/{id}", "Admin\PermissionsController@edit");
$router->post("/admin/permissions/editSubmit", "Admin\PermissionsController@editSubmit");

$router->get("/admin/permissions/del/{id}", "Admin\PermissionsController@delete");
$router->get("/admin/permissions/del/item/{id}", "Admin\PermissionsController@deleteItem");

// Categories
$router->get("/admin/categories", "Admin\CategoriesController@index");

// Brands
$router->get("/admin/brands", "Admin\BrandsController@index");

$router->get("/admin/brands/new", "Admin\BrandsController@new");
$router->post("/admin/brands/newSubmit", "Admin\BrandsController@newSubmit");

$router->get("/admin/brands/edit/{id}", "Admin\BrandsController@edit");
$router->post("/admin/brands/editSubmit", "Admin\BrandsController@editSubmit");

$router->get("/admin/brands/del/{id}", "Admin\BrandsController@delete");