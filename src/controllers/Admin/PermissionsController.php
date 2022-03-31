<?php

namespace src\controllers\Admin;

use core\Controller;
use src\handlers\Admin\AdminHandler;
use src\handlers\Store;
use src\models\Permissions;

class PermissionsController extends Controller {

    private $loggedAdmin;
    private $permissions;

    public function __construct(){
        $adminHandler = new AdminHandler();
        $this->loggedAdmin = $adminHandler->checkLoginAdmin();
        if(!$this->loggedAdmin) {
            $this->redirect("/admin/signIn");
            exit;
        }

        $p = new Permissions();
        // Definindo o array de permissões do usuário
        $this->permissions = $p->getUserPermissions($this->loggedAdmin->id_permission);

        // Verificar se o usuário tem permissão para ver a lista de permissões
        if(!AdminHandler::hasPermission("permissions_view", $this->permissions)) {
            $this->redirect("/admin");
            exit;
        }
    }

    public function all() {

        $flash = "";
        if(!empty($_SESSION["flash"])) {
            $flash = $_SESSION["flash"];
            unset($_SESSION["flash"]);
        }

        $success = "";
        if(!empty($_SESSION["success"])) {
            $success = $_SESSION["success"];
            unset($_SESSION["success"]);
        }

        $data = [
            "activeMenu" => "permissions",
            "loggedAdmin" => $this->loggedAdmin,
            "permissions" => $this->permissions,
            "list" => [],
            "flash" => $flash,
            "success" => $success
        ];

        $p = new Permissions();
        $data["list"] = $p->getAllGroups();

        $this->render("admin/permissions", $data);
    }

    public function new() {

        $success = "";
        if(!empty($_SESSION["success"])) {
            $success = $_SESSION["success"];
            unset($_SESSION["success"]);
        }

        $data = [
            "activeMenu" => "permissions",
            "loggedAdmin" => $this->loggedAdmin,
            "permissions" => $this->permissions,
            "errorItems" => [],
            "success" => $success
        ];

        if(isset($_SESSION["formError"]) && count($_SESSION["formError"]) > 0) {
            $data["errorItems"] = $_SESSION["formError"];
            unset($_SESSION["formError"]);
        }

        $p = new Permissions();
        $data["permission_items"] = $p->getAllItems();

        $this->render("admin/newPermission", $data);
    }

    public function newSubmit() {
        $p = new Permissions();

        if(!empty($_POST["name"])) {
            $name = filter_input(INPUT_POST, "name");
            $id = $p->addGroup($name);

            if(isset($_POST["items"]) && count($_POST["items"]) > 0) {
                $items = $_POST["items"];
                foreach($items as $item) {
                    $p->linkItemToGroup($item, $id);
                }
            }

            $_SESSION["success"] = "Grupo de permissão inserido com sucesso!";
            $this->redirect("/admin/permissions");
            exit;
        } else {
            $_SESSION["formError"] = ["name" => "O nome do grupo não foi enviado!"];
            $this->redirect("/admin/permissions/new");
            exit;
        }

    }

    public function edit($atts) {

        echo $atts["id"];

    }

    public function delete($atts) {
        $id = $atts["id"];

        if(strlen($id) !== 32) {
            $_SESSION["flash"] = "Ocorreu um erro!";
            $this->redirect("/admin/permissions");
            exit;
        }

        $idGroup = Store::aesDescrypt($id);
        if(empty($idGroup)) {
            $_SESSION["flash"] = "Ocorreu um erro!";
            $this->redirect("/admin/permissions");
            exit;
        }

        $p = new Permissions();
        if($p->deleteGroup($idGroup)) {
            $_SESSION["success"] = "O grupo de permissões $id, foi deletado com sucesso!";
            $this->redirect("/admin/permissions");
            exit;
        }
        
        $_SESSION["flash"] = "Você não pode deletar um grupo de permissões que possuem usuários!";
        $this->redirect("/admin/permissions");
    }

}