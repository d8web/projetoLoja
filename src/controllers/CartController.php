<?php
namespace src\controllers;

use \core\Controller;
use src\handlers\CartHandler;
use src\handlers\Store;
use \src\models\Products;

class CartController extends Controller
{
    public function cart()
    {
        $store = new Store();        
        $products = new Products();

        if(!isset($_SESSION['cart']) || (isset($_SESSION['cart']) && count($_SESSION['cart']) == 0)) {
            $this->redirect('/');
            exit;
        }

        $data = $store->getTemplateData();
        $data['list'] = CartHandler::getList();

        $this->render('cart', $data);
    }

    public function action()
    {
        $id = filter_input(INPUT_POST, 'id_product', FILTER_VALIDATE_INT);
        if(!empty($id)) {
            $qt = filter_input(INPUT_POST, 'qt_product', FILTER_VALIDATE_INT);

            if(!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            if(isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id] += $qt;
            } else {
                $_SESSION['cart'][$id] = $qt;
            }
        }
        $this->redirect('/cart');
    }

    public function del($atts)
    {
        if(!empty($atts['id'])) {
            //unset($_SESSION['cart'][$atts['id']]);

            $_SESSION['cart'][$atts['id']]--;
            if($_SESSION['cart'][$atts['id']] <= 0) {
                unset($_SESSION['cart'][$atts['id']]);
            }
        }

        $this->redirect('/cart');
        exit;
    }

}