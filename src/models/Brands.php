<?php
namespace src\models;
use \core\Model;

class Brands extends Model {
    
    public function getList($showProductCount = false) {
        $array = [];

        if($showProductCount) {
            $sql = "SELECT *, (select count(*) from products where products.id_brand = brands.id) as productCount FROM brands";
        } else {
            $sql = "SELECT * FROM brands";
        }

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

        $sql = "SELECT COUNT(*) as c FROM products WHERE id_brand = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();

        $data = $sql->fetch();
        if($data["c"] == 0) {
            $sql = "DELETE FROM brands WHERE id = :id";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id", $id);
            $sql->execute();
            return true;
        }

        return false;

    }
}