<?php

class Databases
{
    private $mysql_host;
    private $mysql_username;
    private $mysql_password;
    private $mysql_database;

    function __construct($mysql_host, $mysql_username, $mysql_password, $mysql_database)
    {
        $this->mysql_host = $mysql_host;
        $this->mysql_username = $mysql_username;
        $this->mysql_password = $mysql_password;
        $this->mysql_database = $mysql_database;
    }

    function mysqlConnect()
    {
        return mysqli_connect($this->mysql_host, $this->mysql_username, $this->mysql_password, $this->mysql_database);
    }

    function isConnectDatabase()
    {
        if (!$this->mysqlConnect()) {
            echo "Error: Unable to connect to MySQL" . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            return false;
        }
        return true;
    }
}
