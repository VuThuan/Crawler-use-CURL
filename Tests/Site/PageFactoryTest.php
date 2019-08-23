<?php

use PHPUnit\Framework\TestCase;
use Site\PagesFactory;

class PageFactoryTest extends TestCase
{
    public function webProvider()
    {
        return [
            ['vnexpress'],
            ['dantri'],
            ['vietnamnet']
        ];
    }

    /**
     * @dataProvider webProvider
     */
    public function testFactoryHasReturnsObject($web)
    {
        $page = new PagesFactory;

        $this->assertIsObject($page->makeWebsite($web));

        $this->assertNull($page->makeWebsite('sdasds'));
    }
}
