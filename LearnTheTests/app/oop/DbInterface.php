<?php

namespace someApp\oop;

/**
 * dead simple interface
 */
interface DbInterface
{
    //public function connect($database, $userName, $passWord);
    public function getFromDb($query);
    public function setToDb($name, $value);
}
