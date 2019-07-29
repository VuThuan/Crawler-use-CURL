<?php

abstract class AbstractCrawler
{
    private $domDocument;
    private $connectDB;
    private $host;
    private $path;

    public function setDomDocument($doc)
    {
        $this->domDocument = $doc;
    }
    public function setConnect($mysql_conn)
    {
        $this->connectDB = $mysql_conn;
    }
    public function setUrlHost($url_host)
    {
        $this->host = $url_host;
    }
    public function setUrlPath($url_path)
    {
        $this->path = $url_path;
    }
    abstract public function getTitle();
    abstract public function getDate();
    abstract public function getContent();
    abstract public function getImage();
    abstract public function doAction();
}
