<?php

namespace src\models;

use core\Model;

class User extends Model {

    public function emailExists($email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":email", $email);
        $sql->execute();

        return $sql->rowCount() > 0 ? true : false;
    }

    public function validateUser($email, $password) {
        $id = "";

        $sql = "SELECT * FROM users WHERE email = :email";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":email", $email);
        $sql->execute();

        $user = $sql->fetch(\PDO::FETCH_ASSOC);

        if($user) {
            if(password_verify($password, $user['password'])) {
                $id = $user["id"];
            }
        }

        return $id;
    }

    public function createUser($name, $email, $password) {

        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":name", $name);
        $sql->bindValue(":email", $email);
        $sql->bindValue(":password", password_hash($password, PASSWORD_DEFAULT));
        $sql->execute();

        return $this->pdo->lastInsertId();
    }

}