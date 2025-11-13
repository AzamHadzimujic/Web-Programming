<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/UsersDao.php';

class UsersService extends BaseService {
    public function __construct() {
        parent::__construct(new UsersDao());
    }

    public function getByEmail($email) {
        return $this->dao->getByEmail($email);
    }

    public function getByUsername($username) {
        return $this->dao->getByUsername($username);
    }

    public function validateUserData($data) {
        $errors = [];

        if (empty($data['username']) || strlen($data['username']) < 8) {
            $errors[] = "Username must be at least 8 characters long.";
        }

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email address.";
        }

        if (empty($data['password']) || strlen($data['password']) < 8) {
            $errors[] = "Password must be at least 8 characters long.";
        }

        return $errors;
    }
}
?>