<?php

abstract class controller {
    private $_name;
    
    public function __construct() {
        $this->_name = get_class();
    }
    
    public function invoke($path = 'index') {
        $this->$path();
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
    
    protected function lib($lib) {
        $path = dirname(__FILE__) . '/../lib/';
        $file = $path . $lib . '.php';
        
        $this->_load($file);
    }
    
    protected function _load($file) {
        if(file_exists($file)) {
            require_once $file;
        }
    }

    abstract public function index();
    
}   