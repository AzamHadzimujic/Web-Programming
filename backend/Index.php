<?php
require 'vendor/autoload.php'; //run autoloader

require_once __DIR__ . '/rest/services/ActivitiesService.php';
require_once __DIR__ . '/rest/services/BlogpostService.php';
require_once __DIR__ . '/rest/services/CategoryService.php';
require_once __DIR__ . '/rest/services/ProgresslogService.php';
require_once __DIR__ . '/rest/services/UsersService.php';


Flight::register('activitiesService', 'ActivitiesService');
Flight::register('blogpostService', 'BlogpostService');
Flight::register('categoryService', 'CategoryService');
Flight::register('progresslogService', 'ProgresslogService');
Flight::register('usersService', 'UsersService');

require_once __DIR__ . '/rest/routes/ActivitiesRoute.php';
require_once __DIR__ . '/rest/routes/BlogpostRoute.php';
require_once __DIR__ . '/rest/routes/CategoryRoute.php';
require_once __DIR__ . '/rest/routes/ProgresslogRoute.php';
require_once __DIR__ . '/rest/routes/UsersRoute.php';

Flight::start();  //start FlightPHP
?>
