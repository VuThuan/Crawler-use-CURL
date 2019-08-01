<?php
require_once "./System/core/Database.php";
require_once "./Site/AbstractCrawler.php";
require_once "./Site/Crawlers/Vnexpress.php";
require_once "./Site/Crawlers/Vietnamnet.php";
require_once "./Site/Crawlers/Dantri.php";
require_once "./System/library/Curl.php";
require_once "./System/core/Crawler.php";

//define database
$mysql_host = 'localhost';
$mysql_username = 'root';
$mysql_password = '';
$mysql_database = 'phpCrawler';
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
        $mysql_conn = new Database($mysql_host, $mysql_username, $mysql_password, $mysql_database);
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