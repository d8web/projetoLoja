<?php

namespace src\controllers\Admin;

use core\Controller;
use src\handlers\Admin\AdminHandler;
use src\handlers\Store;
use src\models\Permissions;

class PermissionsController extends Controller {

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
        // Definindo o array de permissões do usuário
        $this->permissions = $p->getUserPermissions($this->loggedAdmin->id_permission);

        // Verificar se o usuário tem permissão para ver a lista de permissões
        if(!AdminHandler::hasPermission("permissions_view", $this->permissions)) {
            $this->redirect("/admin");
            exit;
        }

        $this->data = [
            "activeMenu" => "permissions",
            "loggedAdmin" => $this->loggedAdmin,
            "permissions" => $this->permissions
        ];
    }

    public function all() {

        if(!empty($_SESSION["flash"])) {
            $this->data["flash"] = $_SESSION["flash"];
            unset($_SESSION["flash"]);
        }

        if(!empty($_SESSION["success"])) {
            $this->data["success"] = $_SESSION["success"];
            unset($_SESSION["success"]);
        }

        $p = new Permissions();
        $this->data["list"] = $p->getAllGroups();

        $this->render("admin/permissions/index", $this->data);
    }

    public function items() {
        if(!empty($_SESSION["flash"])) {
            $this->data["flash"] = $_SESSION["flash"];
            unset($_SESSION["flash"]);
        }

        if(!empty($_SESSION["success"])) {
            $this->data["success"] = $_SESSION["success"];
            unset($_SESSION["success"]);
        }

        $p = new Permissions();
        $this->data["list"] = $p->getAllItems();
        $this->render("admin/permissions/permissionItems", $this->data);
    }

    public function new() {
        if(!empty($_SESSION["success"])) {
            $this->data["success"] = $_SESSION["success"];
            unset($_SESSION["success"]);
        }

        $this->data["errorItems"] = [];

        if(isset($_SESSION["formError"]) && count($_SESSION["formError"]) > 0) {
            $this->data["errorItems"] = $_SESSION["formError"];
            unset($_SESSION["formError"]);
        }

        $p = new Permissions();
        $this->data["permission_items"] = $p->getAllItems();

        $this->render("admin/permissions/newPermission", $this->data);
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

    public function newItem() {
        if(!empty($_SESSION["success"])) {
            $this->data["success"] = $_SESSION["success"];
            unset($_SESSION["success"]);
        }

        $this->data["errorItems"] = [];

        if(isset($_SESSION["formError"]) && count($_SESSION["formError"]) > 0) {
            $this->data["errorItems"] = $_SESSION["formError"];
            unset($_SESSION["formError"]);
        }

        $this->render("admin/permissions/newItem", $this->data);
    }

    public function ItemSubmit() {
        $p = new Permissions();

        if(!empty($_POST["name"])) {
            $name = filter_input(INPUT_POST, "name");
            $p->addItem($name);

            $_SESSION["success"] = "Item de permissão inserido com sucesso!";
            $this->redirect("/admin/permissions/items");
            exit;
        } else {
            $_SESSION["formError"] = ["name" => "O nome do item não foi enviado!"];
            $this->redirect("/admin/permissions/newItem");
            exit;
        }

    }

    public function edit($atts) {
        $id = $atts["id"];

        if(strlen($id) !== 32) {
            $this->redirect("/admin/permissions");
            exit;
        }

        $idGroup = Store::aesDescrypt($id);
        if(empty($idGroup)) {
            $this->redirect("/admin/permissions");
            exit;
        }

        if(!empty($_SESSION["success"])) {
            $this->data["success"] = $_SESSION["success"];
            unset($_SESSION["success"]);
        }

        $p = new Permissions();

        $this->data["errorItems"] = [];
        $this->data["id"] = $id;
        $this->data["permissionGroupName"] = $p->getPermissionGroupName($idGroup);
        $this->data["permissionGroupSlugs"] = $p->getUserPermissions($idGroup);

        if(isset($_SESSION["formError"]) && count($_SESSION["formError"]) > 0) {
            $this->data["errorItems"] = $_SESSION["formError"];
            unset($_SESSION["formError"]);
        }

        $this->data["permission_items"] = $p->getAllItems();
        $this->render("admin/permissions/editPermission", $this->data);
    }

    public function editSubmit() {
        $p = new Permissions();

        $id = filter_input(INPUT_POST, "id");
        if(empty($id)) {
            $this->data["flash"] = "Id não enviado!";
            $this->redirect("/admin/permissions");
            exit;
        }

        if(strlen($id) !== 32) {
            $this->data["flash"] = "Id não tem 32 caracteres!";
            $this->redirect("/admin/permissions");
            exit;
        }

        $idGroup = Store::aesDescrypt($id);
        if(empty($idGroup)) {
            $this->data["flash"] = "Id está vazio!";
            $this->redirect("/admin/permissions");
            exit;
        }
        
        if(!empty($_POST["name"])) {
            $name = filter_input(INPUT_POST, "name");
            $p->editName($name, $idGroup);
            $p->clearLinks($idGroup);

            if(isset($_POST["items"]) && count($_POST["items"]) > 0) {
                $items = $_POST["items"];
                foreach($items as $item) {
                    $p->linkItemToGroup($item, $idGroup);
                }
            }

            $_SESSION["success"] = "O grupo de permissão $id, foi editado com sucesso!";
            $this->redirect("/admin/permissions");
            exit;
        } else {
            $_SESSION["formError"] = ["name" => "O nome do grupo não foi enviado!"];
            $this->redirect("/admin/permissions/edit/".$id);
            exit;
        }
    }

    public function editItem($atts) {
        $id = $atts["id"];

        if(strlen($id) !== 32) {
            $this->redirect("/admin/permissions/items");
            exit;
        }

        $idItem = Store::aesDescrypt($id);
        if(empty($idItem)) {
            $this->redirect("/admin/permissions/items");
            exit;
        }

        if(!empty($_SESSION["success"])) {
            $this->data["success"] = $_SESSION["success"];
            unset($_SESSION["success"]);
        }

        $p = new Permissions();

        $this->data["errorItems"] = [];
        $this->data["id"] = $id;
        $this->data["permissionItemName"] = $p->getPermissionItemName($idItem);

        if(isset($_SESSION["formError"]) && count($_SESSION["formError"]) > 0) {
            $this->data["errorItems"] = $_SESSION["formError"];
            unset($_SESSION["formError"]);
        }

        $this->data["permission_items"] = $p->getAllItems();
        $this->render("admin/permissions/editItem", $this->data);
    }

    public function editItemSubmit() {
        $p = new Permissions();

        $id = filter_input(INPUT_POST, "id");
        if(empty($id)) {
            $_SESSION["flash"] = "Id não enviado!";
            $this->redirect("/admin/permissions/items");
            exit;
        }

        if(strlen($id) !== 32) {
            $_SESSION["flash"] = "Id não tem 32 caracteres!";
            $this->redirect("/admin/permissions/items");
            exit;
        }

        $idItem = Store::aesDescrypt($id);
        if(empty($idItem)) {
            $_SESSION["flash"] = "Id está vazio!";
            $this->redirect("/admin/permissions/items");
            exit;
        }
        
        if(!empty($_POST["name"])) {
            $name = filter_input(INPUT_POST, "name");
            $p->editItem($name, $idItem);

            $_SESSION["success"] = "O grupo de permissão $id, foi editado com sucesso!";
            $this->redirect("/admin/permissions/items");
            exit;
        } else {
            $_SESSION["formError"] = ["name" => "O nome do grupo não foi enviado!"];
            $this->redirect("/admin/permissions/edit/item/".$id);
            exit;
        }

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
            $this->data["flash"] = "Ocorreu um erro!";
            $this->redirect("/admin/permissions");
            exit;
        }

        $p = new Permissions();
        if($p->deleteGroup($idGroup)) {
            $_SESSION["success"] = "O grupo de permissões $id, foi deletado com sucesso!";
            $this->redirect("/admin/permissions");
            exit;
        }
        
        $this->data["flash"] = "Você não pode deletar um grupo de permissões que possuem usuários!";
        $this->redirect("/admin/permissions");
    }

    public function deleteItem($atts) {
        $id = $atts["id"];

        if(strlen($id) !== 32) {
            $this->data["flash"] = "Ocorreu um erro!";
            $this->redirect("/admin/permissions/items");
            exit;
        }

        $idItem = Store::aesDescrypt($id);
        if(empty($idItem)) {
            $this->data["flash"] = "Ocorreu um erro!";
            $this->redirect("/admin/permissions/items");
            exit;
        }

        $p = new Permissions();
        $p->deleteItem($idItem);
        $_SESSION["success"] = "O item $id, foi deletado com sucesso!";
        $this->redirect("/admin/permissions/items");
        exit;
    }
}