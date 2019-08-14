<?php

use lib\Database;
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    public function testDatabaseIsConnectAndReturnsTrue()
    {
        $database = new Database('localhost', 'root', '', 'phpCrawler');

        $this->assertTrue($database->isConnectDatabase());
    }
}
