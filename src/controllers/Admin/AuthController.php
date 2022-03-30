<?php

namespace src\controllers\Admin;

use core\Controller;
use src\handlers\Admin\AdminHandler;

class AuthController extends Controller {

    public function signInAdmin() {
        $flash = "";
        if(!empty($_SESSION["flash"])) {
            $flash = $_SESSION["flash"];
            unset($_SESSION["flash"]);
        }

        $data = [
            "flash" => $flash
        ];

        $this->render("admin/signIn", $data);
    }

    public function submit() {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        if($email && $password) {  

            $adminHandler = new AdminHandler();
            $token = $adminHandler->validateLoginAdmin($email, $password);

            if($token) {
                $_SESSION['admin'] = $token;
                $this->redirect('/admin');
                exit;
            } else {
                $_SESSION['flash'] = 'Email e/ou senha inválidos!';
                $this->redirect('/admin/signIn');
                exit;
            }

        } else {
            $_SESSION['flash'] = 'Preencha todos os campos!';
            $this->redirect('/admin/signIn');
            exit;
        }
    }

}