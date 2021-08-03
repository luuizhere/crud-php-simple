<?php

namespace Repository;

use DB\MySQL;

class AddressRepository
{

    private object $MySQL;
    public const TABLE = 'addresses';


    public function __construct()
    {
        $this->MySQL = new MySQL;
    }

    public function getMySQL()
    {
        return $this->MySQL;
    }

    public function insertName($name,$city)
    {
        $consultInsert = 'INSERT INTO ' . self::TABLE . ' (name,city_id) VALUES (:name, :city)';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultInsert);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':city', $city);
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