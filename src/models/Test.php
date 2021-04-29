<?php
namespace src\models;
use \core\Model;

class Test extends Model
{
    public function getUsers()
    {
        $sql = $this->pdo->query("SELECT * FROM products");
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
}