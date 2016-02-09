<?php

namespace Helpers\DB;

use PDO;
use PDOException;

/**
 * Implement the adapter for PDO
 */
class  DBManager {

    private $pdo = false;
    protected static $instance;
    protected $sql; // to display errors

    /**
     * Create the pdo instance
     */
    private function __construct($host = DB_HOST, $db = DB_NAME, $user = DB_USER, $passwd = DB_PASS) {
        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$db", $user, $passwd, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage() . "<br />";
        }
    }

    protected function __clone() {
    }

    public static function getInstance() {
        if (!isset(self::$instance)) // Si on n'a pas encore instancié notre classe.
        {
            self::$instance = new self; // On s'instancie nous-mêmes. :)
        }
        return self::$instance;
    }


    /**
     * Prepare the query
     */
    function prepare($sql) {
        $this->sql = $sql;
        $this->query = $this->pdo->prepare($sql);
    }

    /**
     * Execute the query
     */
    function execute($params = false) {
        try {
            if ($params == false)
                $this->query->execute();
            else
                $this->query->execute($params);
        } catch (PDOException $e) {
            throw  new \Exception($e->getMessage() . " " . $this->sql);
        }


    }

    /**
     * Fetch one record
     * Take a look at the mode !!!!
     */
    function fetch($className) {
        $this->query->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $className);
        return $this->query->fetch();
    }

    /**
     * Fetch all records
     */
    function fetchAll($className) {
        $this->query->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $className);
        return $this->query->fetchAll();
    }

    /**
     * Retrieve last insert id
     */
    function lastInsertId() {
        return $this->pdo->lastInsertId();
    }
}

?>