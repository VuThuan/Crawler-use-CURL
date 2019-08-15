<?php

use PHPUnit\Framework\TestCase;
use lib\Crawler;
use lib\Curl;
use lib\Database;

class CrawlerTest extends TestCase
{
    protected $curl;
    protected $database;
    protected $crawler;

    public function setUp(): void
    {
        $this->curl = new Curl;
        $this->database = new Database('localhost', 'root', '', 'phpCrawler');
        $this->crawler = new Crawler($this->curl, $this->database);
    }

    public function urlProvider()
    {
        return [
            'url of Vnexpress' => [' https://vnexpress.net/the-gioi/philippines-giai-thich-phat-ngon-cua-duterte-ve-chu-quyen-cua-trung-quoc-o-bien-dong-3958060.html'],
            'url of VietNamnet' => ['https://vietnamnet.vn/vn/thoi-su/an-toan-giao-thong/ong-vu-anh-cuong-nu-hanh-khach-di-cung-chong-sao-toi-dam-sam-so-554133.html'],
        ];
    }

    /**
     * @dataProvider urlProvider
     */
    public function testCrawlerHasReturnedKeyOfArray($url)
    {
        $this->assertArrayHasKey('path', $this->crawler->parsePage($url));
    }
}
