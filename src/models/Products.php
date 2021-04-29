<?php
namespace src\models;

use \core\Model;
use \src\models\Productsimages;
use \src\models\Options;
use src\models\Rates;

class Products extends Model
{
    public function getAvailableOptions($filters = [])
    {
        $groups = [];
        $ids = [];

        $where = $this->buildWhere($filters);

        $sql = "SELECT id, options FROM products WHERE ".implode(' AND ', $where)."";
        $sql = $this->pdo->prepare($sql);
        $this->bindWhere($filters, $sql);
        $sql->execute();

        if($sql->rowCount() > 0) {
            foreach($sql->fetchAll(\PDO::FETCH_ASSOC) as $product)
            {
                $ops = explode(',', $product['options']);
                $ids[] = $product['id'];
                foreach($ops as $op)
                {
                    if(!in_array($op, $groups)) {
                        $groups[] = $op;
                    }
                }
            }
        }

        $options = $this->getAvailableValuesFromOptions($groups, $ids);
        return $options;
    }

    public function getAvailableValuesFromOptions($groups, $ids)
    {
        $array = [];

        $options = new Options();
        foreach($groups as $op)
        {
            $array[$op] = [
                'name' => $options->getName($op),
                'options' => []
            ];
        }

        $sql = "SELECT p_value, id_option, COUNT(id_option) as c 
        FROM products_options 
        WHERE id_option IN (".implode(",", $groups).") 
        AND id_product IN (".implode(",", $ids).") 
        GROUP BY p_value 
        ORDER BY id_option";
        $sql = $this->pdo->prepare($sql);
        $sql->execute();
        if($sql->rowCount() > 0) {
            foreach($sql->fetchAll(\PDO::FETCH_ASSOC) as $ops)
            {
                $array[$ops['id_option']]['options'][] = [
					'id' => $ops['id_option'],
					'value'=>$ops['p_value'],
					'count'=>$ops['c']
                ]; 
            }
        }

        return $array;
    }

