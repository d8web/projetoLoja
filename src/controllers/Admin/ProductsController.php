<?php
namespace src\controllers\Admin;

use core\Controller;
use src\models\Permissions;
use src\handlers\Admin\AdminHandler;
use src\models\Admin\Products;

class ProductsController extends Controller {

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

        $this->data = [
            "activeMenu" => "products",
            "loggedAdmin" => $this->loggedAdmin,
            "permissions" => $this->permissions
        ];
    }

    public function index() {
        $products = new Products();
        $this->data["list"] = $products->getAll();
        
        $this->render("admin/products/index", $this->data);
    }

    public function new() {

    }

}