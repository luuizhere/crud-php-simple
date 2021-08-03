<?php

namespace Repository;

use DB\MySQL;

class StateRepository
{

    private object $MySQL;
    public const TABLE = 'states';


    public function __construct()
    {
        $this->MySQL = new MySQL;
    }

    public function getMySQL()
    {
        return $this->MySQL;
    }

    public function insertName($name)
    {
        $consultInsert = 'INSERT INTO ' . self::TABLE . ' (name) VALUES (:name)';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultInsert);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function getRegisterByName($name)
    {
        $consulta = 'SELECT * FROM ' . self::TABLE . ' WHERE name = :name';
        $stmt = $this->MySQL->getDb()->prepare($consulta);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        return $stmt->rowCount();
    }


}   