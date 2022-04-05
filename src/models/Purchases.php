<?php

namespace src\models;

use core\Model;

class Purchases extends Model {

    public function createPurchase($idUser, $total, $type) {
        $sql = "INSERT INTO purchases (id_user, total_amount, payment_type, payment_status) VALUES (:id_user, :total_amount, :payment_type, 1)";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_user", $idUser);
        $sql->bindValue(":total_amount", $total);
        $sql->bindValue(":payment_type", $type);
        $sql->execute();

        return $this->pdo->lastInsertId();
    }

    public function addItem($idPurchase, $idProduct, $quantity, $price) {
        $sql = "INSERT INTO purchases_products (id_purchase, id_product, quantity, product_price) VALUES (:id_purchase, :id_product, :quantity, :product_price)";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_purchase", $idPurchase);
        $sql->bindValue(":id_product", $idProduct);
        $sql->bindValue(":quantity", $quantity);
        $sql->bindValue(":product_price", $price);
        $sql->execute();
    }

    public function setPaid($id) {
        $sql = "UPDATE purchases SET payment_status = :status WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":status", '2');
        $sql->bindValue(":id", $id);
        $sql->execute();
    }

    public function setCancelled($id) {
        $sql = "UPDATE purchases SET payment_status = :status WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":status", '3');
        $sql->bindValue(":id", $id);
        $sql->execute();
    }

}