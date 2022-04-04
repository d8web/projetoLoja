<?php

namespace src\controllers\Admin;

use src\Config;
use core\Controller;
use src\handlers\Admin\AdminHandler;
use src\handlers\Store;
use src\models\Admin\Pages;
use src\models\Permissions;

class PagesController extends Controller {

    private $loggedAdmin;
    private $permissions;
    private $data;

    public function __construct() {
        $adminHandler = new AdminHandler();
        $this->loggedAdmin = $adminHandler->checkLoginAdmin();
        if(!$this->loggedAdmin) {
            $this->redirect("/admin/signIn");
            exit;
        }

        $p = new Permissions();
        $this->permissions = $p->getUserPermissions($this->loggedAdmin->id_permission);

        // Verificar se o usuário tem permissão para ver a lista de permissões
        if(!AdminHandler::hasPermission("pages_view", $this->permissions)) {
            $this->redirect("/admin");
            exit;
        }

        $this->data = [
            "activeMenu" => "pages",
            "loggedAdmin" => $this->loggedAdmin,
            "permissions" => $this->permissions
        ];

        if(!empty($_SESSION["flash"])) {
            $this->data["flash"] = $_SESSION["flash"];
            unset($_SESSION["flash"]);
        }

        if(!empty($_SESSION["success"])) {
            $this->data["success"] = $_SESSION["success"];
            unset($_SESSION["success"]);
        }

        $this->data["errorItems"] = [];

        if(isset($_SESSION["formError"]) && count($_SESSION["formError"]) > 0) {
            $this->data["errorItems"] = $_SESSION["formError"];
            unset($_SESSION["formError"]);
        }
    }

    public function index() {
        $pages = new Pages();

        $this->data["list"] = $pages->getAllPages();
        $this->render("admin/pages/index", $this->data);
    }

    public function new() {
        $this->render("admin/pages/new", $this->data);
    }

    public function newSubmit() {
        $title = filter_input(INPUT_POST, "title");
        $body = filter_input(INPUT_POST, "body");

        if(empty($title)) {
            $_SESSION["formError"]["title"] = "O Título não foi enviado!";
            $this->redirect("/admin/pages/new");
            exit;
        }

        if(empty($body)) {
            $_SESSION["formError"]["body"] = "O corpo não foi enviado!";
            $this->redirect("/admin/pages/new");
            exit;
        }

        $pages = new Pages();
        $pages->newPage($title, $body);
        $_SESSION["success"] = "Página inserida com sucesso!";
        $this->redirect("/admin/pages");
    }

    public function edit($atts) {
        $id = $atts["id"];

        if(strlen($id) !== 32) {
            $this->redirect("/admin/pages");
            exit;
        }

        $idPage = Store::aesDescrypt($id);
        if(empty($idPage)) {
            $this->redirect("/admin/pages");
            exit;
        }

        $pages = new Pages();
        $pageExists = $pages->getPageById($idPage);
        if(!$pageExists) {
            $_SESSION["flash"] = "Essa categoria não existe!";
            $this->redirect("/admin/pages");
            exit;
        }

        $this->data["pageId"] = $id;
        $this->data["pageData"] = $pageExists;
        $this->render("admin/pages/edit", $this->data);
    }

    public function editSubmit() {
        $id = filter_input(INPUT_POST, "id");

        if(strlen($id) !== 32) {
            $this->redirect("/admin/pages");
            exit;
        }

        $idPage = Store::aesDescrypt($id);
        if(empty($idPage)) {
            $this->redirect("/admin/pages");
            exit;
        }

        $pages = new Pages();
        $pageExists = $pages->getPageById($idPage);
        if(!$pageExists) {
            $_SESSION["flash"] = "Essa categoria não existe!";
            $this->redirect("/admin/pages");
            exit;
        }

        $title = filter_input(INPUT_POST, "title");
        $body = filter_input(INPUT_POST, "body");

        if(empty($title)) {
            $_SESSION["formError"]["title"] = "O Título não foi enviado!";
            $this->redirect("/admin/pages/edit/".$id);
            exit;
        }

        if(empty($body)) {
            $_SESSION["formError"]["body"] = "O corpo não foi enviado!";
            $this->redirect("/admin/pages/edit/".$id);
            exit;
        }

        $pages = new Pages();
        $pages->editPage($idPage, $title, $body);
        $_SESSION["success"] = "A página $id foi atualizada com sucesso!";
        $this->redirect("/admin/pages");
    }

    public function delete($atts) {
        $id = $atts["id"];

        if(strlen($id) !== 32) {
            $this->redirect("/admin/pages");
            exit;
        }

        $idPage = Store::aesDescrypt($id);
        if(empty($idPage)) {
            $this->redirect("/admin/pages");
            exit;
        }

        $pages = new Pages();
        $pageExists = $pages->getPageById($idPage);
        if(!$pageExists) {
            $_SESSION["flash"] = "Essa categoria não existe!";
            $this->redirect("/admin/pages");
            exit;
        }

        // Deletar página
        $pages->deletePage($idPage);
        $_SESSION["success"] = "Página deletada com sucesso!";
        $this->redirect("/admin/pages");
    }

    public function upload() {
        
        if(!empty($_FILES["file"]["tmp_name"])) {
            if(in_array($_FILES["file"]["type"], ["image/jpeg", "image/jpg", "image/png"])) {
                //echo __DIR__;
                $newName = uniqid().".jpg";
                move_uploaded_file($_FILES["file"]["tmp_name"], __DIR__."/../../../public/media/pages/".$newName);

                $array = [
                    "location" => Config::BASE_URL."/public/media/pages/".$newName,
                ];

                echo json_encode($array);
                exit;
            }
        }

    }

}