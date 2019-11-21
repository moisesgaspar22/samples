<?php

namespace someApp\oop;

/**
 * Wrapper layer class to communicate with the database
 */
class DbApp
{
    /**
     * Whatever db we're connecting to
     *
     * @var DbInterface
     */
    public $db;

    /**
     * Instanciator with db injection
     *
     * @param DbInterface $db
     * @return void
     */
    public function __construct(DbInterface $db)
    {
        $this->db = $db;
    }

    /**
     * get data from db layer
     *
     * @param string $query
     * @return array | record object etc
     */
    public function getSomeData($query)
    {
        return $this->db->getFromDb($query);
    }

    /**
     * sets data to db
     *
     * @param string $name
     * @param array $value
     * @return array
     */
    public function setSomeData($name, $value)
    {
        return $this->db->setToDb($name, $value);
    }
}
