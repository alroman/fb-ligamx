<?php

require_once dirname(__FILE__) . '/../lib/controller.php';

class main_controller extends controller {
    
    public function __construct() {
        parent::__construct();
        $this->lib('html');
        $this->lib('data');
        $this->lib('team');
    }

    public function index() {
        
        $data = array(
            'top_ten' => $this->top_ten(),
            'results_table' => $this->results_table(),
        );
        
        $this->view('main', $data);
    }
    
    private function top_ten() {
        $path = 'teams.txt';
        $data = data_processor::process_file($path, 4);
        
        $html_rows = '';
        
        foreach($data as $datum) {
            $row = new html_tag('div');
    
            $html = '';

            foreach($datum as $d) {
                $class = strlen($d) < 4 ? 'span1' : 'span3';
                
                $tag = new html_tag('div', $d, array('class' => $class));
                $html .= $tag->render();

            }
            
            $row->add_content($html)
                ->add_attrib('class', 'row');
            
            $html_rows .= $row->render();
        }
        
        $header = new html_tag('h5', 'Top 10 teams', array('class' => 'tab'));
        $content = new html_tag('div', $header->render() . $html_rows, array('class' => 'span6'));
        
        return $content;
    }
    
    private function results_table() {
        $path = 'results.txt';
        $data = data_processor::process_file($path, 5);
        
        $table = new html_tag('table');
        
        foreach($data as $datum) {
            $tr = new html_tag('tr');
            
            foreach($datum as $d) {
                $td = new html_tag('td', $d);
                $tr->add_content($td);
            }
            
            $table->add_content($tr);
        }
        
        $table->add_class('zebra-striped')
              ->add_class('bordered-table');
        
        return $table;
    }
}