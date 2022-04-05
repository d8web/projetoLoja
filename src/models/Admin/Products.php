<?php

namespace src\models\Admin;

use core\Model;

class Products extends Model {

    public function getAll() {
        $array = [];

        $sql = "SELECT
            (select categories.name from categories where categories.id = products.id_category) as categoryName,
            (select brands.name from brands where brands.id = products.id_brand) as brandName,
            id, name, stock, price, price_from FROM products";
        $sql = $this->pdo->query($sql);

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $array;
    }

}