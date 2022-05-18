<?php 

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

define('DS', DIRECTORY_SEPARATOR);
define("ROOT", dirname(__DIR__));
define("LOGS", ROOT.DS."logs"); 
define("WEBROOT", ROOT.DS."public");
define("MODULES", ROOT.DS."modules");
define("SYSTEM", ROOT.DS."system");

// Local config for each setup
include_once(ROOT.DS."config.php");

// Helper functions
include_once(SYSTEM.DS."helpers.php");

// Debug helper
include_once(SYSTEM.DS."debug.php");

// Database connection
include_once(SYSTEM.DS."database.php");

// Routes
include_once(SYSTEM.DS."routes.php");
