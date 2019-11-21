<?php

namespace bankApp\controllers;

/**
 * Class mainPageController
 * @package bankApp\controllers
 */
class mainPageController extends mainController
{
    
    const MODEL = 'dataModel';

    /**
     * @var null
     */
    private static $instance = null;


    /**
     * @return themeControllerRender|null
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new mainPageController();
        }
        return self::$instance;
    }

    /**
     * Load dynamic methods for the Data Model
     * if you want to override the model method just create one here with the same name
     * 
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (method_exists($this->model(self::MODEL), $name)) {
            return $this->model(self::MODEL, [$name, $arguments]);
        }

        throw new \Exception(self::MODEL . ' -> Method not found '.$name);
    }
}
