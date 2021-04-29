<?php
namespace core;
use \src\Config;

class Model
{
    public $pdo;
    
    public function __construct()
    {
        if(!isset($this->pdo) && empty($this->pdo)) {
            $this->pdo = new \PDO(Config::DB_DRIVER.":dbname=".Config::DB_DATABASE.";host=".Config::DB_HOST, Config::DB_USER, Config::DB_PASS);
        }
        return $this->pdo;
    }
}