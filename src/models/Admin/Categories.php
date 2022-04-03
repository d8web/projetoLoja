<?php

namespace src\models\Admin;
use core\Model;

class Categories extends Model {

    public function getAll() {
        $array = [];

        $sql = "SELECT * FROM categories ORDER BY sub DESC";
        $sql = $this->pdo->query($sql);

        if($sql->rowCount() > 0) {
            $data = $sql->fetchAll(\PDO::FETCH_ASSOC);

            foreach($data as $item) {
                $item["subs"] = [];
                $array[$item["id"]] = $item;
            }

            while($this->stillNeed($array)) {
                $this->organizeCategory($array);
            }
        }

        return $array;
    }

    private function organizeCategory(&$array) {
        foreach($array as $id => $item) {
            if(!empty($item["sub"])) {
                $array[$item["sub"]]["subs"][$item["id"]] = $item;
                unset($array[$id]);
                break;
            }
        }
    }

    private function stillNeed($array) {
        foreach($array as $item) {
            if(!empty($item["sub"])) {
                return true;
            }
        }

        return false;
    }

    public function addNewCategory($name, $sub) {
        $sql = "INSERT INTO categories (name, sub) VALUES (:name, :sub)";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":name", $name);
        $sql->bindValue(":sub", $sub);
        $sql->execute();
    }

    public function getCategoryById($id) {
        $sql = "SELECT * FROM categories WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();

        return $sql->rowCount() > 0 ? $sql->fetch(\PDO::FETCH_ASSOC) : false;
    }

    public function update($idCategory, $name, $sub) {
        $sql = "UPDATE categories SET name = :name, sub = :sub WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":name", $name);
        $sql->bindValue(":sub", $sub);
        $sql->bindValue(":id", $idCategory);
        $sql->execute();
    }

    public function scanCategories($idCategory, $cats = []) {
        if(!in_array($idCategory, $cats)) {
            $cats[] = $idCategory;
        }

        $sql = "SELECT id FROM categories WHERE sub = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $idCategory);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $data = $sql->fetchAll();

            foreach($data as $item) {
                if(!in_array($item["id"], $cats)) {
                    $cats[] = $item["id"];
                }

                $cats = $this->scanCategories($item["id"], $cats);
            }
        }

        return $cats;
    }

    public function hasProducts($array) {
        $sql = "SELECT COUNT(*) as c FROM products WHERE id_category IN (".implode(',', $array).")";
        $sql = $this->pdo->query($sql);
        $data = $sql->fetch();

        return intval($data["c"]) > 0 ? true : false;
    }

    public function deleteCategories($array) {
        $sql = "DELETE FROM categories WHERE id IN (".implode(',', $array).")";
        $sql = $this->pdo->query($sql);
    }
}