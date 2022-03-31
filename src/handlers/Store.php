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

    /**
     * @param string $urlString 
    */
    public static function createSlug($string) {
        $string = preg_replace('/[\t\n]/', ' ', $string);
        $string = preg_replace('/\s{2,}/', ' ', $string);
        $list = [
            'Š' => 'S',
            'š' => 's',
            'Đ' => 'Dj',
            'đ' => 'dj',
            'Ž' => 'Z',
            'ž' => 'z',
            'Č' => 'C',
            'č' => 'c',
            'Ć' => 'C',
            'ć' => 'c',
            'À' => 'A',
            'Á' => 'A',
            'Â' => 'A',
            'Ã' => 'A',
            'Ä' => 'A',
            'Å' => 'A',
            'Æ' => 'A',
            'Ç' => 'C',
            'È' => 'E',
            'É' => 'E',
            'Ê' => 'E',
            'Ë' => 'E',
            'Ì' => 'I',
            'Í' => 'I',
            'Î' => 'I',
            'Ï' => 'I',
            'Ñ' => 'N',
            'Ò' => 'O',
            'Ó' => 'O',
            'Ô' => 'O',
            'Õ' => 'O',
            'Ö' => 'O',
            'Ø' => 'O',
            'Ù' => 'U',
            'Ú' => 'U',
            'Û' => 'U',
            'Ü' => 'U',
            'Ý' => 'Y',
            'Þ' => 'B',
            'ß' => 'Ss',
            'à' => 'a',
            'á' => 'a',
            'â' => 'a',
            'ã' => 'a',
            'ä' => 'a',
            'å' => 'a',
            'æ' => 'a',
            'ç' => 'c',
            'è' => 'e',
            'é' => 'e',
            'ê' => 'e',
            'ë' => 'e',
            'ì' => 'i',
            'í' => 'i',
            'î' => 'i',
            'ï' => 'i',
            'ð' => 'o',
            'ñ' => 'n',
            'ò' => 'o',
            'ó' => 'o',
            'ô' => 'o',
            'õ' => 'o',
            'ö' => 'o',
            'ø' => 'o',
            'ù' => 'u',
            'ú' => 'u',
            'û' => 'u',
            'ý' => 'y',
            'ý' => 'y',
            'þ' => 'b',
            'ÿ' => 'y',
            'Ŕ' => 'R',
            'ŕ' => 'r',
            '/' => '-',
            ' ' => '_',
            '.' => '-',
            ',' => '',
            ':' => '',
            '|' => ''
        ];
    
        $string = strtr($string, $list);
        $string = preg_replace('/-{2,}/', '_', $string);
        $string = strtolower($string);
    
        return $string;
    }

}