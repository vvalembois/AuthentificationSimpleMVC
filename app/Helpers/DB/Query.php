<?php

namespace Helpers\DB;
use Exception;

abstract class Query {

    /**
     *The DB Manager
     */
    protected $dbManager;

    /**
     * We need the table and the object name
     */
    protected $tableName;
    protected $className;

    /**
     * The query under construction
     */
    protected $sql;


    /**
     * Params needed for the current querry (array)
     */

    protected $params;


    private static function stripNamespaceFromClassName($obj) {
        $tmp = explode('\\', get_class($obj));
        return end($tmp);

    }


    public function __construct() {
        $className = Query::stripNamespaceFromClassName($this);
        $this->className = "Models\\Tables\\" . substr($className, 0, strlen($className) - 3);
        $this->tableName = strtolower(substr($className, 0, strlen($className) - 3));
        $this->dbManager = DBManager::getInstance();
    }

    /**
     * Find a record wrt its id
     * @return the record if it exists, false otherwise
     */

    public function findById($id) {
        $this->dbManager->prepare("SELECT * FROM $this->tableName WHERE id=?");
        $this->dbManager->execute(array($id));
        $user = $this->dbManager->fetch($this->className);
//        echo "ici ... ". "<br>";
//        print_r($user);
//        echo "la ... ". "<br>";


        return $user;
    }

    /**
     * Execute the query under construction
     */
    public function execute() {
        $this->dbManager->prepare($this->sql);
        $this->dbManager->execute($this->params);
        return $this->dbManager->fetchAll($this->className);
    }


    /**
     * General Query
     * This is a preparation.
     * The query is execute only when the function execute is called
     * @param $cond : something after the where.....
     * @param $params the array necessary for the execution
     * return $this
     */
    function prepareFindWithCondition($cond, $params = false) {
        $this->sql = "SELECT * FROM $this->tableName WHERE $cond";
        $this->params = $params;
        return $this;
    }


    /**
     * Find all records
     * @return $this
     */
    public function prepareFindAll() {
        $this->sql = "SELECT * FROM $this->tableName";
        return $this;
    }

    /**
     * Add a limit in query
     * @param $start
     * @param $nb
     * @return $this
     */
    public function limit($start, $nb) {
        $this->sql .= " LIMIT $start,$nb";
        return $this;
    }

    /**
     * Sort results
     */

    public function orderBy($order) {
        $this->sql .= " ORDER BY $order";
        return $this;
    }


    /**
     * Automate  function findByXXX where XXX is a field of the given table
     */
    public function __call($name, $arguments) {
        if (strpos($name, "prepareFindBy") !== 0) {
            throw new Exception("function $name unknown in class " . get_class($this));
        }
        if (!is_array($arguments) || count($arguments) != 1) {
            throw new Exception("Only one argument in " . get_class($this) . "->$name");
        }

        $field = strtolower(substr($name, strlen("prepareFindBy")));
        return $this->prepareFindWithCondition("$field=?", $arguments);
    }

}

?>