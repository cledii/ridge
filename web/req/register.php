<?php
namespace ridge;

// setup
require_once ('../vendor/autoload.php');
require_once ('../lib/sql.php');
require_once ('../lib/accounts.php');
require_once ('../conf/config.php');

$__db = new ridgeSQL($__config);
$__accounts = new ridgeAccounts();

header('Content-Type: application/json');

// get post data from request (sanitized on AJAX call)
$username = htmlspecialchars($_POST['username']);
$password = htmlspecialchars($_POST['password']);

// check if there isn't any data and return error
if ($username == '' && $password == '') {
    echo json_encode([
        'status' => 'error',
        'message' => 'no username or password provided',
        'post' => $_POST
    ]);
    exit;
}

// hash the password
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// generate a token
$token = bin2hex(openssl_random_pseudo_bytes(16));

// make account
$createaccount = $__accounts->register($username, $passwordHash, $token);

if ($createaccount == true) {
    echo json_encode([
        'status' => 'success',
    ]);
} else {
    // set token in cookie
    setcookie('token', $token, time() + (86400 * 30), '/');

    echo json_encode([
        'status' => 'error',
        'message' => 'username already exists'
    ]);
}
?>