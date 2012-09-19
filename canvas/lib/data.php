<?php

class data_processor {
    public static function process_file($file, $cols) {
        $data = array();

        $file = dirname(__FILE__) . '/../data/' . $file;

        $fp = fopen($file, 'r');
        $buffer = fgets($fp);;
        
        if($fp) {
            while($buffer) {
                if(trim($buffer) == "") {
                    continue;
                }
                
                // Store 4 items at a time
                $tbuff = array();
                for($i = 0; $i < $cols; $i++) {
                    $tbuff[] = $buffer;
                    $buffer = fgets($fp);
                }
                $data[] = $tbuff;
            }
        }
        
        return $data;
    }
}

