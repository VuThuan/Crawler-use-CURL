<?php

use PHPUnit\Framework\TestCase;
use Site\Functions\MatchesData;

class MatchesDataTest extends TestCase
{

    protected $match;

    public function setUp(): void
    {
        $this->match = new MatchesData;
    }

    public function dataImageProvider()
    {
        return [
            ['/<img src=\"(.*?)\" >/', '<img src="Xin chao" >']
        ];
    }

    public function dataDateProvider()
    {
        return [
            ['/<p class=\"date\">(.*?)<\/p>/', 1, '<p class="date">10/2/2019</p>']
        ];
    }

    /**
     * @dataProvider dataImageProvider
     */
    public function testDataMatchesHasReturned($regex, $html)
    {
        $this->assertEquals('Xin chao', $this->match->matchesImage($regex, $html));
    }

    /**
     * @dataProvider dataDateProvider
     */
    public function testDataOfDateHasReturned($regex, $key, $html)
    {
        $this->assertEquals('10/2/2019', $this->match->matchesDate($regex, $key, $html));
    }
}
