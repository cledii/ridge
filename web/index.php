<?php 
namespace ridge;
require_once ('lib/setup.php');

// twig is epic™®© -- billygoat891
$router->get('/', function() use ($twig, $__config) {
    echo $twig->render('index.twig', array());
});

$router->get('/ipban', function() use ($twig, $__config) {
    echo $twig->render('ipban.twig', array());
});

$router->get('/register', function() use ($twig, $__config) {
    echo $twig->render('register.twig', array());
});


$router->run();
?>