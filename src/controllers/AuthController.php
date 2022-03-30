<?php

namespace src\controllers;

use core\Controller;
use src\handlers\LoginHandler;

class AuthController extends Controller {

    public function signin() {

        $flash = "";
        if(!empty($_SESSION["flash"])) {
            $flash = $_SESSION["flash"];
            unset($_SESSION["flash"]);
        }

        $data = [
            "flash" => $flash
        ];

        $this->render('signin', $data);
    }

    public function submitSignin() {

        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        if($email && $password) {  

            $loginHandler = new LoginHandler();
            $token = $loginHandler->validateLogin($email, $password);

            if($token) {
                $_SESSION['token'] = $token;

                if(isset($_SESSION["paypal"]) && $_SESSION["paypal"] === 'paypal') {
                    unset($_SESSION["paypal"]);
                    $this->redirect("/paypal");
                    exit;
                }

                $this->redirect('/');
                exit;
            } else {
                $_SESSION['flash'] = 'Email e/ou senha inválidos!';
                $this->redirect('/signin');
                exit;
            }

        } else {
            $_SESSION['flash'] = 'Preencha todos os campos!';
            $this->redirect('/signin');
            exit;
        }

    }

}