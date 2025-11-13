<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/ProgresslogDao.php';

class ProgresslogService extends BaseService {
    public function __construct() {
        parent::__construct(new ProgresslogDao());
    }

    public function getByUserId($user_id) {
        return $this->dao->getByUserId($user_id);
    }

    public function getLatestByUserId($user_id) {
        return $this->dao->getLatestByUserId($user_id);
    }
    public function validateProgresslogData($data) {
        $errors = [];

        if (isset($data['weight']) && (!is_numeric($data['weight']) || $data['weight'] < 0 || $data['weight'] > 500) ) {
            $errors[] = 'Weight must be real and/or non-negative number.';
        }
        if (isset($data['bodyfat']) && (!is_numeric($data['bodyfat']) || $data['bodyfat'] < 0 || $data['bodyfat'] > 100) ) {
            $errors[] = 'Body fat must be under 100 and/or non-negative number.';
        }
        return $errors;
    }
}
?>