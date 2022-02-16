<?php
    class DB{
        private $conn;

        function __construct()
        {
            $config = parse_ini_file('config.ini');
            $this->conn = new mysqli($config['db_host'],$config['db_user'],$config['db_pass'],$config['db_name']);
        }

        function getConnection()
        {
            return $this->conn;
        }
    }
?>