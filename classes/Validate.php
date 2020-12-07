<?php
    class Validate {
        private $_passed = false,
                $_errors = array(),
                $_db = null;
        
        public function __construct() {
            $this->_db = DB::getInstance();            
        }

        public function check($source, $items = array()) {
            foreach($items as $item => $rules) {
                foreach($rules as $rule => $rule_value) {
  
                    $value = $source[$item];
                    $item = escape($item);

                    if($rule === 'required' && empty($value)) {
                        $this->addError("<strong>".$rules['name']."</strong> is requierd"); 
                    } else if(!empty($value)) {
                        switch($rule) {
                            case 'min':
                                if(strlen($value) < $rule_value) {
                                     $this->addError("<strong>".$rules['name']."</strong> must be a minimum of {$rule_value} characters."); 
                                }
                                break;
                            case 'max':
                                if($value > $rule_value) {
                                    $this->addError("<strong>".$rules['name']."</strong> must be a maximum of {$rule_value} characters."); 
                                }
                                break;
                            case 'minval':
                                if($value < $rule_value) {
                                    $this->addError("Minimum value of <strong>".$rules['name']."</strong> must be {$rule_value}."); 
                                }
                                break;
                            case 'maxval':
                                if($value > $rule_value) {
                                    $this->addError("Maximum value of <strong>".$rules['name']."</strong> must be {$rule_value}."); 
                                }
                                break;
                            case 'length':
                                if(strlen($value) != $rule_value) {
                                    $this->addError("<strong>".$rules['name']."</strong> must be {$rule_value} characters."); 
                                }
                                break;
                            case 'matches':
                                if($value != $source[$rule_value]) {
                                    $this->addError("<strong>".$rules['name']."</strong> must match <strong>".$rules['matches_name']."</strong>."); 
                                }
                                break;
                            case 'unique':
                                $check = $this->_db->get($rule_value, array($rules['uniqueness'], '=', $value));
                                if($check->count() != 0) {
                                    $this->addError("<strong>".$rules['name']."</strong> already exists."); 
                                }
                                break;
                            case 'exist':
                                $check = $this->_db->get($rule_value, array($rules['existvalue'], '=', $value));
                                if($check->count() === 0) {
                                    $this->addError("<strong>".$rules['name']."</strong> is Invalid."); 
                                }
                                break;
                        }
                    }
                    
                }
            }

            if(empty($this->_errors)) {
                $this->_passed = true;
            }

            return $this;
        }

        public function addError($_error) {
            $this->_errors[] = $_error;
        }

        public function errors() {
            return $this->_errors;
        }

        public function passed() {
            return $this->_passed;
        }
    }
?>