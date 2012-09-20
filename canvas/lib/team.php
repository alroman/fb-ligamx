<?php

class team_manager {
    
    static $team_mappings = array(
            'toluca' => 7113,
            'tijuana' => 7215,
            'club_leon' => 7198,
            'america' => 7106,
            'monterrey' => 7109,
            'cruz_azul' => 7107,
            'morelia' => 7110,
            'uanl_tigres' => 7115,
            'atlante' => 7104,
            'santos_laguna' => 7112,
            'pumas_unam' => 7116,
            'pachuca' => 7117,
            'atlas' => 7105,
            'guadalajara' => 7108,
            'chiapas' => 7118,
            'san_luis_potosi' => 7119,
            'puebla' => 7200,
            'queretaro' => 7121,
            'leon' => 7000,
        );

    
    static function load_match($row) {
        
    }
}

class team_match {
    
    public $status;
    public $teams;
    
    public function __construct($row) {
        $this->status = strtolower($row[0]);
        
        // Load teams
        $this->teams = new stdClass();
        $this->teams->home = team_entity::load_team($row[1]);
        $this->teams->away = team_entity::load_team($row[3]);
        
        if($this->status == 'final') {
            // Get score
            $this->teams->result = $this->_get_score($row[2]);
        } else {
            $this->teams->result = $this->_get_vs($row[0], $row[4]);
        }
        
    }
    
    private function _get_vs($date, $time) {
        list($d, $md) = explode('-', $date);
        list($month, $day) = explode('/', $md);
        list($hour, $m, $zone) = explode(' ', $time);
        
        $obj = new stdClass();
        
        $obj->final = 'vs';
        
        $obj->time = $time;
        $obj->day = $day;
        $obj->month = $month;
    }
    
    private function _get_score($data) {
        
        list($home, $away) = explode('-', $data);
        
        $obj = new stdClass();
        $obj->away = $away;
        $obj->home = $home;
        
        if($home > $away) {
            $obj->final = 'home';
        } else if ($home == $away) {
            $obj->final = 'tie';
        } else {
            $obj->final = 'away';
        }
        
        return $obj;
    }
    
}

class team_entity {
    
    public $data;
    private $_id;
    
    public function __construct($id, $short, $full) {
        $this->data = new stdClass();
        
        $this->data->shortname = $short;
        $this->data->fullname = $full;
        $this->data->img = $this->_get_img_path();
        
        $this->_id = $id;
    }
    
    private function _get_img_path() {
        return '/data/img/' . $this->_id . '.png';
    }
    
    static function load_team($name) {
        
        $team = strtolower($name);
        $team = str_replace(' ', '_', $team);
        $team = trim($team);
        
        return new team_entity(team_manager::$team_mappings[$team], $name, $team);
    }
}
