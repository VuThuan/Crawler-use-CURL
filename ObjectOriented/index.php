<?php

require_once "./databases.php";
require_once "./CURL.php";
require_once "./Crawler.php";
require_once "./function.php";

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
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>
    <form method="POST" action="">
        <h2>PHP Crawler Web Base</h2>
        <!-- <input type="text" value="" placeholder="Please enter the website URL" name="urlPages"> -->
        <select name="urlPages">
            <option value="https://vnexpress.net/">Vnexpress</option>
            <option value="https://dantri.com.vn/">Dân Chí</option>
            <option value="https://vietnamnet.vn/">VietNamnet</option>
        </select>
        <button type="submit" name="submit">Crawler</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $urlPages = $_POST['urlPages'];
        $sql = new Databases($mysql_host, $mysql_username, $mysql_password, $mysql_database);
        if (!$sql->isConnectDatabase()) return;

        $curl = new CURL($sql);
        (new Crawler($curl))->CrawlerAndSeparateData($urlPages);
    }
    ?>
</body>

</html>