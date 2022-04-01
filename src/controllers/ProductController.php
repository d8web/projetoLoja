<?php
namespace src\controllers;

use \core\Controller;
use src\handlers\Store;
use src\models\Filters;
use \src\models\Products;
use src\models\Productsimages;

class ProductController extends Controller {

    public function index($atts) {
        $store = new Store();
        $products = new Products();
        $products_images = new Productsimages();
        $data = $store->getTemplateData();

        $info = $products->getProductInfo($atts['id']);
        if(count($info) > 0) {
            $data['info'] = $info;
            $data['images'] = $products_images->getImagesByProductId($atts['id']);
            $data['product_options'] = $products->getOptionsByProductId($atts['id']);
            $data['products_rates'] = $products->getRates($atts['id'], 5);
    
            $this->render('product', $data);
        } else {
            $this->redirect('/');
            exit;
        }

    }
}