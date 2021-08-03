<?php

namespace Repository;

use DB\MySQL;

class UserRepository
{

    private object $MySQL;
    public const TABLE = 'users';


    public function __construct()
    {
        $this->MySQL = new MySQL;
    }

    public function getMySQL()
    {
        return $this->MySQL;
    }

    public function insertUser($name, $address)
    {
        $consultInsert = 'INSERT INTO ' . self::TABLE . ' (name, address_id) VALUES (:name, :ad)';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultInsert);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':ad', $address);
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