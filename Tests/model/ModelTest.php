<?php

use model\Model;
use PHPUnit\Framework\TestCase;

class ModelTest extends TestCase
{
    public function testDataHasSaveToTheDatabase()
    {
        $model = $this->getMockBuilder(Model::class)
            ->setConstructorArgs([true])
            ->setMethods(['addPage'])
            ->getMock();

        $model->method('addPage')->willReturn(true);

        $result = $model->addPage('vnexpress', '12.12/1', 'title', 'content', 'image', 'date');

        $this->assertTrue($result);
    }
}
