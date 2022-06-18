<?php 
namespace ridge;

require_once ('vendor/autoload.php');
require_once ('lib/sql.php');

// set up the router
$router = new \Bramus\Router\Router();

// check if config file exists
if (file_exists('conf/config.php')) {
    require_once ('conf/config.php');
} else {
    die('config.php not found');
}

if ($__config->debug == true) {
    intval(ini_set('display_errors', 1));
    error_reporting(E_ALL);
}

// setup the sql connection
$__db = new ridgeSQL($__config);


session_start();

?>