<?php

// use Site\Functions\MatchesData;
use PHPUnit\Framework\TestCase;
use Site\PageCrawler\Dantri;
use Site\PageCrawler\Vietnamnet;
use Site\PageCrawler\Vnexpress;

class InterfaceDataTest extends TestCase
{
    public function vnexpressProvider()
    {
        return [
            "Vnexpress" => [new Vnexpress(file_get_contents('Tests/Text/VnexText.txt'))],
        ];
    }

    public function vietnamnetProvider()
    {
        return [
            "vietnamnet" => [new Vietnamnet(file_get_contents('Tests/Text/VietnamnetText.txt'))],
        ];
    }

    public function dantriProvider()
    {
        return [
            "dantri" => [new Dantri(file_get_contents('Tests/Text/DantriText.txt'))]
        ];
    }
    /**
     * @dataProvider vnexpressProvider
     */
    public function testDataVnexpressIsReturned($page)
    {

        $this->assertEquals("Xin chao moi nguoi", $page->getTitle());

        $this->assertEquals('Hello', $page->getContent());

        $this->assertEquals("15/8/2019", $page->getDate());

        $this->assertEquals("vnexpress.jpg", $page->getImage());
    }

    /**
     * @dataProvider vietnamnetProvider
     */
    public function testDataVietNamnetIsReturned($page)
    {
        $this->assertEquals("Xin chao moi nguoi", $page->getTitle());

        $this->assertEquals('<p class="time-zone">15/8/2019 </p>', $page->getDate());

        $this->assertEquals("vietnamnet.jpg", $page->getImage());
    }

    /**
     * @dataProvider dantriProvider
     */
    public function testDataDantriIsReturned($page)
    {
        $this->assertEquals("Xin chao moi nguoi", $page->getTitle());

        $this->assertEquals('18/3/3333', $page->getDate());

        $this->assertEquals("dantri.jpg", $page->getImage());
    }
}
