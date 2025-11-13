<?php
require_once 'BaseDao.php';

class BlogpostDao extends BaseDao {
   public function __construct() {
        parent::__construct("blogpost", "post_id");
    }

   public function getByUserId($user_id) {
        $stmt = $this->connection->prepare("SELECT * FROM blogpost WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function searchByTitle($keyword) {
        $stmt = $this->connection->prepare("SELECT * FROM blogpost WHERE title LIKE :keyword");
        $like = "%" . $keyword . "%";
        $stmt->bindParam(':keyword', $like);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>