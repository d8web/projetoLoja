<?php
namespace src\controllers\Admin;

use core\Controller;
use src\models\Permissions;
use src\handlers\Admin\AdminHandler;

class AdminController extends Controller {

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
            "activeMenu" => "dashboard",
            "loggedAdmin" => $this->loggedAdmin,
            "permissions" => $this->permissions
        ];
    }

    public function index() {
        $this->render("admin/dashboard", $this->data);
    }

}