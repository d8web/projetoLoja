<?php
namespace src;

class Config {
    const BASE_DIR = '/loja/public';
    const BASE_URL = "http://localhost/loja";

    const DB_DRIVER = 'mysql';
    const DB_HOST = 'localhost';
    const DB_DATABASE = 'loja';
    CONST DB_USER = 'root';
    const DB_PASS = '';

    const DEFAULT_LANG = 'en';
    const CEP_ORIGIN = '37245000';

    // AES ENCRIPTAÇÃO
    const AES_KEY = "muf4YDYMw3KeNv7rFkLFRJhkRwapBDVF";
    const AES_IV = "NjWA3sg3vyk6yVk2";

    const STRIPE_KEY = "";

    const ERROR_CONTROLLER = 'ErrorController';
    const DEFAULT_ACTION = 'index';
}