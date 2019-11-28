<?php

namespace someApp\math;

use PHPUnit\Framework\TestCase;

/**
 * Test Math Class
 */
class MathTest extends TestCase
{
    
    private $mathObject;
    
    protected function setUp():void
    {
        $this->mathObject = new MathCalculator();
    }
    
    /**
     * @dataProvider provideMockNumbers
     */
    public function testConverDecimalToBinary($number, $expected):void
    {
        $this->assertEquals($expected, $this->mathObject->convertDecimalToBin($number));
    }

    /**
     * Mock method - data provider for bin
     *
     * @return void
     */
    public function provideMockNumbers():array
    {
        return [
            ['220', '11011100'],
            ['10', '1010'],
            ['1245', '10011011101'],
            ['245435','111011111010111011']
        ];
    }

    /**
     * @dataProvider provideMockNumbersFibo
     */
    public function testFiboNumberAtGivenPositionN($position, $expected):void
    {
        $this->assertEquals($expected, $this->mathObject->getNFiboNumber($position));
    }

    /**
     * Mock method - data provider for fibo
     *
     * @return void
     */
    public function provideMockNumbersFibo():array
    {
        return [
            ['1', '1'],
            ['10', '55'],
            ['24', '46368'],
            ['245','7.120112555698187E+50']
        ];
    }
}
