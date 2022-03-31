<?php
namespace src\controllers\Admin;

use core\Controller;
use src\models\Permissions;
use src\handlers\Admin\AdminHandler;

class AdminController extends Controller {

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
        $this->permissions = $p->getUserPermissions($this->loggedAdmin->id_permission);
    }

    public function index() {
        $data = [
            "activeMenu" => "dashboard",
            "loggedAdmin" => $this->loggedAdmin,
            "permissions" => $this->permissions
        ];

        $this->render("admin/dashboard", $data);
    }

}