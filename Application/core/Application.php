<?php

namespace core;

use lib\Crawler;
use lib\Curl;
use Controllers\HomeController;
use Controllers\FactoryController;
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

            $curl = new Curl();
            $crawler = new Crawler($curl);
            $dataParse = $crawler->parsePage($urlPages);

            $factory = new PagesFactory();
            $factoryController = new FactoryController();

            $data = $factoryController->getFactory($dataParse, $factory);
            $factoryController->addToTheDatabase($data);
        }
    }
}
