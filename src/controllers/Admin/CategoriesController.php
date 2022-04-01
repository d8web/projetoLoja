<?php
namespace src\controllers\Admin;

use core\Controller;
use src\models\Permissions;
use src\handlers\Admin\AdminHandler;
use src\models\Admin\Categories;

class CategoriesController extends Controller {

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

        $this->data = [
            "activeMenu" => "categories",
            "loggedAdmin" => $this->loggedAdmin,
            "permissions" => $this->permissions
        ];
    }

    public function index() {
        $categories = new Categories();

        $this->data["list"] = $categories->getAll();
        $this->render("admin/categories/index", $this->data);
    }

}