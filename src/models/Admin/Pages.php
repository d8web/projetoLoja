<?php

namespace src\models\Admin;

use core\Model;

class Pages extends Model {

    public function getAllPages() {
        $array = [];

        $sql = "SELECT id, title FROM pages";
        $sql = $this->pdo->query($sql);

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function newPage($title, $body) {
        $sql = "INSERT INTO pages (title, body) VALUES (:title, :body)";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":title", $title);
        $sql->bindValue(":body", $body);
        $sql->execute();
    }

    public function getPageById($idPage) {
        $sql = "SELECT * FROM pages WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $idPage);
        $sql->execute();

        return $sql->rowCount() > 0 ? $sql->fetch(\PDO::FETCH_ASSOC) : false;
    }

    public function editPage($id, $title, $body) {
        $sql = "UPDATE pages SET title = :title, body = :body WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":title", $title);
        $sql->bindValue(":body", $body);
        $sql->bindValue(":id", $id);
        $sql->execute();
    }

    public function deletePage($id) {
        $sql = "DELETE FROM pages WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();
    }

}