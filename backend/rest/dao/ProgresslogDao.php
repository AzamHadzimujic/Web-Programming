<?php
require_once 'BaseDao.php';

class ProgresslogDao extends BaseDao {
   public function __construct() {
        parent::__construct("progress_log", "progress_id");
    }

    public function getByUserId($user_id) {
        $stmt = $this->connection->prepare("SELECT * FROM progress_log WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getLatestByUserId($user_id) {
        $stmt = $this->connection->prepare("
            SELECT * FROM progress_log 
            WHERE user_id = :user_id 
            ORDER BY log_id DESC 
            LIMIT 1
        ");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetch();
    }
}
?>