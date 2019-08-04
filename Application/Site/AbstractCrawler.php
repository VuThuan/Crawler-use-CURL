<?php

abstract class AbstractCrawler
{
    private $html;
    public $connectDB;
    public $host;
    public $path;

    abstract public function getTitle();
    abstract public function getDate();
    abstract public function getContent();
    abstract public function getImage();

    public function saveData()
    {
        $url_host = $this->host;
        $url_path = $this->path;
        $title = $this->getTitle();
        $date = $this->getDate();
        $image = $this->getImage();
        $content = $this->getContent();

        echo '<h2> ' . $title . '</h2> ' . $date . ' <br><img src=' . $image . '><br>' . $content;

        // Insert/Update Page Data
        $query = "INSERT IGNORE INTO pages (path, host, title, image, content, download_time) VALUES (\"" . mysqli_real_escape_string($this->connectDB, $url_path) . "\", \"$url_host \", \"" . mysqli_real_escape_string($this->connectDB, $title) . "\", \"$image\", \"" . mysqli_real_escape_string($this->connectDB, $content) . "\",  \"" . mysqli_real_escape_string($this->connectDB, $date) . "\")";
        if (!mysqli_query($this->connectDB, $query)) {
            die("<br>Error: Unable to perform Insert Query<br>");
        }
    }
}
