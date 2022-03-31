<?php
namespace src\models;
use \core\Model;

class Permissions extends Model {

    public function getUserPermissions($idPermission) {
        $array = [];

        $sql = "SELECT id_permission_item FROM permission_links WHERE id_permission_group = :id_permission";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_permission", $idPermission);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
            $ids = [];

            foreach($data as $dataItem) {
                $ids[] = $dataItem["id_permission_item"];
            }

            $sql = "SELECT slug FROM permission_items WHERE id IN (".implode(',', $ids).")";
            $sql = $this->pdo->query($sql);

            if($sql->rowCount() > 0) {
                $data = $sql->fetchAll();
                
                foreach($data as $dataItem) {
                    $array[] = $dataItem["slug"];
                }
            }
        }

        return $array;
    }

    public function getAllGroups() {
        $array = [];

        $sql = "SELECT
            permission_groups.*,
            (
                select count(users.id)
                from users
                where users.id_permission = permission_groups.id
            )
            as totalUsers
            FROM permission_groups";
        $sql = $this->pdo->query($sql);
        
        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function getAllItems() {
        $array = [];

        $sql = "SELECT * FROM permission_items";
        $sql = $this->pdo->query($sql);

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function addGroup($name) {
        $sql = "INSERT INTO permission_groups (name) VALUES (:name)";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":name", $name);
        $sql->execute();

        return $this->pdo->lastInsertId();
    }

    public function linkItemToGroup($item, $id) {
        $sql = "INSERT INTO permission_links (id_permission_group, id_permission_item) VALUES (:id_group, :id_item)";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_group", $id);
        $sql->bindValue(":id_item", $item);
        $sql->execute();
    }

    public function deleteGroup($id) {

        $sql = "SELECT id FROM users WHERE id_permission = :id_group";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_group", $id);
        $sql->execute();

        // Só excluimos se não tem nenhum usuário nesse grupo de permissões
        if($sql->rowCount() === 0) {

            $sql = "DELETE FROM permission_links WHERE id_permission_group = :id_group";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id_group", $id);
            $sql->execute();

            $sql = "DELETE FROM permission_groups WHERE id = :id_group";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id_group", $id);
            $sql->execute();

            return true;
            exit;
        }

        return false;

    }
    
}