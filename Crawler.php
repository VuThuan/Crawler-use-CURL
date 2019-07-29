<?php

class Crawler
{
    private $curl;
    private $database;

    function __construct(Curl $curl, Database $databases)
    {
        $this->curl = $curl;
        $this->database = $databases;
    }

    function getConnectDatabase()
    {
        return $this->database->mysqlConnect();
    }

    function parsePage($target)
    {
        $mysql_conn = $this->getConnectDatabase();
        //Parse URL and get Components
        $url_components = parse_url($target);
        if ($url_components === false) {
            die('Unable to Parse URL');
        }
        $url_host = $url_components['host'];
        $url_path = '';
        if (array_key_exists('path', $url_components) == false) {
            //If not a valid path, mark as done
            $query = "INSERT INTO pages (path, download_time) VALUES (\"" . mysqli_real_escape_string($mysql_conn, $target) . "\" ,NOW()) ON DUPLICATE KEY UPDATE download_time=NOW()";
            if (!mysqli_query($mysql_conn, $query)) {
                die("Error: Unable to perform Download Time Update Query (path)\n");
            }
            return false;
        } else {
            $url_path = $url_components['path'];
        }
        //Download Page
        // echo "Downloading: $target\n";
        $contents = $this->curl->httpRequest($target);
        // echo "Done<br>";
        //Check Status
        if ($contents['headers']['status_info'][1] != 200) {
            //If not ok, mark as downloaded but skip
            $query = "INSERT INTO pages (path, download_time) VALUES (\"" . mysqli_real_escape_string($mysql_conn, $url_path) . "\", NOW()) ON DUPLICATE KEY UPDATE download_time=NOW()";
            if (!mysqli_query($mysql_conn, $query)) {
                die("Error: Unable to perform Download Time Update Query (http status)\n");
            }
            return false;
        }


        //Parse Contents
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML('<?xml encoding="utf-8" ?>' . $contents['body']);
        //set Value
        if ($url_host == 'vnexpress.net') {
            $vnexpress = new Vnexpress();
            $vnexpress->domDocument = $doc;
            $vnexpress->connectDB = $mysql_conn;
            $vnexpress->host = $url_host;
            $vnexpress->path = $url_path;

            $vnexpress->doAction();
        } elseif ($url_host == 'dantri.com.vn') {
            $dantri = new Dantri();
            $dantri->domDocument = $doc;
            $dantri->connectDB = $mysql_conn;
            $dantri->host = $url_host;
            $dantri->path = $url_path;

            $dantri->doAction();
        } elseif ($url_host == 'vietnamnet.vn') {
            $vietnamnet = new Vietnamnet();
            $vietnamnet->domDocument = $doc;
            $vietnamnet->connectDB = $mysql_conn;
            $vietnamnet->host = $url_host;
            $vietnamnet->path = $url_path;

            $vietnamnet->doAction();
        } else {
            echo "URL not crawler";
        }


        return true;
    }
}
