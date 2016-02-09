<?php

namespace Helpers\DB;


/**
 * PDO implementation to CRUD
 */
class EntityManager {

    protected static $crud;

    /**
     * Need a connection to the database
     */
    private $dbmanager;

    /**
     * Constructor
     */
    public function __construct() {
        $this->dbmanager = DBManager::getInstance();
    }

    protected function __clone() {
    } // Méthode de clonage en privé aussi.

    public static function getInstance() {
        if (!isset(self::$crud)) // Si on n'a pas encore instancié notre classe.
        {
            self::$crud = new self; // On s'instancie nous-mêmes. :)
        }

        return self::$crud;
    }


    /**
     * Save inside the DB
     */
    public function save($instance) {
        if ($instance->isNew()) {
            $this->insert($instance);
        } else {
            $this->update($instance);
        }
    }


    /**
     * Insert INTO ....
     */
    private function insert($instance) {
        $tableName = $instance->getTableName();


        $sql = "INSERT INTO $tableName VALUES(NULL";

        $vars = get_class_vars(get_class($instance));
        $nb = count($vars);

        for ($i = 0; $i < $nb; $i++)
            $sql = $sql . ",?";
        $sql = $sql . ")";

        $values = array();
        foreach ($vars as $k => $v) {
            $values[] = $instance->$k;
        }
        $this->dbmanager->prepare($sql);
        $this->dbmanager->execute($values);
        $instance->setId($this->dbmanager->lastInsertId());
    }


    /**
     * UPDATE ...
     */
    private function update($instance) {
        $tableName = $instance->getTableName();
        $sql = "UPDATE $tableName SET ";
        $vars = get_class_vars(get_class($instance));

        $values = array();
        $first = true;
        foreach ($vars as $k => $v) {
            $values[] = $instance->$k;
            if ($first == false)
                $sql = $sql . ",";
            $sql = $sql . "$k = ?";
            $first = false;
        }

        $sql = $sql . "WHERE id=?";
        $values[] = $instance->getId();
        $this->dbmanager->prepare($sql);
        $this->dbmanager->execute($values);

    }

    /**
     * DELETE FROM ....
     */
    public function delete($instance) {
        if ($instance->isNew() == true) {
            return;
        }

        $tableName = $instance->getTableName();

        $sql = "DELETE FROM $tableName WHERE id=?";

        $this->dbmanager->prepare($sql);
        $this->dbmanager->execute(array($instance->getId()));
    }
}


?>