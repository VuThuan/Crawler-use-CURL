<?php

function createFactory($dataPage, PagesFactory $page) //$rows
{
    // foreach ($rows as $key => $page) {
    //     if (preg_match("/$key/", $dataPage['host'])) {
    //         getDataForWebsite($dataPage, $page);
    //     }
    // }
    switch (true) {
        case preg_match("/vnexpress/", $dataPage['host']):
            getDataForWebsite($dataPage, $page);
            break;
        case preg_match("/vietnamnet/", $dataPage['host']):
            getDataForWebsite($dataPage, $page);
            break;
        case preg_match("/dantri/", $dataPage['host']):
            getDataForWebsite($dataPage, $page);
            break;
        default:
            echo "URL Khong hop le<br>";
            break;
    }
}

function getDataForWebsite($dataPage, $page)
{
    $page->html = $dataPage['html'];
    $website = $page->creatWebsite();
    $title = $website->getTitle();
    $date = $website->getContent();
    $image =  $website->getImage();
    $content = $website->getDate();
    echo '<h2> ' . $title . '</h2> ' . $date . ' <br><img src=' . $image . '><br>' . $content;

    // Insert/Update Page Data
    $query = "INSERT IGNORE INTO pages (path, host, title, image, content, download_time) VALUES (\"" . mysqli_real_escape_string($dataPage['connectDB'], $dataPage['path']) . "\",\"" . mysqli_real_escape_string($dataPage['connectDB'], $dataPage['host']) . "\" , \"" . mysqli_real_escape_string($dataPage['connectDB'], $title) . "\", \"$image\", \"" . mysqli_real_escape_string($dataPage['connectDB'], $content) . "\",  \"" . mysqli_real_escape_string($dataPage['connectDB'], $date) . "\")";
    if (!mysqli_query($dataPage['connectDB'], $query)) {
        die("<br>Error: Unable to perform Insert Query<br>");
    }
}
