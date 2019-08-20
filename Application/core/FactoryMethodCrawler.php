<?php

namespace core;

use Site\PagesFactory;

class FactoryMethodCrawler
{
    private $dataPage;

    public function __construct($dataPage, PagesFactory $page)
    {
        $this->dataPage = $dataPage;
        $this->page = $page;
    }

    function getFactory()
    {
        $keyPage = array(
            'vnexpress', 'vietnamnet', 'dantri'
        );

        foreach ($keyPage as $param) {
            if (preg_match("/$param/", $this->dataPage['host'])) {
                $this->getDataForWebsite($this->dataPage, $this->page, $param);
                return true;
            }
        }
    }

    function getDataForWebsite($dataPage, $page, string $keyPage)
    {
        $page->html = $dataPage['html'];
        $website = $page->makeWebsite($keyPage);

        $title = $website->getTitle();
        $date = $website->getDate();
        $image =  $website->getImage();
        $content = $website->getContent();
        echo '<h2> ' . $title . '</h2> ' . $date . ' <br><img src=' . $image . '><br>' . $content;

        // Insert/Update Page Data
        $query = "INSERT IGNORE INTO pages (path, host, title, image, content, download_time) VALUES (\"" . mysqli_real_escape_string($dataPage['connectDB'], $dataPage['path']) . "\",\"" . mysqli_real_escape_string($dataPage['connectDB'], $dataPage['host']) . "\" , \"" . mysqli_real_escape_string($dataPage['connectDB'], $title) . "\", \"$image\", \"" . mysqli_real_escape_string($dataPage['connectDB'], $content) . "\",  \"" . mysqli_real_escape_string($dataPage['connectDB'], $date) . "\")";
        if (!mysqli_query($dataPage['connectDB'], $query)) {
            die("<br>Error: Unable to perform Insert Query<br>");
        }
    }
}
