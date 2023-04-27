<?php
    namespace SQLProject\util;

    use mysqli;
    use mysqli_result;
    use mysqli_sql_exception;

    require_once $_SERVER['DOCUMENT_ROOT'] . '/SQLProject/constants.php';

    class SQLConnection {
        private string $server;
        private string $username;
        private string $password;
        private string $database;
        private mysqli $connection;

        public function __construct(string $server, string $username, string $password) {
            $this -> server = $server;
            $this -> username = $username;
            $this -> password = $password;
        }

        public function connect() : bool {
            try {
                $this -> connection = new mysqli($this -> server, $this -> username, $this -> password);
                return true;
            } catch (mysqli_sql_exception) {
                return false;
            }
        }

        public function selectDatabase(string $database, bool $create_if_null = false) : bool {
            if (!isset($this -> connection))
                return false;

            try {
                $success = $this->connection->select_db($database);

                if (!$success) return false;

            } catch (mysqli_sql_exception) {
                if ($create_if_null) {
                    $success = $this -> connection -> query("CREATE DATABASE " . $database);

                    if (!$success) return false;

                    $this -> database = $database;
                }

                return false;
            }

            if ($create_if_null) {
                $this -> connection -> query("CREATE TABLE IF NOT EXISTS Customers (" . CUSTOMERS_SCHEMA . ")");
                $this -> connection -> query("CREATE TABLE IF NOT EXISTS Employees (" . EMPLOYEES_SCHEMA . ")");
                $this -> connection -> query("CREATE TABLE IF NOT EXISTS Drugs (" . DRUGS_SCHEMA . ")");
                $this -> connection -> query("CREATE TABLE IF NOT EXISTS Drug_Types (" . DRUG_TYPES_SCHEMA . ")");
                $this -> connection -> query("CREATE TABLE IF NOT EXISTS Prescriptions (" . PRESCRIPTIONS_SCHEMA . ")");
            }

            return true;
        }

        public function query(string $query) : mysqli_result | bool {
            if (!isset($this -> connection))
                return false;

            return $this -> connection -> query($query);
        }
    }
//    spl_autoload_register(function ($class) {
//        require "";
//    });