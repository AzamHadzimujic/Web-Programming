<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/BlogpostDao.php';

class BlogpostService extends BaseService {
    public function __construct() {
        parent::__construct(new BlogpostDao());
    }
    public function getByUserId($user_id) {
        return $this->dao->getByUserId($user_id);
    }
    public function searchByTitle($keyword) {
        return $this->dao->searchByTitle($keyword);
    }
    public function validateBlogpostData($data) {
        $errors = [];
        if (empty($data['title'])) {
            $errors[] = 'Title is required.';
        }
        if (strlen($data['title']) > 255) {
            $errors[] = 'Title cannot exceed 255 characters.';
        }
        if (empty($data['content'])) {
            $errors[] = 'Content is required.';
        }
        if (strlen($data['content']) < 200) {
            $errors[] = 'Content must be at least 200 characters long.';
        }
        return $errors;
    }
}
?>