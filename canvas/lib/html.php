<?php


class html_tag {
    
    private $tag;
    private $attribs;
    private $content;
    
    public function __construct($tag, $content = null, $attribs = array()) {
        $this->tag = $tag;
        
        $this->content = '';
        
        if($content) {
            $this->content = $content;
        }
        
        $this->attribs = $attribs;
    }
    
    public function add_attribs($attribs) {
        foreach($attribs as $k => $v) {
            $this->add_attrib($k, $v);
        }
        
        return $this;
    }
    
    public function add_attrib($name, $val) {
        
        if(key_exists($name, $this->attribs)) {
            $this->attribs[$name] .= ' ' . $val;
        } else {
            $this->attribs[$name] = $val;
        }
        
        return $this;
    }
    
    function add_class($class) {
        return $this->add_attrib('class', $class);
    }
    
    public function add_content($content) {
        $this->content .= $this->_add_content($content);
        return $this;
    }
    
    protected function _add_content($content) {
        if(is_object($content) && get_class($content) == 'html_tag') {
            $out = $content->render();
        } else if(is_string($content)) {
            $out = $content;
        }
        
        return $out;
    }
    
    public function render() {
        $out = '';
        $out .= '<' . $this->tag;
        
        if(!empty($this->attribs)) {
            foreach($this->attribs as $k => $v) {
                $out .= ' ' . $k . '="' . $v . '"';
            }
        }
        
        $out .= '>' . "\n";
        $out .= $this->content . "\n";
        $out .= '</' . $this->tag . '>' . "\n";
        
        return $out;
    }
}

class html_table extends html_tag {
    private $thead;
    private $tfooter;
    private $tbody;
    
    public function __construct($content = null, $attribs = array()) {
        parent::__construct('table', $content, $attribs);
        
        $this->thead = '';
        $this->tfooter = '';
        $this->tbody = '';
    }
    
    public function add_thead($content) {
        $this->thead .= $this->_add_content($content);
        return $this;
    }
    
    public function add_tbody($content) {
        $this->tbody .= $this->_add_content($content);
        return $this;
    }
    
    public function add_tfooter($content) {
        $this->tfooter .= $this->_add_content($content);
        return $this;
    }
    
    public function render() {
        $this->content = $this->thead . $this->tbody . $this->tfooter;
        return parent::render();
    }
}