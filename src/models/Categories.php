<?php
namespace src\models;
use \core\Model;

class Categories extends Model
{
    public function getList()
    {
        $array = [];

        $sql = "SELECT * FROM categories ORDER BY sub DESC";
        $sql = $this->pdo->query($sql);

        if($sql->rowCount() > 0) {
            foreach($sql->fetchAll(\PDO::FETCH_ASSOC) as $item)
            {
                $item['subs'] = [];
                $array[$item['id']] = $item;
            }
            
            while($this->stillneed($array)) {
                $this->organizeCategorie($array);
            }
        }
        
        return $array;
    }

    public function getCategoryTree($id)
    {
        $array = [];

        $haveChild = true;
        while($haveChild) {
            $sql = "SELECT * FROM categories WHERE id = :id";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':id', $id);
            $sql->execute();

            if($sql->rowCount() > 0) {
                $sql = $sql->fetch(\PDO::FETCH_ASSOC);
                $array[] = $sql;

                if($sql['sub']) {
                    $id = $sql['sub'];
                } else {
                    $haveChild = false;
                }
            }
        }

        $array = array_reverse($array);
        return $array;
    }

    public function getCategoryName($id)
    {
        $sql = $this->pdo->prepare("SELECT name FROM categories WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $sql = $sql->fetch(\PDO::FETCH_ASSOC);
            return $sql['name'];
        }
    }

    private function organizeCategorie(&$array)
    {
        foreach($array as $id => $item)
        {
            if(isset($array[$item['sub']])) {
                $array[$item['sub']]['subs'][$item['id']] = $item;
                unset($array[$id]);
                break;
            }
        }
    }

    private function stillneed($array)
    {
        foreach($array as $item)
        {
            if(!empty($item['sub'])) {
                return true;
            }
        }

        return false;
    }

}