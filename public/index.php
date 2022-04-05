<?php
session_start();
date_default_timezone_set("America/Sao_Paulo");

require '../vendor/autoload.php';
require '../src/routes.php';

$router->run( $router->routes );

// https://alunos.b7web.com.br/curso/pzp/integracao-pagseguro-configurando-parcelamentos