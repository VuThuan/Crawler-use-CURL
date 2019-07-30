<?php
require_once "./Database.php";
require_once "./AbstractAllWebPage.php";
require_once "./WebPage/Vnexpress.php";
require_once "./WebPage/Vietnamnet.php";
require_once "./WebPage/Dantri.php";
require_once "./Curl.php";
require_once "./Crawler.php";

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
    <link rel="stylesheet" type="text/css" href="asset/css/style.css" />
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
        $arr = array(
            "vnexpress" => new Vnexpress(),
            "vietnamnet" => new Vietnamnet(),
            "dantri" => new Dantri()
        );

        (new Crawler($curl, $mysql_conn, $arr))->parsePage($urlPages);
    }
    ?>
</body>

</html>