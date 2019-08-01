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
    public function doActionRetriveData()
    {
        $url_host = $this->host;
        $url_path = mysqli_real_escape_string($this->connectDB, $this->path);
        $title = mysqli_real_escape_string($this->connectDB, $this->getTitle());
        $date = mysqli_real_escape_string($this->connectDB, $this->getDate());
        $image = $this->getImage();
        $content = mysqli_real_escape_string($this->connectDB, $this->getContent());

        echo '<h2> ' . $title . '</h2> ' . $date . ' <br><img src=' . $image . '><br>' . $content;

        // Insert/Update Page Data
        $query = "INSERT IGNORE INTO pages (path, host, title, image, content, download_time) VALUES (\"$url_path\", \"$url_host \", \"$title\", \"$image\", \"$content\",  \"$date\")";
        if (!mysqli_query($this->connectDB, $query)) {
            die("<br>Error: Unable to perform Insert Query<br>");
        }
    }
}
