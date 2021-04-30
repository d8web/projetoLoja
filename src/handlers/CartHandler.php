<?php
namespace src\handlers;

use \src\models\Products;

class CartHandler
{
    public static function getList()
    {
        $products = new Products();
        $array = [];
        $cart = [];

        if(isset($_SESSION['cart'])) {
            $cart = $_SESSION['cart'];
        }

        foreach($cart as $id => $qt)
        {
            $info = $products->getProductToCart($id);
            $array[] = [
                'id' => $id,
                'qt' => $qt,
                'price' => $info['price'],
                'name' => $info['name'],
                'image' => $info['image'],
            ];
        }

        return $array;
    }

    public static function getSubtotal()
    {
        $list = self::getList();
        $subtotal = 0;

        foreach($list as $item) {
            $subtotal += (floatval($item['price']) * intval($item['qt']));
        }

        return $subtotal;
    }

}