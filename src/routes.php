<?php
use core\Router;
$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/language/{lang}', 'LanguageController@set');
$router->get('/categories/{id}', 'CategoriesController@index');
$router->get('/busca', 'SearchController@index');

$router->get('/product/{id}', 'ProductController@index');

// Continue to: Carrinho de compras (1/3)