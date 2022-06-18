<?php 
namespace ridge;
require_once ('vendor/autoload.php');
require_once ('lib/sql.php');
require_once ('lib/accounts.php');

$router = new \Bramus\Router\Router();

$loader = new \Twig\Loader\FilesystemLoader('./pages');
$twig = new \Twig\Environment($loader, [
    'debug' => $__config->twig->debug,
]);

$router->set404(function() use ($twig) {
    header('HTTP/1.1 404 Not Found');
    echo $twig->render('404.twig');
});

$isLoggedIn = false;

// check if config file exists
if (file_exists('conf/config.php')) {
    require_once ('conf/config.php');
} else {
    die('config.php not found');
}

// setup the libs
$__db = new ridgeSQL($__config);
$__accounts = new ridgeAccounts();

// start session
session_start();

// is the user logged in?
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $isLoggedIn = true;
} else {
    $user = "";
    $isLoggedIn = false;
}

$twig->addGlobal('isLoggedIn', $isLoggedIn);
$twig->addGlobal('user', $user);

// check if ip is banned
$sql = 'SELECT * FROM ipbans WHERE banned_ip = :ip';
$params = [
    'ip' => $_SERVER['REMOTE_ADDR']
];
$ipban = $__db->fetch($sql, $params);
if ($ipban) {
    header('Location: /ipban');
}