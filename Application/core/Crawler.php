<?php

class Crawler
{
    private $curl;
    private $database;
    private $allWebPages;

    function __construct(Curl $curl, Database $databases, $webPages)
    {
        $this->curl = $curl;
        $this->database = $databases;
        $this->allWebPages = $webPages;
    }

    //We parse the URL and download if the status is 200, then we set the value and get the data, insert to database
    function parsePage($url)
    {
        $mysql_conn = $this->database->mysqlConnect();

        $url_components = parse_url($url);
        if ($url_components === false) {
            die('Unable to Parse URL');
        }
        $url_host = $url_components['host'];
        $url_path = '';
        if (array_key_exists('path', $url_components) == false) {
            $query = "INSERT INTO pages (path) VALUES (\"" . mysqli_real_escape_string($mysql_conn, $url) . "\")";
            if (!mysqli_query($mysql_conn, $query)) {
                die("Error: Unable to perform Download Time Update Query (path)\n");
            }
            return false;
        } else {
            $url_path = $url_components['path'];
        }
        //Download Page
        $contents = $this->curl->httpRequest($url);

        if ($contents['headers']['status_info'][1] != 200) {
            $query = "INSERT INTO pages (path) VALUES (\"" . mysqli_real_escape_string($mysql_conn, $url_path) . "\")";
            if (!mysqli_query($mysql_conn, $query)) {
                die("Error: Unable to perform Update Query (http status)\n");
            }
            return false;
        }

        $pages = $this->allWebPages;
        foreach ($pages as $key => $page) {
            if (preg_match("/$key/", $url_host)) {
                $page->html = $contents['body'];
                $page->connectDB = $mysql_conn;
                $page->host = $url_host;
                $page->path = $url_path;

                $page->saveData();
            }
        }

        return true;
    }
}
