<?php
require_once __DIR__ . '/BaseDao.php';

class AuthDao extends BaseDao {

    public function __construct() {
        parent::__construct("users", "user_id");
    }

    public function get_user_by_email($email) {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->connection->prepare($query);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }
}
?>