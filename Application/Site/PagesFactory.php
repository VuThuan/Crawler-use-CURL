<?php

abstract class PagesFactory
{
    public $html;
    public $connectDB;
    public $host;
    public $path;

    abstract function creatWebsite(): InterfaceGetData;

    public function takeDataForWebsite()
    {
        $page = $this->creatWebsite();

        $url_host = $this->host;
        $url_path = $this->path;
        $title = $page->getTitle();
        $content = $page->getContent();
        $date = $page->getDate();
        $image = $page->getImage();

        // Insert/Update Page Data
        $query = "INSERT IGNORE INTO pages (path, host, title, image, content, download_time) VALUES (\"" . mysqli_real_escape_string($this->connectDB, $url_path) . "\", \"$url_host \", \"" . mysqli_real_escape_string($this->connectDB, $title) . "\", \"$image\", \"" . mysqli_real_escape_string($this->connectDB, $content) . "\",  \"" . mysqli_real_escape_string($this->connectDB, $date) . "\")";
        if (!mysqli_query($this->connectDB, $query)) {
            die("<br>Error: Unable to perform Insert Query<br>");
        }

        return '<h2> ' . $title . '</h2> ' . $date . ' <br><img src=' . $image . '><br>' . $content;
    }
}
