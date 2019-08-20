<?php

namespace core;

use lib\Crawler;
use lib\Curl;
use lib\Database;
use Controllers\HomeController;
use core\FactoryMethodCrawler;
use Site\PagesFactory;

class Application
{
    public function __construct()
    {
        //Show Index
        $page = new HomeController();
        $page->index();

        $this->getData();
    }

    public function getData()
    {
        if (isset($_POST['submit'])) {
            $urlPages = $_POST['urlPages'];
            if (empty($urlPages)) {
                die("Error: Please Enter the Website URL<br> ");
            }
            if (!filter_var($urlPages, FILTER_VALIDATE_URL)) {
                die("Url not fount");
            }
            $mysql_conn = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if (!$mysql_conn->isConnectDatabase()) return;

            $curl = new Curl();
            $crawler = new Crawler($curl, $mysql_conn);
            $dataParse = $crawler->parsePage($urlPages);

            $factory = new PagesFactory();
            $factoryCrawler = new FactoryMethodCrawler($dataParse, $factory);

            $factoryCrawler->getFactory();
        }
    }
}
