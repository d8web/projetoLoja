<?php
namespace src\models;
use \core\Model;

use \src\models\Brands;

class Filters extends Model
{
    public function getFilters($filters = [])
    {
        $brands = new Brands();
        $products = new Products();

        $array = [
            'search_term' => '',
            'brands' => [],
            'slider1' => 0,
            'slider0' => 0,
            'maxslider' => 1400,
            'stars' => [
				'0' => 0,
				'1' => 0,
				'2' => 0,
				'3' => 0,
				'4' => 0,
				'5' => 0
            ],
            'sale' => 0,
            'options' => []
        ];

        // Search term
        if(isset($filters['search_term'])) {
            $array['search_term'] = $filters['search_term'];
        }

        $array['brands'] = $brands->getList();
        $brand_products = $products->getListOfBrands($filters);

        // Filtro marcas
        foreach($array['brands'] as $bkey => $bitem) {
            $array['brands'][$bkey]['count'] = '0';
            foreach($brand_products as $bprod) {
                if($bprod['id_brand'] == $bitem['id']) {
                    $array['brands'][$bkey]['count'] = $bprod['c'];
                }
            }

            if($array['brands'][$bkey]['count'] == '0') {
                unset($array['brands'][$bkey]);
            }
        }

        // Filtro preço
        if(isset($filters['slider0'])) {
            $array['slider0'] = $filters['slider0'];
        }

        if(isset($filters['slider1'])) {
            $array['slider1'] = $filters['slider1'];
        }

        $array['maxslider'] = $products->getMaxPrice($filters);
        if($array['slider1'] == '0') {
            $array['slider1'] = $array['maxslider'];
        }

        // Filtro estrelas
        $star_products = $products->getListOfStars($filters);
        foreach($array['stars'] as $skey => $item)
        {
            foreach($star_products as $key => $sproduct)
            {
                if($sproduct['rating'] == $skey) {
                    $array['stars'][$skey] = $sproduct['c'];
                }
            }
        }

        // Filtro promoções
        $array['sale'] = $products->getSaleCount($filters);

        // Filtro opções
        $array['options'] = $products->getAvailableOptions($filters);

        return $array;
    }
}