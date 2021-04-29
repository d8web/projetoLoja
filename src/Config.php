<?php
namespace src;

class Config {
    const BASE_DIR = '/loja/public';

    const DB_DRIVER = 'mysql';
    const DB_HOST = 'localhost';
    const DB_DATABASE = 'loja';
    CONST DB_USER = 'root';
    const DB_PASS = '';

    const DEFAULT_LANG = 'en';

    const ERROR_CONTROLLER = 'ErrorController';
    const DEFAULT_ACTION = 'index';
}