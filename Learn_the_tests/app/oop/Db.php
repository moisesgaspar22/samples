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
     * @param string $dataBase | dummy
     * @param string $userName | dummy
     * @param string $password | dummy
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
     * This method should implement a response class
     * For the sake of simplicity it returns a simple array
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
