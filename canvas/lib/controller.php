<?php

/**
 * Base controller class
 */

abstract class controller {
    private $_name;
    
    public function __construct() {
        $this->_name = get_class();
    }
    
    /**
     * Load a view with data
     * 
     * @param type $view
     * @param type $data
     */
    protected function view($view, $data = array()) {
        $path = dirname(__FILE__) . '/../view/';
        $file = $path . $view . '.php';

        if(file_exists($file)) {
            extract($data);
        
            require_once $file;
        }
    }
    
    /** 
     * Load a library file
     * 
     * @param type $lib
     */
    protected function lib($lib) {
        $path = dirname(__FILE__) . '/../lib/';
        $file = $path . $lib . '.php';
        
        $this->_load($file);
    }
    
    /**
     * Load a model
     * 
     * @param type $model
     * @param type $alias
     */
    protected function model($model, $alias = null) {
        $path = dirname(__FILE__) . '/../model/';
        $file = $path . $model . '.php';
        
        $this->_load($file);
        $class = $model . '_model';
        
        $obj = empty($alias) ? $model : $alias;
        
        $this->$obj = new $class;
    }

    private function _load($file) {
        if(file_exists($file)) {
            require_once $file;
        }
    }

    /**
     * Controllers must have this
     */
    abstract public function index();
    
}   