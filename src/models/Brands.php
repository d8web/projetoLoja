<?php
namespace src\models;
use \core\Model;

class Brands extends Model
{
    public function getList()
    {
        $array = [];

        $sql = "SELECT * FROM brands";
        $sql = $this->pdo->query($sql);

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $array;
    }
}