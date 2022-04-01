<?php
namespace src\controllers\Admin;

use core\Controller;
use src\models\Permissions;
use src\handlers\Admin\AdminHandler;
use src\handlers\Store;
use src\models\Admin\Categories;

class CategoriesController extends Controller {

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

        $this->data = [
            "activeMenu" => "categories",
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
        $categories = new Categories();

        $this->data["list"] = $categories->getAll();
        $this->render("admin/categories/index", $this->data);
    }

    public function new() {
        $categories = new Categories();
        $this->data["list"] = $categories->getAll();

        $this->render("admin/categories/new", $this->data);
    }

    public function newSubmit() {
        $name = filter_input(INPUT_POST, "name");
        if(empty($name)) {
            $_SESSION["formError"] = ["name" => "O nome da categoria não foi enviado!"];
            $this->redirect("/admin/categories/new");
            exit;
        }

        $sub = null;
        if(!empty($_POST["sub"])) {
            $sub = filter_input(INPUT_POST, "sub");
        }

        $category = new Categories();
        $category->addNewCategory($name, $sub);

        $_SESSION["success"] = "Categoria adicionada com sucesso!";
        $this->redirect("/admin/categories");
    }

    public function edit($atts) {
        $id = $atts["id"];

        if(strlen($id) !== 32) {
            $this->redirect("/admin/categories");
            exit;
        }

        $idCategory = Store::aesDescrypt($id);
        if(empty($idCategory)) {
            $this->redirect("/admin/categories");
            exit;
        }

        $categories = new Categories();
        $categoryExists = $categories->getCategoryById($idCategory);
        if(!$categoryExists) {
            $_SESSION["flash"] = "Essa categoria não existe!";
            $this->redirect("/admin/categories");
        }

        $this->data["categoryData"] = $categoryExists;
        $this->data["list"] = $categories->getAll();
        $this->data["errorItems"] = [];
        $this->data["id"] = $id;

        $this->render("admin/categories/edit", $this->data);
    }

    public function editAction() {
        $id = filter_input(INPUT_POST, "id");
        if(empty($id)) {
            $_SESSION["flash"] = "Id não enviado!";
            $this->redirect("/admin/categories");
            exit;
        }

        if(strlen($id) !== 32) {
            $_SESSION["flash"] = "Id não tem 32 caracteres!";
            $this->redirect("/admin/categories");
            exit;
        }

        $idCategory = Store::aesDescrypt($id);
        if(empty($idCategory)) {
            $_SESSION["flash"] = "Id está vazio!";
            $this->redirect("/admin/categories");
            exit;
        }

        $categories = new Categories();
        $categoryExists = $categories->getCategoryById($idCategory);
        if(!$categoryExists) {
            $_SESSION["flash"] = "Essa categoria não existe!";
            $this->redirect("/admin/categories");
        }

        $name = filter_input(INPUT_POST, "name");
        if(empty($name)) {
            $this->redirect("/admin/category/edit/".$id);
            exit;
        }

        $sub = "";
        if(!empty($_POST["sub"])) {
            $sub = filter_input(INPUT_POST, "sub");
        }

        // print_r($sub);exit;

        // Atualizar
        $categories->update($idCategory, $name, $sub);
        $_SESSION["success"] = "Categoria atualizada com sucesso!";
        $this->redirect("/admin/categories");
    }

    public function delete($atts) {
        $id = $atts["id"];

        if(strlen($id) !== 32) {
            $this->redirect("/admin/categories");
            exit;
        }

        $idCategory = Store::aesDescrypt($id);
        if(empty($idCategory)) {
            $this->redirect("/admin/categories");
            exit;
        }

        $categories = new Categories();
        $categoryExists = $categories->getCategoryById($idCategory);
        if(!$categoryExists) {
            $_SESSION["flash"] = "Essa categoria não existe!";
            $this->redirect("/admin/categories");
        }

        // Deletar
        $categories->delete($idCategory);
        $_SESSION["success"] = "Categoria deletada com sucesso!";
        $this->redirect("/admin/categories");
    }
}