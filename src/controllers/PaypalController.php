<?php

namespace src\controllers;
use core\Controller;

use src\handlers\CartHandler;
use src\handlers\LoginHandler;
use src\handlers\Store;

class PaypalController extends Controller {

    private $loggedUser;

    public function __construct() {

        if(!isset($_SESSION["paypal"])) {
            $_SESSION["paypal"] = "paypal";
        }

        $loginHandler = new LoginHandler();
        $this->loggedUser = $loginHandler->checkLogin();
        if(!$this->loggedUser) {
            $this->redirect("/signin");
            exit;
        }

    }

    public function paypal() {

        $store = new Store();
        $data = $store->getTemplateData();
        $list = CartHandler::getList();

        $total = 0;
        foreach($list as $item) {
            $total += (floatval($item["price"]) * intval($item["qt"]));
        }

        $shipping = null;
        if(!empty($_SESSION["shipping"])) {
            $shipping = $_SESSION["shipping"];

            if(isset($shipping["price"])) {
                $frete = floatval(str_replace(",", ".", $shipping["price"]));
            } else {
                $frete = 0;
            }

            $total += $frete;
        }

        $this->render("paypal", $data);

    }
}
