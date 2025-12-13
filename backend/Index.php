<?php
require 'vendor/autoload.php'; //run autoloader
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once __DIR__ . '/rest/services/ActivitiesService.php';
require_once __DIR__ . '/rest/services/BlogpostService.php';
require_once __DIR__ . '/rest/services/CategoryService.php';
require_once __DIR__ . '/rest/services/ProgresslogService.php';
require_once __DIR__ . '/rest/services/UsersService.php';
require_once __DIR__ . '/rest/services/AuthService.php';


Flight::register('activitiesService', 'ActivitiesService');
Flight::register('blogpostService', 'BlogpostService');
Flight::register('categoryService', 'CategoryService');
Flight::register('progresslogService', 'ProgresslogService');
Flight::register('usersService', 'UsersService');
Flight::register('authService', 'AuthService');

// This wildcard route intercepts all requests and applies authentication checks before proceeding.
Flight::route('/*', function() {
   if(
       strpos(Flight::request()->url, '/auth/login') === 0 ||
       strpos(Flight::request()->url, '/auth/register') === 0
   ) {
       return TRUE;
   } else {
       try {
           $token = Flight::request()->getHeader("Authentication");
           if(!$token)
               Flight::halt(401, "Missing authentication header");


           $decoded_token = JWT::decode($token, new Key(Config::JWT_SECRET(), 'HS256'));


           Flight::set('user', $decoded_token->user);
           Flight::set('jwt_token', $token);
           return TRUE;
       } catch (\Exception $e) {
           Flight::halt(401, $e->getMessage());
       }
   }
});

require_once __DIR__ . '/rest/routes/ActivitiesRoute.php';
require_once __DIR__ . '/rest/routes/BlogpostRoute.php';
require_once __DIR__ . '/rest/routes/CategoryRoute.php';
require_once __DIR__ . '/rest/routes/ProgresslogRoute.php';
require_once __DIR__ . '/rest/routes/UsersRoute.php';
require_once __DIR__ . '/rest/routes/AuthRoute.php';

Flight::start();  //start FlightPHP
?>
