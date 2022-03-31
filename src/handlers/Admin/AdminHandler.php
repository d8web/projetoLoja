<?php

namespace src\handlers\Admin;

use core\Model;

class AdminHandler extends Model {

    public function checkLoginAdmin() {

        if(!empty($_SESSION["admin"])) {
            $token = $_SESSION["admin"];
            
            $sql = "SELECT * FROM users WHERE token = :token AND admin = 1";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":token", $token);
            $sql->execute();

            if($sql->rowCount() > 0) {
                $loggedUser = $sql->fetch(\PDO::FETCH_OBJ);
                return $loggedUser;
            }

        }

        return false;

    }

    public function validateLoginAdmin($email, $password) {

        $sql = "SELECT * FROM users WHERE email = :email AND admin = 1";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":email", $email);
        $sql->execute();

        $user = $sql->fetch();

        if($user) {
            if(password_verify($password, $user['password'])) {

                $token = md5(time().rand(0,9999));
                
                $sql = "UPDATE users SET token = :token WHERE email = :email";
                $sql = $this->pdo->prepare($sql);
                $sql->bindValue(":token", $token);
                $sql->bindValue(":email", $email);
                $sql->execute();

                return $token;
            }
        }

    }

    public static function hasPermission($permissionSlug, $permissionsArray) {
        return in_array($permissionSlug, $permissionsArray) ? true : false;
    }

}