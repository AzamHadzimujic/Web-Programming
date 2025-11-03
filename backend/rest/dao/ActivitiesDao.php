<?php
require_once 'BaseDao.php';


class ActivitiesDao extends BaseDao {
   public function __construct() {
        parent::__construct("activities", "activity_id");
    }

   public function getByUserId($user_id) {
        $stmt = $this->connection->prepare("SELECT * FROM activities WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByCategoryId($category_id) {
        $stmt = $this->connection->prepare("SELECT * FROM activities WHERE category_id = :category_id");
        $stmt->bindParam(':category_id', $category_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

?>