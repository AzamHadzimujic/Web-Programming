<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthMiddleware {
    public function verifyToken($token){
        if(!$token) Flight::halt(401, "Missing authentication header");
        $decoded_token = JWT::decode($token, new Key(Config::JWT_SECRET(), 'HS256'));
        Flight::set('user', $decoded_token->user);
        Flight::set('jwt_token', $token);
        return TRUE;
    }
    public function authorizeRole($requiredRole) {
        $user = Flight::get('user');
        if (!$user || !isset($user->role)) {
            Flight::halt(401, 'Unauthorized');
        }

    // Case 1: normal usage with role string, e.g. 'admin'
    if (is_string($requiredRole)) {
        if ($user->role === $requiredRole) return TRUE;
        Flight::halt(403, 'Access denied: insufficient privileges');
    }

    // Case 2: bitmask usage (Roles::USER | Roles::ADMIN)
    if (is_int($requiredRole)) {
        $allowed = [];
        if (defined('Roles::USER') && is_int(Roles::USER) && (($requiredRole & Roles::USER) === Roles::USER)) {
        $allowed[] = 'user';
        }
        if (defined('Roles::ADMIN') && is_int(Roles::ADMIN) && (($requiredRole & Roles::ADMIN) === Roles::ADMIN)) {
        $allowed[] = 'admin';
        }

        // If roles are stored already as strings in JWT, check membership
        if (in_array($user->role, $allowed, true)) return TRUE;
        Flight::halt(403, 'Access denied: insufficient privileges');
    }
    // Fallback
    Flight::halt(403, 'Access denied: invalid role requirement');
    }

    public function authorizeRoles($roles) {
        $user = Flight::get('user');
        if (!$user || !isset($user->role)) {
            Flight::halt(401, 'Unauthorized');
        }
        if (!in_array($user->role, $roles, true)) {
            Flight::halt(403, 'Forbidden: role not allowed');
        }
        return TRUE;
    }
    public function authorizePermission($permission) {
        $user = Flight::get('user');
        if (!isset($user->permissions) || !in_array($permission, $user->permissions)) {
            Flight::halt(403, 'Access denied: permission missing');
        }
    return TRUE;
    }
}
?>