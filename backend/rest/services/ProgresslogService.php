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
    public function insert($data) {
    $data = (array)$data;

    // Accept both body_fat and bodyfat (frontend might send either)
    if (isset($data['bodyfat']) && !isset($data['body_fat'])) {
      $data['body_fat'] = $data['bodyfat'];
      unset($data['bodyfat']);
    }

    $errors = $this->validateProgresslogData($data);
    if (!empty($errors)) {
      return ['success' => false, 'errors' => $errors];
    }

    $jwtUser = Flight::get('user');
    if (!$jwtUser || !isset($jwtUser->user_id)) {
      return ['success' => false, 'error' => 'Missing user in token'];
    }

    $user_id = (int)$jwtUser->user_id;

    // Force user_id from token (prevents editing other users)
    $weight = isset($data['weight']) ? (int)$data['weight'] : null;
    $body_fat = isset($data['body_fat']) ? (int)$data['body_fat'] : null;

    // Find existing record for this user
    $existing = $this->dao->getOneByUserId($user_id);

    // If none exists: insert new
    if (!$existing) {
      $created = $this->dao->insert([
        'user_id' => $user_id,
        'weight' => $weight,
        'body_fat' => $body_fat
    ]);

      return [
        'success' => true,
        'action' => 'created',
        'data' => $created
      ];
    }

    // Compare values
    $changes = [];
    if ($weight !== null && (int)$existing['weight'] !== $weight) $changes['weight'] = $weight;
    if ($body_fat !== null && (int)$existing['body_fat'] !== $body_fat) $changes['body_fat'] = $body_fat;

    // If nothing changed: return existing
    if (empty($changes)) {
      return [
        'success' => true,
        'action' => 'no_change',
        'data' => $existing
      ];
    }

    // Update only changed fields
    $updated = $this->dao->update((int)$existing['progress_id'], $changes);

    return [
      'success' => true,
      'action' => 'updated',
      'data' => $updated
    ];
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