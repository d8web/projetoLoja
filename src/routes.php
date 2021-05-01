<?php
use core\Router;
$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/language/{lang}', 'LanguageController@set');
$router->get('/categories/{id}', 'CategoriesController@index');
$router->get('/busca', 'SearchController@index');

$router->get('/product/{id}', 'ProductController@index');

$router->get('/cart', 'CartController@cart');
$router->post('/cart', 'CartController@cart');
$router->post('/cart/add', 'CartController@action');
$router->get('/cart/del/{id}', 'CartController@del');

$router->post('/payment_redirect', 'CartController@payment');

$router->get('/clean', 'CartController@clean');

$router->get('/pscktransparent', 'PagseguroController@checkoutTransparent');