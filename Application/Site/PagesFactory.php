<?php

class PagesFactory
{
    public $html;

    function makeWebsite(string $param)
    {
        require APP . "/Site/PageCrawler/Vnexpress.php";
        require APP . "/Site/PageCrawler/Vietnamnet.php";
        require APP . "/Site/PageCrawler/Dantri.php";

        switch (strtolower($param)) {
            case 'vnexpress':
                return new Vnexpress($this->html);
                break;
            case 'vietnamnet':
                return new Vietnamnet($this->html);
                break;
            case 'dantri':
                return new Dantri($this->html);
                break;
            default:
                return null;
                break;
        }
    }
}
