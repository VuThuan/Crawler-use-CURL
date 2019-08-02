<?php
require_once "./Application/lib/Database.php";
require_once "./Application/config/config.php";
require_once "./Application/Site/Functions/FunctionGetData.php";
require_once "./Application/Site/AbstractCrawler.php";
require_once "./Application/Site/Crawlers/Vnexpress.php";
require_once "./Application/Site/Crawlers/Vietnamnet.php";
require_once "./Application/Site/Crawlers/Dantri.php";
require_once "./Application/core/Curl.php";
require_once "./Application/core/Crawler.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crawler</title>
    <link rel="stylesheet" type="text/css" href="public/css/style.css" />
</head>

<body>
    <form method="POST" action="">
        <h2>PHP Crawler Web Base</h2>
        <input type="text" value="" placeholder="Please enter the website URL" name="urlPages">
        <button type="submit" name="submit">Crawler</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $urlPages = $_POST['urlPages'];
        if (empty($urlPages)) {
            die("Error: Please Enter the Website URL<br> ");
        }
        $mysql_conn = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if (!$mysql_conn->isConnectDatabase()) return;

        $curl = new Curl();
        $rows = array(
            "vnexpress" => new VnexpressCrawler(),
            "vietnamnet" => new VietnamnetCrawler(),
            "dantri" => new DantriCrawler()
        );

        (new Crawler($curl, $mysql_conn, $rows))->parsePage($urlPages);
    }
    ?>
</body>

</html>