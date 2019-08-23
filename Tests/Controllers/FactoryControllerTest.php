<?php

use Controllers\FactoryController;
use model\Model;
use PHPUnit\Framework\TestCase;
use Site\PagesFactory;

class FactoryControllerTest extends TestCase
{

    public function dataPageProvider()
    {
        return [
            ['Dantri', 'abd-ds/sdas1-dsads.html']
        ];
    }

    /**
     * @dataProvider dataPageProvider
     */
    public function testDataOfFactoryHasReturned(string $host, string $path)
    {
        $dataPage = [
            'host' => $host,
            'path' => $path,
            'html' => file_get_contents('Tests/Text/' . $host . 'Text.txt')
        ];

        $page = $this->createMock(PagesFactory::class);

        $mock = $this->getMockBuilder(FactoryController::class)
            ->setMethods(['getFactory', 'addToTheDatabase'])
            ->getMock();

        $mock->method('getFactory')->willReturn(true);

        $result = $mock->getFactory($dataPage, $page);

        $this->assertTrue($result);
    }
}
