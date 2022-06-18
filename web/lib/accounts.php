<?php 
namespace ridge;

class ridgeAccounts {
    public function __construct() {
        $this->db = $__db;
    }

    /**
     * register a new user
     * @param string $username
     * @param string $passwordHash
     * @param string $token
     * 
     * @return boolean
     */
    public function register($username, $passwordHash, $token) {
        $sql = 'SELECT * FROM users WHERE username = :username';
        $params = [
            'username' => $post->username
        ];

        $user = $this->db->fetch($sql, $params);

        if ($user) {
            return false;
        }

        
        $sql = 'INSERT INTO users (username, password_hash, token, aboutME, pfp, banner, dateCreated) VALUES (:username, :password, :token, :aboutME, :pfp, :banner, :dateCreated)';
        $params = [
            'username' => $username,
            'password' => $passwordHash,
            'token' => $token,
            'aboutme' => '',
            'pfp' => '/dynamic/pfp/default.png',
            'banner' => '/dynamic/banner/default.png',
            'datecreated' => date('Y-m-d H:i:s'),
        ];
        $this->db->query($sql, $params);

        return true;
    }

    // lol
}
?>