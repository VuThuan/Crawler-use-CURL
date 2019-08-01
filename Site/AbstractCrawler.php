<?php

abstract class AbstractCrawler
{
    private $html;
    private $connectDB;
    private $host;
    private $path;

    abstract public function getTitle();
    abstract public function getDate();
    abstract public function getContent();
    abstract public function getImage();
    abstract public function doActionforWebsite();
}
