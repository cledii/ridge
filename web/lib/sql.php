<?php 
namespace ridge;
use PDO;
use PDOException;

class ridgeSQL {
    private $__db;

    function __construct($__config) {
        try { 
            $this->__db = new PDO(
                'mysql:host=' . $__config->db->host . ';dbname=' . $__config->db->name,
                $__config->db->user,
                $__config->db->pass
            ); 
        } catch (PDOException $e) {
             die('sql failed: ' . $e->getMessage());
        }
    }

    function destruct() {
        $this->__db = null;
    }

    function query($sql, $params = []) {
        $stmt = $this->__db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    function result($query, $params = []) {
        $stmt = $this->query($query, $params);
        return $stmt->fetchColumn();
    }

    function fetch($query, $params = []) {
        $stmt = $this->query($query, $params);
        return $stmt->fetch();
    }

    function fetchArray($query) {
        $out = [];
        while ($record = $query->fetch()) {
            $out[] = $record;
        }
        return $out;
    }   
}
