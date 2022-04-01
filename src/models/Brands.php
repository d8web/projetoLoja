<?php
namespace src\models;
use \core\Model;

class Brands extends Model {
    
    public function getList() {
        $array = [];

        $sql = "SELECT * FROM brands";
        $sql = $this->pdo->query($sql);

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function newBrand(string $name) {

        $sql = "INSERT INTO brands (name) VALUES (:name)";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":name", $name);
        $sql->execute();

    }

    public function getBrandById($id) {

        $sql = "SELECT name FROM brands WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();

        return $sql->rowCount() > 0 ? $sql->fetch(\PDO::FETCH_ASSOC) : false;

    }

    public function updateBrandName($name, $id) {

        $sql = "UPDATE brands SET name = :name WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":name", $name);
        $sql->bindValue(":id", $id);
        $sql->execute();

    }

    public function deleteBrand($id) {

        $sql = "DELETE FROM brands WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();

    }
}