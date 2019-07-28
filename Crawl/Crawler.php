<?php

require_once "InterfaceCrawler.php";

class Crawler extends Vnexpress
{
    private $curl;

    function __construct(Curl $curl)
    {
        $this->curl = $curl;
    }

    function parsePage($target)
    {
        $mysql_conn = $this->curl->getConnectDatabase();
        //Parse URL and get Components
        $url_components = parse_url($target);
        if ($url_components === false) {
            die('Unable to Parse URL');
        }
        $url_host = $url_components['host'];
        $url_path = '';
        if (array_key_exists('path', $url_components) == false) {
            //If not a valid path, mark as done
            $query = "INSERT INTO pages (path, download_time) VALUES (\"" . mysqli_real_escape_string($mysql_conn, $target) . "\" ,NOW()) ON DUPLICATE KEY UPDATE download_time=NOW()";
            if (!mysqli_query($mysql_conn, $query)) {
                die("Error: Unable to perform Download Time Update Query (path)\n");
            }
            return false;
        } else {
            $url_path = $url_components['path'];
        }
        //Download Page
        echo "Downloading: $target\n";
        $contents = $this->curl->httpRequest($target);
        echo "Done<br>";
        //Check Status
        if ($contents['headers']['status_info'][1] != 200) {
            //If not ok, mark as downloaded but skip
            $query = "INSERT INTO pages (path, download_time) VALUES (\"" . mysqli_real_escape_string($mysql_conn, $url_path) . "\", NOW()) ON DUPLICATE KEY UPDATE download_time=NOW()";
            if (!mysqli_query($mysql_conn, $query)) {
                die("Error: Unable to perform Download Time Update Query (http status)\n");
            }
            return false;
        }
        $this->parseContentBody($contents, $url_path, $url_host, $mysql_conn);
        return true;
    }

    function parseContentBody($contents, $url_path, $url_host, $mysql_conn)
    {
        //Parse Contents
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML('<?xml encoding="utf-8" ?>' . $contents['body']);
        //Get title
        // $title = '';
        // $titleTags = $doc->getElementsByTagName('title');
        // if (count($titleTags) > 0) {
        //     $title = mysqli_real_escape_string($mysql_conn, $titleTags[0]->nodeValue);
        // }
        $this->domDocument = $doc;
        $this->connectDB = $mysql_conn;
        $title = $this->getTitle();

        //get Content Vnexpress
        // $content = '';
        // $articleTag = $doc->getElementsByTagName('article');
        // if (count($articleTag) > 0) {
        //     $content = mysqli_real_escape_string($mysql_conn, $articleTag[0]->nodeValue);
        // }
        // $contentText = str_replace('\n', '<br>', $content);
        $contentText = $this->getContent();

        //====================get Content Vietnamnet
        // $content = '';
        // $articleTag = $doc->getElementById('ArticleContent');
        // $content = mysqli_real_escape_string($mysql_conn, $articleTag->nodeValue);
        // $contentText = str_replace('\n', '<br>', $content);

        //====================Dan Tri
        // $content = '';
        // $articleTag = $doc->getElementById('ctl00_IDContent_Tin_Chi_Tiet');
        // $content = mysqli_real_escape_string($mysql_conn, $articleTag->nodeValue);
        // $contentText = str_replace('\n', '<br>', $content);

        //=====================get Images Vnexpress
        $image = '';
        $metaTags = $doc->getElementsByTagName('meta');
        foreach ($metaTags as $tag) {
            if ($tag->getAttribute('name') == 'twitter:image') {
                $image = mysqli_real_escape_string($mysql_conn, $tag->getAttribute('content'));
            }
        }

        //get Image VietNamnet
        // tuong tu vnexpress

        //get Date
        $date = '';
        $headerTag = $doc->getElementsByTagName('header');
        if (count($headerTag) > 0) {
            $date = mysqli_real_escape_string($mysql_conn, $headerTag[2]->nodeValue);
        }
        $dateText = str_replace('\n', '<br>', $date);

        echo  '<br><img src="' . $image . '" />> <br><h2>' . $title . '</h2><br>' . $dateText;
        echo $contentText;

        //Insert/Update Page Data
        // $query = "INSERT IGNORE INTO pages (path, host, title, image, content, download_time) VALUES (\"" . mysqli_real_escape_string($mysql_conn, $url_path) . "\", \"$url_host \", \"$title\", \"$image\", \"$contentText\",  \"$dateText\") ON DUPLICATE KEY UPDATE host=\"$url_host \", title=\"$title\",image=\"$image\", content=\"$contentText\",  download_time=\"$dateText\"";
        // if (!mysqli_query($mysql_conn, $query)) {
        //     die("<br>Error: Unable to perform Insert Query\n");
        // }
    }
}
