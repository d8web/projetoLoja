<?php
namespace src\models;

use \core\Model;

class Productsimages extends Model
{
    public function getImagesByProductId($id)
    {
        $array = [];

        $sql = "SELECT url FROM products_images WHERE id_product = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }


        return $array;
    }
}