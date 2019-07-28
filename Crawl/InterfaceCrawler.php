<?php

class Vnexpress
{

    protected $domDocument;
    protected $connectDB;

    public function setDomDocument($doc)
    {
        $this->domDocument = $doc;
    }

    public function setConnect($mysql_conn)
    {
        $this->connectDB = $mysql_conn;
    }

    public function getTitle()
    {
        $title = '';
        $titleTags = $this->domDocument->getElementsByTagName('title');
        if (count($titleTags) > 0) {
            $title = mysqli_real_escape_string($this->connectDB, $titleTags[0]->nodeValue);
        }
        return $title;
    }
    public function getDate()
    {
        $date = '';
        $headerTag = $this->domDocument->getElementsByTagName('header');
        if (count($headerTag) > 0) {
            $date = mysqli_real_escape_string($this->connectDB, $headerTag[2]->nodeValue);
        }
        $dateText = str_replace('\n', '<br>', $date);
        return $dateText;
    }
    public function getContent()
    {
        $content = '';
        $articleTag = $this->domDocument->getElementsByTagName('article');
        if (count($articleTag) > 0) {
            $content = mysqli_real_escape_string($this->connectDB, $articleTag[0]->nodeValue);
        }
        $contentText = str_replace('\n', '<br>', $content);
        return $contentText;
    }
    public function getImage()
    {
        $image = '';
        $metaTags = $this->domDocument->getElementsByTagName('meta');
        foreach ($metaTags as $tag) {
            if ($tag->getAttribute('name') == 'twitter:image') {
                $image = mysqli_real_escape_string($this->connectDB, $tag->getAttribute('content'));
            }
        }
        return $image;
    }

    public function doAction()
    {
        $this->getTitle();
        $this->getDate();
        $this->getImage();
        $this->getContent();
    }
}
// class Vietnamnet extends Vnexpress implements InterfaceCrawler
// {
//     public function getDate()
//     { }
//     public function getContent()
//     { }
//     public function getImage()
//     { }
// }
// class Dantri implements InterfaceCrawler
// {
//     public function getTitle()
//     { }
//     public function getDate()
//     { }
//     public function getContent()
//     { }
//     public function getImage()
//     { }
// }

// class CrawlerWarler
// {

//     private $inteCrawler;

//     public function __construct(InterfaceCrawler $interfaceCrawler)
//     {
//         $this->inteCrawler = $interfaceCrawler;
//     }

//     public function parseContentBody($contents)
//     {
//         $this->domDocument = new DOMthis->domDocumentument();
//         libxml_use_internal_errors(true);
//         $this->domDocument->loadHTML('<?xml encoding="utf-8" ' . $contents['body']);
//     }
// }
