<?php

namespace src\controllers\Admin;

use core\Controller;
use src\handlers\Admin\AdminHandler;
use src\handlers\Store;
use src\models\Admin\Options;
use src\models\Permissions;

class OptionsController extends Controller {

    private $loggedAdmin;
    private $permissions;
    private $data;

    public function __construct(){
        $adminHandler = new AdminHandler();
        $this->loggedAdmin = $adminHandler->checkLoginAdmin();
        if(!$this->loggedAdmin) {
            $this->redirect("/admin/signIn");
            exit;
        }

        $p = new Permissions();
        $this->permissions = $p->getUserPermissions($this->loggedAdmin->id_permission);

        // Verificar se o usuário tem permissão para ver a lista de permissões
        if(!AdminHandler::hasPermission("products_view", $this->permissions)) {
            $this->redirect("/admin");
            exit;
        }

        $this->data = [
            "activeMenu" => "products",
            "loggedAdmin" => $this->loggedAdmin,
            "permissions" => $this->permissions
        ];
    }

    public function index() {
        if(!empty($_SESSION["flash"])) {
            $this->data["flash"] = $_SESSION["flash"];
            unset($_SESSION["flash"]);
        }

        if(!empty($_SESSION["success"])) {
            $this->data["success"] = $_SESSION["success"];
            unset($_SESSION["success"]);
        }

        $options = new Options();
        $this->data["list"] = $options->getList();
        
        $this->render("admin/options/index", $this->data);
    }

    public function new() {
        $this->data["errorItems"] = [];

        if(isset($_SESSION["formError"]) && count($_SESSION["formError"]) > 0) {
            $this->data["errorItems"] = $_SESSION["formError"];
            unset($_SESSION["formError"]);
        }

        $this->render("admin/options/new", $this->data);
    }

    public function newSubmit() {
        $name = filter_input(INPUT_POST, "name");
        if(empty($name)) {
            $_SESSION["formError"] = ["name" => "O nome da opção não foi enviado!"];
            $this->redirect("/admin/options/new");
            exit;
        }

        $options = new Options();
        $options->newOption($name);

        $_SESSION["success"] = "Opção inserida com sucesso!";
        $this->redirect("/admin/options");
        exit;
    }

    public function edit($atts) {
        $id = $atts["id"];

        if(strlen($id) !== 32) {
            $this->redirect("/admin/options");
            exit;
        }

        $idOption = Store::aesDescrypt($id);
        if(empty($idOption)) {
            $this->redirect("/admin/options");
            exit;
        }

        if(!empty($_SESSION["success"])) {
            $this->data["success"] = $_SESSION["success"];
            unset($_SESSION["success"]);
        }

        $options = new Options();
        $this->data["optionData"] = $options->getOptionById($idOption);
        if(!$this->data["optionData"]) {
            $_SESSION["flash"] = "Nada foi encontrado!";
            $this->redirect("/admin/options");
            exit;
        }

        $this->data["errorItems"] = [];
        if(isset($_SESSION["formError"]) && count($_SESSION["formError"]) > 0) {
            $this->data["errorItems"] = $_SESSION["formError"];
            unset($_SESSION["formError"]);
        }

        $this->data["id"] = $id;
        $this->render("admin/options/edit", $this->data);
    }

    public function editSubmit() {
        $id = filter_input(INPUT_POST, "id");

        if(strlen($id) !== 32) {
            $this->data["flash"] = "Ocorreu um erro!";
            $this->redirect("/admin/options");
            exit;
        }

        $idOption = Store::aesDescrypt($id);
        if(empty($idOption)) {
            $_SESSION["flash"] = "Ocorreu um erro!";
            $this->redirect("/admin/options");
            exit;
        }

        $options = new Options();
        $optionData = $options->getOptionById($idOption);
        if(!$optionData) {
            $_SESSION["flash"] = "Nada para deletar!";
            $this->redirect("/admin/options");
            exit;
        }

        $name = filter_input(INPUT_POST, "name");
        if(empty($name)) {
            $_SESSION["formError"] = ["name" => "O nome da opção não foi enviado!"];
            $this->redirect("/admin/options/edit/".$id);
            exit;
        }

        $options->updateOptionName($name, $idOption);
        $_SESSION["success"] = "Opção atualizada com sucesso!";
        $this->redirect("/admin/options");
    }

    public function delete($atts) {
        $id = $atts["id"];

        if(strlen($id) !== 32) {
            $_SESSION["flash"] = "Ocorreu um erro!";
            $this->redirect("/admin/options");
            exit;
        }

        $idOption = Store::aesDescrypt($id);
        if(empty($idOption)) {
            $_SESSION["flash"] = "Ocorreu um erro!";
            $this->redirect("/admin/options");
            exit;
        }

        $options = new Options();
        $brandData = $options->getOptionById($idOption);
        if(!$brandData) {
            $_SESSION["flash"] = "Nada para deletar!";
            $this->redirect("/admin/options");
            exit;
        }

        $options->deleteOption($idOption);
        $_SESSION["success"] = "Opção deletada com sucesso!";
        $this->redirect("/admin/options");
    }


}