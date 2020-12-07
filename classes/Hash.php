<?php
    class Hash {
        public static function make($string, $salt = '') {
            if($salt !== '')
                return hash('sha256', $string . $salt);
            return password_hash($string, PASSWORD_DEFAULT);
        }

        public static function salt($length) {
            return bin2hex(random_bytes($length));
        }

        public static function unique() {
            return self::make(uniqid());
        }

        public static function referalid($firstname, $lastname) {
            $_db = DB::getInstance();
            $referalid = '';
            $refer = '';

            if(strlen($firstname) < 4) {
                $len = strlen($firstname);
                if(strlen($lastname) >= 4-$len) {
                    $referalid = substr($firstname, $len).substr($lastname, 0, 4 - $len);
                } else {
                    $referalid = substr($firstname, $len).substr(uniqid('', true), 0, $len-4);
                }
            } else {
                $referalid = substr($firstname, 0, 4);
            }
            $referalid = strtoupper($referalid);
            $referalid .= rand(10000, 99999);
            $refer = str_shuffle($referalid);
            while(!$_db->get('users', array('referalid', '=', $refer))) {
                $referalid .= rand(10000, 99999);
                $refer = str_shuffle($referalid);
            }

            return $refer;
        }
    }
?>