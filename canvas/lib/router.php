<?php

class router {
    
    static function route($url = null) {
        global $config;
        
        if(!$url) {
            $url = $_SERVER[ 'REQUEST_URI' ];
        }

        // Split site 
        list($site, $args) = explode('?', $url);
        
        // Get site URL
        $config['www'] = 'http://' . $_SERVER['HTTP_HOST'] . $site;
        
        if(!empty($args)) {
            $params = explode('&', $args);
            $param_list = array();

            foreach($params as $p) {
                list($l, $r) = explode('=', $p);
                $param_list[$l] = $r;
            }

            $controller = $param_list['c'];
            $path = empty($param_list['p']) ? 'index' : $param_list['p'];
        } else {
            $controller = 'main';
            $path = 'index';
        }
        
        router::load($controller, $path);
    }
    
    static function load($controller, $path) {

        $controller_path = dirname(__FILE__) . '/../controller/';
        
        $file = $controller_path .  $controller . '.php';
        if(file_exists($file)) {

            require_once $file;
            
            $class = $controller . '_controller';
            $c = new $class;
            
            $c->$path();
        }
    }
}