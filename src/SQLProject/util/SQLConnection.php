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
        private mysqli_sql_exception | null $exception;

        private bool $connected = false;

        public function __construct(string $server, string $username, string $password) {
            $this -> server = $server;
            $this -> username = $username;
            $this -> password = $password;
        }

        public function connect() : SQLConnection {
            try {
                $this -> connection = new mysqli(SERVER, USERNAME, PASSWORD);
                $this->connected = true;
            } catch (mysqli_sql_exception $exception) {
                $this -> exception = $exception;
            }

            return $this;
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

        public function insert(string $table, string ...$args) : bool {
            if (!isset($this -> connection))
                return false;

            if (count($args) == 0)
                return false;

            $cols = [];
            $vars = [];

            foreach ($args as $k=>$v) {
                if (is_string($k))
                    $cols[] = $k;

                $vars[] = $v;
            }

            $cols_size = count($cols);
            $vars_size = count($vars);

            if ($cols_size > 0 && $cols_size != $vars_size)
                return false;

            // Preset the arrays
            $str_vars = $this->wrap_var($vars[0]);

            if ($cols_size > 0)
                $str_cols = '(' . $cols[0];
            else
                $str_cols = '';

            // Convert arrays into strings
            for ($i = 1; $i < $vars_size; $i++) {
                if ($cols_size > 0)
                    $str_cols .= ', ' . $cols[$i];

                $str_vars .= ', ' . $this->wrap_var($vars[$i]);
            }

            if ($cols_size > 0)
                $str_cols .= ') ';

            try {
                $this -> connection -> query("INSERT INTO $table VALUES $str_cols ($str_vars)");
            } catch (mysqli_sql_exception $exception) {
                $this -> exception = $exception;
                return false;
            }

            return true;
        }

        public function getException() : mysqli_sql_exception {
            $exception = $this->exception;
            $this->exception = null;
            return $exception;
        }

        private function wrap_var($var) : string {
            if (is_numeric($var))
                return $var;
            else
                return "'$var'";
        }
    }
//    spl_autoload_register(function ($class) {
//        require "";
//    });