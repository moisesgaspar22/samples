<?php

namespace bankApp\controllers;

/**
 * This is the main controller class
 * it loads the view and passes in the model data
 *
 * Class mainController
 * @package bankApp\controllers
 */
class mainController
{
    /**
     * @var string
     */
    private $viewPath;

    /**
     * @var string
     */
    private $partialPath;

    /**
     * @var string;
     */
    private $namespace = 'bankApp\\models\\';

    /**
     * Set some basic paths for the views and partials
     * constructor
     */
    protected function __construct()
    {
        $this->viewPath     = dirname(__FILE__).'/../views/';
        $this->partialPath  = dirname(__FILE__).'/../views/partials/';
    }

    /**
     * Loads the model if it exists and returns it to the controller or view
     * 
     * @param string $modelName
     * @param array $param
     * @return mixed
     */
    public function model($modelName = '', $param = [])
    {
        $class = $this->namespace.$modelName;
        if (class_exists($class)) {
            $obj = new $class();

            if (empty($param)) {
                return $obj;
            } else {
                //__invoke from the model
                return $obj($param);
            }
        }
        return false;
    }

    /**
     * Loads the view if it exists and returns it to the controller 
     * @param $viewName
     * @param array $data
     * @return mainController
     */
    public function view($viewName, $data = [])
    {
        $this->verifyLoading($this->viewPath, $viewName, $data);
        return $this;
    }

    /**
     * Checks if a file exists and requires it
     * 
     * @param $path
     * @param $viewName
     * @param array $data | is being injected and not used inside?? think again!!
     * All the code being required will see $data ... 🤺
     * @return bool
     *
     * @throws Exception
     */
    public function verifyLoading($path, $viewName, $data)
    {
        $viewFile = $path . (string)$viewName . '.php';
        if (file_exists($viewFile)) {
            require $viewFile;
            return true;
        }
        
        throw new \Exception('Partial view file ' . $viewName . ' not found');
    }
}
