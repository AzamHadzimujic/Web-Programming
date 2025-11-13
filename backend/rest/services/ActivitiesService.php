<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/ActivitiesDao.php';

class ActivitiesService extends BaseService {
    public function __construct() {
        parent::__construct(new ActivitiesDao());
    }
    public function getByUserId($user_id) {
        return $this->dao->getByUserId($user_id);
    }
    public function getByCategoryId($category_id) {
        return $this->dao->getByCategoryId($category_id);
    }
    public function validateActivityData($data) {
        $errors = [];
        if (isset($data['activity_type']) && empty($data['activity_type'])) {
            $errors[] = 'Activity type is required.';
        }
        if (isset($data['duration']) && (!is_numeric($data['duration']) || $data['duration'] < 0 || $data['duration'] > 1440) ) {
            $errors[] = 'Duration must be real and/or non-negative number.';
        }
        if (isset($data['distance']) && (!is_numeric($data['distance']) || $data['distance'] < 0 || $data['distance'] > 1000) ) {
            $errors[] = 'Distance must be real and/or non-negative number.';
        }
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