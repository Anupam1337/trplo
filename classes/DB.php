<?php
    class DB {
        private static $_instance = null;
        private $_pdo,
                $_query,
                $_error = false,
                $_results,
                $_count = 0;

        private function __construct() {
            try {
                $this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
            } catch(PDOException $e) {
                die($e->getMessage());
            }
        }

        public static function getInstance() {
            if(!isset(self::$_instance)) {
                self::$_instance = new DB();
            }
            return self::$_instance;
        }

        public function query($sql, $params = array()) {
            $this->_error = false;
            if($this->_query = $this->_pdo->prepare($sql)) {
                $x = 1;
                if(count($params)) {
                    foreach($params as $param) {
                        $this->_query->bindValue($x, $param);
                        $x++;
                    }
                }

                if($this->_query->execute()) {
                    $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                    $this->_count = $this->_query->rowCount();
                } else {
                    echo $this->_query->execute();
                    $this->_error = true;
                }
            }

            return $this;
        }

        private function action($action, $table, $where = array(), $orderby='') {
            if(count($where) === 3) {
                $operators = array('=', '>', '<', '>=', '<=', 'LIKE');

                $field      = $where[0];
                $operator   = $where[1];
                $value      = $where[2];

                if(in_array($operator, $operators)) {
                    $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? $orderby";
                    
                    if(!$this->query($sql, array($value))->error()) {
                        return $this;
                    }
                }
            } elseif($action && $table) {
                $sql = "{$action} FROM {$table} $orderby";
                    
                if(!$this->query($sql)->error()) {
                    return $this;
                }
            }
            return false;
        }

        public function getCount($table, $where) {
            return $this->action('SELECT COUNT(*) as count', $table, $where);
        }

        public function getMaxCount($table, $field, $like = array()) {
            if(!count($like)) {
                return $this->action('SELECT MAX(' . $field . ') as max', $table);
            }
            return $this->action('SELECT MAX(' . $field . ') as max', $table, $like);
        }

        public function get($table, $where, $orderby='') {
            return $this->action('SELECT *', $table, $where, $orderby);
        }

        public function delete($table, $where) {
            return $this->action('DELETE', $table, $where);
        }

        public function insert($table, $fields = array()) {
            
            $keys = array_keys($fields);
            $values = str_repeat("?, ", count($fields)-1).'?';

            $sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$values})";

            if(!$this->query($sql, $fields)->error()) {
                return true;
            }

            return false;
        }

        public function update($table, $id, $fields) {
            $set = '';
            $x = 1;

            foreach($fields as $name => $value) {
                $set .= "{$name} = ?";
                if($x < count($fields)) {
                    $set .= ', ';
                }
                $x++;
            }

            $fields['id'] = $id;
            $sql = "UPDATE {$table} SET {$set} WHERE id = ?";

            if(!$this->query($sql, $fields)->error()) {
                return true;
            }

            return false;
        }

        public function results() {
            return $this->_results;
        }

        public function first() {
            return $this->results()[0];
        }

        public function error() {
            return $this->_error;
        }

        public function count() {
            return $this->_count;
        }

    }
?>