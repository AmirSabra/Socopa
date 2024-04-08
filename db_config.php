<?php
    class DbConfig {
        private $db_host;
        private $db_username;
        private $db_password;
        private $db_name;
        private $db_tables;  
        private $mysqli;

        function __construct() {
            $this->db_host = "sql201.epizy.com";
            $this->db_username = "epiz_33627716";
            $this->db_password = "UU6bTADvdf";
            $this->db_name = "epiz_33627716_socopacrm";
            $this->db_tables = [
                "requests" => "requests",
                "request_statuses" => "request_statuses",
                "request_types" => "request_types"
            ];
        
            $this->mysqli = new mysqli($this->db_host, $this->db_username, $this->db_password, $this->db_name);
        }

        function getDbConnection() {
            if ($this->mysqli->connect_error) {
                die("Connection failed: " . $this->mysqli->connect_error);
            } else {
                return $this->mysqli;
            }
        }

        function getDbTables() {
            return $this->db_tables;
        }
    }
?>