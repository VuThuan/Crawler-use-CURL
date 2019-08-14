<?php

use lib\Curl;
use PHPUnit\Framework\TestCase;

class CurlTest extends TestCase
{
    public function urlProvider()
    {
        return [
            'url of Vnexpress' => [' https://vnexpress.net/the-gioi/philippines-giai-thich-phat-ngon-cua-duterte-ve-chu-quyen-cua-trung-quoc-o-bien-dong-3958060.html'],
            'url of VietNamnet' => ['https://vietnamnet.vn/vn/thoi-su/an-toan-giao-thong/ong-vu-anh-cuong-nu-hanh-khach-di-cung-chong-sao-toi-dam-sam-so-554133.html '],
        ];
    }

    /**
     * @dataProvider urlProvider
     */
    public function testDataHasReturnsOfUrl($url)
    {
        $curl = new Curl();

        $this->assertArrayHasKey('body', $curl->httpRequest($url));
    }
}
