<?php

class main_controller extends controller {
    
    public function __construct() {
        parent::__construct();
        
        global $config;
        
        // Load some libraries
        $this->lib('utils');
        $this->lib('html');
        $this->lib('data');
        $this->lib('team');
        $this->lib('ext/fb_sdk/src/facebook');
        
        // We'll need the model
        $this->model('ligamx');
        
        // Load the facebook skd with our info
        $this->fb = new Facebook(
                array(
                    'appId' => AppInfo::appID(),
                    'secret' => AppInfo::appSecret(),                )
            );
    }

    public function index() {
        
        // Get FB user info
        $facebook =& $this->fb;;
        
        $user_id = $facebook->getUser();
        
        // This won't work unless you're under FB environment
        try {
            $basic = $facebook->api('/me');

        } catch(FacebookApiException $e) {
            $basic = array('name' => 'Sure, Not');
        }
        
        $data = array(
            'basic' => $basic,
            'user_id' => $user_id,
            'top_ten' => $this->_top_ten(),
            'results_table' => $this->_results_table(),
            'res_table' => $this->res_table(),
        );

        $this->view('main', $data);
    }
    
    /**
     * Returns a top ten table
     * 
     * @return \html_tag object
     */
    private function _top_ten() {
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
    
    
    private function res_table() {
        $data = $this->ligamx->process_results_table();
        
        $table = new html_table();
        
        foreach($data as $match) {
            // Create a row
            $tr = new html_tag('tr');

            // Column with status
            $tr->add_content(new html_tag('td', $match->status));
            
            // New column
            $td = new html_tag('td');
            // Add a row here
            $div_row = new html_tag('div', '', array('class' => 'row'));
            
            if($match->status == 'final') {

                $home_team = $this->render_team($match->teams->home, 'pull-right');
                
                $h2 = new html_tag('h2', $match->raw[2]);
                $score = new html_tag('div', $h2, array('class' => 'span2 score-display'));
                
                $away_team = $this->render_team($match->teams->away);
                
                $div_row->add_content($home_team);
                $div_row->add_content($score);
                $div_row->add_content($away_team);
//
//            } else {
//                
            }
            $tr->add_content($td->add_content($div_row));
            
            $table->add_content($tr);
        }
        
        return $table;
    }
    
    function render_team($team, $class = '') {
        // Title
        $h3 = new html_tag('h4', $team->data->fullname, array('class' => $class));
        // Picture
        $img = new html_tag('img', '', array('src' => $team->data->img));
        $a = new html_tag('a', $img, array('href' => '#'));
        $p = new html_tag('p', $a);
        $div = new html_tag('div', $p, array('class' => 'media-grid ' . $class));

        return new html_tag('div', $h3->render() . $div->render(), array('class' => 'span3'));
    }
    
    function render_button() {
        
    }
    
    /**
     * Returns a results table 
     * 
     * @return \html_tag object
     */
    private function _results_table() {
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