    public function getSaleCount($filters = [])
    {
        $where = $this->buildWhere($filters);
        $where[] = 'sale = "1"';

        $sql = "SELECT COUNT(price) as c FROM products WHERE ".implode(' AND ', $where)."";
        $sql = $this->pdo->prepare($sql);
        $this->bindWhere($filters, $sql);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $sql = $sql->fetch(\PDO::FETCH_ASSOC);
            return $sql['c'];
        } else {
            return '0';
        }
    }

    public function getMaxPrice($filters = [])
    {
        $sql = "SELECT MAX(price) as price FROM products";
        $sql = $this->pdo->prepare($sql);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $sql = $sql->fetch(\PDO::FETCH_ASSOC);
            return $sql['price'];
        } else {
            return '0';
        }
    }

    public function getListOfStars($filters = [])
    {
        $array = [];

		$where = $this->buildWhere($filters);
		$sql = "SELECT rating, COUNT(id) as c FROM products WHERE ".implode(' AND ', $where)." GROUP BY rating";
		$sql = $this->pdo->prepare($sql);
		$this->bindWhere($filters, $sql);

		$sql->execute();
		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}

		return $array;
    }

    public function getListOfBrands($filters = [])
    {
        $array = [];
        $where = $this->buildWhere($filters);

        $sql = "SELECT id_brand, COUNT(id) as c FROM products WHERE ".implode(' AND ', $where)." GROUP BY id_brand";
        $sql = $this->pdo->prepare($sql);

        $this->bindWhere($filters, $sql);
        $sql->execute();
        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function getList($offset = 0, $limit = 3, Array $filters = [], $random = false)
    {
        $array = [];
        $orderBySql = '';
        if($random) {
            $orderBySql = "ORDER BY RAND()";
        }

        if(!empty($filters['toprated'])) {
            $orderBySql = "ORDER BY rating DESC";   
        }

        $where = $this->buildWhere($filters);

        $sql = "SELECT *,
            (select brands.name from brands where brands.id = products.id_brand)
                as brand_name,
            (select categories.name from categories where categories.id = products.id_category)
                as category_name
        FROM products
        WHERE ".implode(' AND ', $where)."
        ".$orderBySql."
        LIMIT $offset, $limit";

        $sql = $this->pdo->prepare($sql);
        $this->bindWhere($filters, $sql);

        $sql->execute();
        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
            foreach($array as $key => $item)
            {
                $productsImages = new Productsimages();
                $array[$key]['images'] = $productsImages->getImagesByProductId($item['id']);
            }
        }

        return $array;
    }

    public function getTotal($filters = [])
    {
        $where = $this->buildWhere($filters);
        $sql = "SELECT COUNT(*) as c FROM products WHERE ".implode(' AND ', $where)."";

        $sql = $this->pdo->prepare($sql);
        $this->bindWhere($filters, $sql);

        $sql->execute();
        $sql = $sql->fetch(\PDO::FETCH_ASSOC);
        return $sql['c'] ?? '0';
    }

    private function buildWhere($filters)
    {
        $where = ['1=1'];

        if(!empty($filters['category'])) {
            $where[] = 'id_category = :id_category';
        }

        if(!empty($filters['brand'])) {
            $where[] = "id_brand IN (".implode("','", $filters['brand']).")";
        }

        if(!empty($filters['star'])) {
            $where[] = "rating IN (".implode("','", $filters['star']).")";
        }

        if(!empty($filters['sale'])) {
            $where[] = "sale = '1'";
        }

        if(!empty($filters['featured'])) {
            $where[] = "featured = '1'";
        }

        if(!empty($filters['options'])) {
			$where[] = "id IN (select id_product from products_options where products_options.p_value IN ('".implode("','", $filters['options'])."'))";
		}

        if(!empty($filters['slider0'])) {
            $where[] = "price >= :slider0";
        }

        if(!empty($filters['slider1'])) {
            $where[] = "price <= :slider1";
        }

        if(!empty($filters['search_term'])) {
            $where[] = "name LIKE :search_term";
        }

        return $where;
    }

    private function bindWhere($filters, &$sql)
    {
        if(!empty($filters['category'])) {
            $sql->bindValue(':id_category', $filters['category']);
        }

        if(!empty($filters['slider0'])) {
            $sql->bindValue(':slider0', $filters['slider0']);
        }

        if(!empty($filters['slider1'])) {
            $sql->bindValue(':slider1', $filters['slider1']);
        }

        if(!empty($filters['search_term'])) {
            $sql->bindValue(':search_term', '%'.$filters['search_term'].'%');
        }
    }

    public function getProductInfo($id)
    {
        $array = [];

        $sql = "SELECT *,
        (select brands.name from brands where brands.id = products.id_brand) as brand_name
        FROM products WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetch(\PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function getOptionsByProductId($id)
    {
        $options = array();

		// Etapa 1 - Pegar os nomes das opções.
		$sql = "SELECT options FROM products WHERE id = :id";
		$sql = $this->pdo->prepare($sql);
		$sql->bindValue(":id", $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$options = $sql->fetch();
			$options = $options['options'];

			if(!empty($options)) {
				$sql = "SELECT * FROM options WHERE id IN (".$options.")";
				$sql = $this->pdo->query($sql);
				$options = $sql->fetchAll();
			}

			// Etapa 2 - Pegar os valores das opções
			$sql = "SELECT * FROM products_options WHERE id_product = :id";
			$sql = $this->pdo->prepare($sql);
			$sql->bindValue(":id", $id);
			$sql->execute();
			$options_values = array();
			if($sql->rowCount() > 0) {
				foreach($sql->fetchAll() as $op) {
					$options_values[$op['id_option']] = $op['p_value'];
				}
			}

			// Etapa 3 - Juntar tudo em um único array.
			foreach($options as $ok => $op) {
				if(isset($options_values[$op['id']])) {
					$options[$ok]['value'] = $options_values[$op['id']];
				} else {
					$options[$ok]['value'] = '';
				}
			}

		}

		return $options;
    }

    public function getRates($id, int $qt)
    {
        $array = [];

        $rates = new Rates();
        $array = $rates->getRates($id, $qt);

        return $array;
    }

}