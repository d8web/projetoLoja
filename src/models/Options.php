<?php
namespace src\models;

use \core\Model;

class Options extends Model
{
    public function getName($id)
    {
        $sql = "SELECT name FROM options WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $sql = $sql->fetch(\PDO::FETCH_ASSOC);
            return $sql['name'];
        }
    }
}