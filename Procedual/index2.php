<?php
require_once "./function.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crawler</title>
    <style>
        select {
            width: 200px;
            height: 30px;
            font-size: 15px;
            outline: none;
        }

        button {
            height: 30px;
            background: orange;
            color: white;
            box-shadow: 3px 2px #00000026;
            font-weight: bold;
            border: none;
            outline: none;
            cursor: pointer;
        }

        button:hover {
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
    </style>
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
        CrawlerAndSeparateData($urlPages);
    }
    ?>
</body>

</html>