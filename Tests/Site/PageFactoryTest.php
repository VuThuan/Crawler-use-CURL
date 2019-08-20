<?php

use PHPUnit\Framework\TestCase;
use Site\PagesFactory;

class PageFactoryTest extends TestCase
{
    public function testFactoryHasReturnsObject()
    {
        $page = $this->getMockBuilder(PagesFactory::class)
            ->setMethods(['makeWebsite'])
            ->getMock();

        $page->method('makeWebsite')
            ->withConsecutive(
                [$this->equalTo('vnexpress')],
                [$this->equalTo('vietnamnet')],
                [$this->equalTo('dantri')]
            )
            ->will($this->returnSelf());

        $this->assertIsObject($page->makeWebsite('vnexpress'));
    }
}
