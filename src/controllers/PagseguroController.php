<?php
namespace src\controllers;
use \core\Controller;
use src\Config;
use Error;

use src\handlers\Store;
use \src\models\Products;

class PagseguroController extends Controller {

    public function checkoutTransparent() {
        $store = new Store();
        $products = new Products();
        $data = $store->getTemplateData();

        $this->render('cart_psckttransparent', $data);
    }
    
}