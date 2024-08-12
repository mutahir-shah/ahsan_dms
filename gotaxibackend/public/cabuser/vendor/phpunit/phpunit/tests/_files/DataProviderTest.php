<?php

class DataProviderTest extends PHPUnit_Framework_TestCase
{
    public static function providerMethod()
    {
        return [
            [0, 0, 0],
            [0, 1, 1],
            [1, 1, 3],
            [1, 0, 1]
        ];
    }

    /**
     * @dataProvider providerMethod
     */
    public function testAdd($a, $b, $c)
    {
        $this->assertEquals($c, $a + $b);
    }
}
