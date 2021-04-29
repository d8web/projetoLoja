<?php
namespace src\handlers;

use \src\models\Products;
use \src\models\Categories;

class Store
{
    public function getTemplateData()
    {
        $data = [];

        $products = new Products();
        $categories = new Categories();

        $data['categories'] = $categories->getList();
        $data['widget_featured1'] = $products->getList(0, 5, ['featured' => '1'], true);
        $data['widget_featured2'] = $products->getList(0, 3, ['featured' => '1'], true);
        $data['widget_sale'] = $products->getList(0, 3, ['sale' => '1'], true);
        $data['widget_toprated'] = $products->getList(0, 3, ['toprated' => '1']);

        return $data;
    }
}