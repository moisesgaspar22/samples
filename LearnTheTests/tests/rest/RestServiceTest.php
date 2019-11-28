<?php

namespace someApp\rest;

use PHPUnit\Framework\TestCase;

class RestServiceTest extends TestCase
{
    
    private $serviceObject;
    
    protected function setUp():void
    {
        $this->serviceObject = new RestService();
    }
    
    public function testCheckIfServiceCallReturnValuesAsArrays():void
    {
        $result = $this->serviceObject->request('', true);
        $this->assertIsArray($result);
    }
    
    
    public function testCheckIfServiceCallReturnValuesAsObjects():void
    {
        $result = $this->serviceObject->request();
        $this->assertInstanceOf('stdClass', $result);
        $this->assertObjectHasAttribute('hello', $result);
        $this->assertTrue($result->hello == 'world');
    }

    public function testCheckIfServiceCallReturnsTheCorrectDataStructure():void
    {
        $this->serviceObject->setUrl('http://www.mocky.io/v2/5d851248300000dde822dcfc');
        $result = $this->serviceObject->request();
        $this->assertInstanceOf('stdClass', $result);
        $this->assertObjectHasAttribute('response', $result);
        $this->assertObjectHasAttribute('data', $result);
        //$this->assertTrue($result->hello == 'world');
    }

    /**
     * @dataProvider provideMockEndpointData
     *
     * @return void
     */
    public function testCheckIfServiceCallReturnsTheCorrectDataStructureFromDiferentEndpoints($endpoint, $expected):void
    {
        $result = $this->serviceObject->request($endpoint);
        $this->assertTrue($result == json_decode($expected));
    }

    public function provideMockEndpointData()
    {
        return [
            [
                'http://www.mocky.io/v2/5d851248300000dde822dcfc',
                $data = <<<JSON
                { 
                "response":"200",
                "data":{
                    "hello": "world"
                    } 
                }
JSON
            ],
            [
                'http://www.mocky.io/v2/5d85150130000069eb22dd03',
                $data = <<<JSON
                {
                    "response": "200",
                    "data": {
                        "id": 40,
                        "name": "some",
                        "like": "food",
                        "interest": [
                            "food",
                            "cinema"
                        ]
                    }
                }
JSON
            ],
            [
                'http://www.mocky.io/v2/5d85172d300000dde822dd0b',
                $data = $this->getMockData('complex.json')
            ]
        ];
    }

    private function getMockData($fileName)
    {
        return file_get_contents(\dirname(__FILE__)."/../data/$fileName");
    }
}
