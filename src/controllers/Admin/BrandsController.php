<?php
namespace src\controllers\Admin;

use core\Controller;
use src\models\Permissions;
use src\handlers\Admin\AdminHandler;
use src\handlers\Store;
use src\models\Admin\Categories;
use src\models\Brands;

class BrandsController extends Controller {

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
        if(!AdminHandler::hasPermission("brands_view", $this->permissions)) {
            $this->redirect("/admin");
            exit;
        }

        $this->data = [
            "activeMenu" => "brands",
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

        $brands = new Brands();

        $this->data["list"] = $brands->getList(true);
        $this->render("admin/brands/index", $this->data);
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

        $this->render("admin/brands/new", $this->data);
    }

    public function newSubmit() {
        $name = filter_input(INPUT_POST, "name");
        if(empty($name)) {
            $_SESSION["formError"] = ["name" => "O nome da marca não foi enviado!"];
            $this->redirect("/admin/brands/new");
            exit;
        }

        $brands = new Brands();
        $brands->newBrand($name);

        $_SESSION["success"] = "Marca inserida com sucesso!";
        $this->redirect("/admin/brands");
        exit;
    }

    public function edit($atts) {
        $id = $atts["id"];

        if(strlen($id) !== 32) {
            $this->redirect("/admin/brands");
            exit;
        }

        $idBrand = Store::aesDescrypt($id);
        if(empty($idBrand)) {
            $this->redirect("/admin/brands");
            exit;
        }

        if(!empty($_SESSION["success"])) {
            $this->data["success"] = $_SESSION["success"];
            unset($_SESSION["success"]);
        }

        $brands = new Brands();
        $this->data["brandData"] = $brands->getBrandById($idBrand);
        if(!$this->data["brandData"]) {
            $_SESSION["flash"] = "Nada foi encontrado!";
            $this->redirect("/admin/brands");
            exit;
        }

        $this->data["errorItems"] = [];
        if(isset($_SESSION["formError"]) && count($_SESSION["formError"]) > 0) {
            $this->data["errorItems"] = $_SESSION["formError"];
            unset($_SESSION["formError"]);
        }

        $this->data["id"] = $id;
        $this->render("admin/brands/edit", $this->data);
    }

    public function editSubmit() {
        $id = filter_input(INPUT_POST, "id");

        if(strlen($id) !== 32) {
            $this->data["flash"] = "Ocorreu um erro!";
            $this->redirect("/admin/brands");
            exit;
        }

        $idBrand = Store::aesDescrypt($id);
        if(empty($idBrand)) {
            $this->data["flash"] = "Ocorreu um erro!";
            $this->redirect("/admin/brands");
            exit;
        }

        $brands = new Brands();
        $brandData = $brands->getBrandById($idBrand);
        if(!$brandData) {
            $_SESSION["flash"] = "Nada para deletar!";
            $this->redirect("/admin/brands");
            exit;
        }

        $name = filter_input(INPUT_POST, "name");
        if(empty($name)) {
            $_SESSION["formError"] = ["name" => "O nome da marca não foi enviado!"];
            $this->redirect("/admin/brands/new");
            exit;
        }

        $brands = new Brands();
        $brands->updateBrandName($name, $idBrand);
        $_SESSION["success"] = "Marca atualizada com sucesso!";
        $this->redirect("/admin/brands");
    }

    public function delete($atts) {
        $id = $atts["id"];

        if(strlen($id) !== 32) {
            $this->data["flash"] = "Ocorreu um erro!";
            $this->redirect("/admin/brands");
            exit;
        }

        $idBrand = Store::aesDescrypt($id);
        if(empty($idBrand)) {
            $this->data["flash"] = "Ocorreu um erro!";
            $this->redirect("/admin/brands");
            exit;
        }

        $brands = new Brands();
        $brandData = $brands->getBrandById($idBrand);
        if(!$brandData) {
            $_SESSION["flash"] = "Nada para deletar!";
            $this->redirect("/admin/brands");
            exit;
        }

        // Verificar se a marca tem produtos atrelados a ela dentro do método do model BRAND [deleteBrand]
        // Caso não tenha nenhum produto, deleta, caso tenha, não deleta
        $brandDelete = $brands->deleteBrand($idBrand);

        if(!$brandDelete) {
            $_SESSION["flash"] = "Você não pode deletar uma marca que possui produtos cadastrados.";
            $this->redirect("/admin/brands");
            exit;
        }

        $_SESSION["success"] = "Marca deletada com sucesso!";
        $this->redirect("/admin/brands");
    }

}