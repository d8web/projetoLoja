<?php

namespace src\handlers;

use core\Model;

class LoginHandler extends Model {

    public function checkLogin() {

        if(!empty($_SESSION["token"])) {
            $token = $_SESSION["token"];
            
            $sql = "SELECT * FROM users WHERE token = :token";
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

    public function validateLogin($email, $password) {

        $sql = "SELECT * FROM users WHERE email = :email";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":email", $email);
        $sql->execute();

        $user = $sql->fetch(\PDO::FETCH_ASSOC);

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

}