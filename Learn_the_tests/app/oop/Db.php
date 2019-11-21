<?php

namespace someApp\oop;

/**
 * This is a dummy class to act as a db layer
 * for test purposes
 */
class Db implements DbInterface
{

    /**
     * Holds the db connection
     *
     * @var stdClass
     */
    public $connection;

    /**
     * mocking a database service
     *
     * @param [type] $dataBase
     * @param [type] $userName
     * @param [type] $password
     */
    public function __construct($dataBase, $userName, $password)
    {
        //connect to database($dataBase, $userName, $password);
        $this->connection = new \stdClass();
    }

    /**
     * Dummy methods to get from database
     *
     * @param string $query | dummy
     * @return void
     */
    public function getFromDb($query)
    {
        return $this->connection->data = ['id' => '44'];
    }

    /**
     * Dummy methods to set to database
     *
     * @param string $name | dummy
     * @param array $value | dummy
     * @return void
     */
    public function setToDb($name, $value)
    {
        return $this->connection->data = [
            'status' => 'ok',
            'data'   => [
                $name => $value
            ]
        ];
    }
}
