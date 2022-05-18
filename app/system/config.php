<?php 

// Start the session
session_start();

define('DS', DIRECTORY_SEPARATOR);
define("ROOT", dirname(__DIR__));
define("LOGS", ROOT.DS."logs"); 
define("WEBROOT", ROOT.DS."public");
define("UI", ROOT.DS."theme");
define("THEME", UI.DS."elks");

// Local config for each setup
include_once(ROOT.DS."config.php");

// Helper functions
include_once(UI.DS."helpers.php");

// Debug helper
include_once(ROOT.DS."system".DS."debug.php");

// Routes
include_once(ROOT.DS."system".DS."routes.php");