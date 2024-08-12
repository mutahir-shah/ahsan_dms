<?php

class DataProviderFilterTest extends PHPUnit_Framework_TestCase
{
    public static function truthProvider()
    {
        return [
            [true],
            [true],
            [true],
            [true]
        ];
    }

    public static function falseProvider()
    {
        return [
            'false test' => [false],
            'false test 2' => [false],
            'other false test' => [false],
            'other false test2' => [false]
        ];
    }

    /**
     * @dataProvider truthProvider
     */
    public function testTrue($truth)
    {
        $this->assertTrue($truth);
    }

    /**
     * @dataProvider falseProvider
     */
    public function testFalse($false)
    {
        $this->assertFalse($false);
    }
}
