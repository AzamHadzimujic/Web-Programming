<?php
require_once 'BaseDao.php';


class CategoryDao extends BaseDao {
   public function __construct() {
        parent::__construct("category", "category_id");
    }

   public function getByName($name) {
        $stmt = $this->connection->prepare("SELECT * FROM category WHERE name = :name");
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        return $stmt->fetch();
    }
}

?>