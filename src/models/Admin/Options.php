<?php
namespace src\models\Admin;
use \core\Model;

class Options extends Model {
    
    public function getList() {
        $array = [];
        
        $sql = "SELECT * FROM options";
        $sql = $this->pdo->query($sql);

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function newOption(string $name) {

        $sql = "INSERT INTO options (name) VALUES (:name)";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":name", $name);
        $sql->execute();

    }

    public function getOptionById($id) {

        $sql = "SELECT name FROM options WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();

        return $sql->rowCount() > 0 ? $sql->fetch(\PDO::FETCH_ASSOC) : false;

    }

    public function updateOptionName($name, $id) {

        $sql = "UPDATE options SET name = :name WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":name", $name);
        $sql->bindValue(":id", $id);
        $sql->execute();

    }

    public function deleteOption($id) {
        $sql = "DELETE FROM options WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();
    }
}