<?php
    class Database {
        private $_connection;
        private static $_instance;
        private $_host = "dinhvigps.com.vn";
        private $_username = "root";
        private $_password = "1234";
        private $_database = "money_lover";

        public static function getInstance() {
            if(!self::$_instance) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        private function __construct() {
            $this->_connection = new mysqli($this->_host, $this->_username, $this->_password, $this->_database);
            mysqli_set_charset($this->_connection, "utf8");
            if(mysqli_connect_error()) {
                require("error.html");
            }
        }

        private function __clone() { } // tránh clone Singleton

        public function getConnection() {
            return $this->_connection;
        }
    }
?>