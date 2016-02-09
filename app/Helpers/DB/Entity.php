<?php

namespace Helpers\DB;

abstract class Entity {

    /**
     * All tables must contain an id
     * The id is false if the instance is not in DB
     * Otherwise, the id is set to the current record
     */
    protected $id;


    /**
     *The CRUD object
     */
    protected $entityManager;

    public function __construct($id = false) {
        $this->id = $id;
        $this->entityManager = EntityManager::getInstance();
    }


    private function stripNamespaceFromClassName($obj) {
        $tmp = explode('\\', get_class($obj));
        return end($tmp);
    }

    /**
     * Return the table name
     * in fact return the name of the class in lower case
     * This is done by reflexion. PHP tells us the name of the (real) current class
     */


    public function getTableName() {
        return strtolower($this->stripNamespaceFromClassName($this));
    }

    /**
     * @return true if the instance is not saved in DB
     */

    public function isNew() {
        return $this->id === false;
    }

    /**
     * @return the id of the current element
     */

    public function getId() {
        if ($this->isNew())
            return false;
        return $this->id;
    }

    /**
     * Change the id of the current element (only if it was not saved ie the instance was new)
     */
    public function setId($id) {
        if ($this->id === false)
            $this->id = $id;
    }

}
