<?php
namespace src\handlers;

use src\Config;
use \src\models\Products;
use \src\models\Categories;
use \src\handlers\CartHandler;

class Store {

    public function getTemplateData() {
        $data = [];

        $products = new Products();
        $categories = new Categories();

        $data['categories'] = $categories->getList();
        $data['widget_featured1'] = $products->getList(0, 3, ['featured' => '1'], true);
        $data['widget_featured2'] = $products->getList(0, 3, ['featured' => '1'], true);
        $data['widget_sale'] = $products->getList(0, 3, ['sale' => '1'], true);
        $data['widget_toprated'] = $products->getList(0, 3, ['toprated' => '1']);

        if(isset($_SESSION['cart'])) {
            $qt = 0;
            foreach($_SESSION['cart'] as $qtd) {
                $qt += intval($qtd);
            }
            $data['cart_qt'] = $qt;
        } else {
            $data['cart_qt'] = 0;
        }

        $data['cart_subtotal'] = CartHandler::getSubtotal();

        return $data;
    }

    /**
     * @param string $value
     * @return string 
    */
    public static function aesEncrypt(string $value) {
        return bin2hex(openssl_encrypt($value, "aes-256-cbc", Config::AES_KEY, OPENSSL_RAW_DATA, Config::AES_IV));
    }

    /**
     * @param string $value
     * @return string
    */
    public static function aesDescrypt(string $value) {
        return openssl_decrypt(hex2bin($value), "aes-256-cbc", Config::AES_KEY, OPENSSL_RAW_DATA, Config::AES_IV);
    }

}