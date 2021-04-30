<?php
namespace src\controllers;

use \core\Controller;
use src\handlers\Store;
use src\models\Categories;
use src\models\Filters;
use \src\models\Products;

class HomeController extends Controller
{
    public function index()
    {
        $store = new Store();        
        $products = new Products();
        $categories = new Categories();
        $new_filters = new Filters();
        $data = $store->getTemplateData();

        $filters = [];
        if(!empty($_GET['filter']) && is_array($_GET['filter'])) {
            $filters = $_GET['filter'];
        }

        $current_page = 1;
        $offset = 0;
        $limit = 12;

        if(isset($_GET['page']) && !empty($_GET['page'])) {
            $current_page = $_GET['page'];
        }

        $offset = ($current_page * $limit) - $limit;

        $data['list'] = $products->getList($offset, $limit, $filters);
        $data['total_items'] = $products->getTotal($filters);
        $data['number_of_pages'] = ceil($data['total_items'] / $limit);
        $data['current_page'] = $current_page;

        $data['filters'] = $new_filters->getFilters($filters);
        $data['filters_selected'] = $filters;

        $data['categories'] = $categories->getList();
        
        $data['search_term'] = '';
        $data['category'] = '';
        
        $data['sidebar'] = true;

        $this->render('home', $data);
    }
}