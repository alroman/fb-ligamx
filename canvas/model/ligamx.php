<?php

class ligamx_model extends model {
    
    private $_datapath;
    
    public function __construct() {
        parent::__construct();
        
        $this->_datapath = dirname(__FILE__) . '/../data/';
    }
    
    public function get_table_data() {
        
    }
    
    public function process_results_table() {
        $datafile = 'results.txt';
        $cols = 5;
        
        $raw_data = $this->_process_file($datafile, $cols);
        
        $matches = array();
        
        foreach($raw_data as $rd) {
            $matches[] = new team_match($rd);
        }
        
        return $matches;
    }
    
   
    /**
     * Blind data processing
     * @param string $file
     * @param type $cols
     * @return type
     */
    private function _process_file($file, $cols) {
        $data = array();

        $file = dirname(__FILE__) . '/../data/' . $file;

        $fp = fopen($file, 'r');
        $buffer = fgets($fp);;
        
        if($fp) {
            while($buffer) {
                if(trim($buffer) == "") {
                    continue;
                }
                
                // Store col items at a time
                $tbuff = array();
                for($i = 0; $i < $cols; $i++) {
                    $tbuff[] = trim($buffer);
                    $buffer = fgets($fp);
                }
                $data[] = $tbuff;
            }
        }
        
        return $data;
    }
}