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

$router->post('/req/register', function() use ($__config) {
    // make header json due to ajax, NOTE: input is sanitized in the ajax call with DOMPurify
    header('Content-Type: application/json');

    // get the post data
    $post = json_decode($_POST);
    
    // check if the user is already registered
    $sql = 'SELECT * FROM users WHERE username = :username';
    $params = [
        'username' => $post->username
    ];

    $user = $__db->fetch($sql, $params);

    if ($user) {
        // user already exists
        return $response = (object) [
            'status' => 'error',
            'message' => 'user already exists'
        ];
    } else {
        // user does not exist, create it

        // hash the password
        $password = password_hash($post->password, PASSWORD_DEFAULT);
    
        // gen uuid token
        $token = vsprintf( '%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4));

        // check if password are the same
        if ($post->password != $post->password2) {
            return $response = (object) [
                'status' => 'error',
                'message' => 'passwords do not match'
            ];
        }

        // check if username is under 11 characters
        if (strlen($post->username) > 11) {
            return $response = (object) [
                'status' => 'error',
                'message' => 'username is too long'
            ];
        }

        $sql = 'INSERT INTO users (username, password_hash, token, aboutME, pfp, banner, dateCreated) VALUES (:username, :password, :token, :aboutME, :pfp, :banner, :dateCreated)';
        $params = [
            'username' => $post->username,
            'password' => $password,
            'token' => $token,
            'aboutme' => '',
            'pfp' => '/dynamic/pfp/default.png',
            'banner' => '/dynamic/banner/default.png',
            'datecreated' => date('Y-m-d H:i:s'),
        ];
        $__db->query($sql, $params);

        $response = (object) [
            'status' => 'success'
        ];

        // set cookie   
        setcookie('token', $token, time() + (86400 * 30), "/");
        return $response;
    }

    // return the response
    echo json_encode($response);
});

$router->run();
?>