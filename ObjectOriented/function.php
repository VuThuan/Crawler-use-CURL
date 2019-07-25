<?php

function isConnectDatabase(&$mysql_conn)
{
    if (!$mysql_conn) {
        echo "Error: Unable to connect to MySQL" . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        return false;
    }
    return true;
}
