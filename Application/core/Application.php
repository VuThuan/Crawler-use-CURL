<?php
class Application
{
    public function __construct()
    {
        require_once APP . "/lib/Database.php";
        require_once APP . "/lib/Curl.php";
        require_once APP . "/lib/Crawler.php";
        require_once APP . "/Site/InterfaceGetData.php";
        require_once APP . "/Site/PagesFactory.php";
        require_once APP . "/core/FactoryMethodCrawler.php";

        //Show Index
        require_once APP . "/Controllers/HomeController.php";
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
