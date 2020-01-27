<?php
namespace someApp\oop;

use PHPUnit\Framework\TestCase;

class OopTest extends TestCase
{
    
    public function testCheckInterfaceIntegrity()
    {
        // Build me a class from interface DbInterface
        $fromInterface = $this
                            ->getMockBuilder(DbInterface::class)
                            ->setMockClassName('fromInterface')
                            ->getMock();
        // Get me a reflection class from that mock class
        $resultClass   = new \ReflectionClass($fromInterface);

        // Check if this new instance has methods in the interface 
        $this->assertTrue($resultClass->hasMethod('getFromDb'));
        $this->assertTrue($resultClass->hasMethod('setToDb'));

        // Check the methods visibility
        $this->assertTrue($resultClass->getMethod('getFromDb')->isPublic());
        $this->assertTrue($resultClass->getMethod('setToDb')->isPublic());
    }
    
    public function testInstantiateNewDbappWithDbInstance()
    {
        $db = new Db('', '', '');
        $this->assertInstanceOf(DbInterface::class, $db);

        $dbApp = new DbApp($db);
        $this->assertInstanceOf(DbApp::class, $dbApp);
    }

    public function testGetDataFromDatabaseWithTheRightStructure()
    {
        $dbApp = new DbApp(new db('', '', ''));

        $this->assertTrue(is_array($dbApp->getSomeData('')));
    }

    public function testGetDataFromDatabaseWithMockData()
    {
        $mgApp = $this->getMockBuilder(DbInterface::class)->setMockClassName('mgApp')->getMock();

        $mgApp->expects($this->at(0))
            ->method('getfromdb')
            ->with('0')
            ->will($this->returnValue(['id' => '44']));

            $mgApp->expects($this->at(1))
            ->method('getfromdb')
            ->with('1')
            ->will($this->returnValue(['id' => '52']));

        $this->assertEquals($mgApp->getfromdb('0'), ['id' => '44']);
        $this->assertEquals($mgApp->getfromdb('1'), ['id' => '52']);
    }

    public function testGetDataFromDatabaseWithTheRightDataStructure()
    {
        $dbApp = new DbApp(new db('', '', ''));

        $this->assertTrue(is_array($dbApp->getSomeData('')));
        $data = $dbApp->getSomeData('');
        $this->assertArrayHasKey('id', $data);
    }

    /**
     * @dataProvider provideDataToSet
     */
    public function testSetDataToDatabaseWithTheRightDataStructure($data, $expected )
    {
        $dbApp = new DbApp(new db('', '', ''));
        
        $this->assertEquals($dbApp->setSomeData($data[0], $data[1]), $expected);
    }
    
    /**
     * @return array
     */
    public function provideDataToSet()
    {
        return [
            [
                ['moises', '44'], ['status' => 'ok', 'data' => ['moises'=> '44']]
            ],
            [
                ['manuel', '22'], ['status' => 'ok', 'data' => ['manuel'=> '22']]
            ],
            [
                ['teresa', '33'], ['status' => 'ok', 'data' => ['teresa'=> '33']]
            ],
        ];
    }

    public function testGlobalEnvironmentVars()
    {
        global $myGlobalVar1;
        $this->assertTrue($myGlobalVar1 == 'some_value');
    }
}
