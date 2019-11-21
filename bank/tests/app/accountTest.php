<?php
require dirname(__DIR__) . '/bootstrap.php';
require dirname(__DIR__) . '/settings.php';

use bankApp\core\account;
use bankApp\core\bank;
use bankApp\traits\support;
use PHPUnit\Framework\TestCase;

/**
 * Class accountTest
 * just some small examples, nothing to complicated
 * only for demonstration pr
 */
class accountTest extends TestCase
{

    use support;
    /**
     * @var account
     */
    private $object;

    /**
     * banktest constructor.
     * @param null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->object = new account();
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }


    public function testOpensslEncryptExtensionIsActivated()
    {
        $this->assertfalse(is_string($this->dataCrypt('dummy data', '2')));
    }

    /**
     * test Returning Array In Get infosaveMethod
     */
    public function testReturningArrayInGetinfosaveMethod()
    {
        $this->assertTrue(is_array($this->object->getInfoToSave()));
    }

    /**
     * test Do Not Allow Less Than Zero Withdraw Without Overdraft
     */
    public function testDoNotAllowLessThanZeroWithdrawWithoutOverdraft()
    {
        //Class initial value is allways 0
        $this->assertFalse($this->object->setFunds(-20));
    }

    /**
     * test Do Not Allow Less Than Overdraft Withdraw WithOverdraft
     */
    public function testDoNotAllowLessThanOverdraftWithdrawWithOverdraft()
    {
        $this->object->setOverdraftLimit(40);
        $this->assertFalse($this->object->setFunds(-120));
    }

    /**
     * test Allow Less Than Available Inside Overdraft Limit
     */
    public function testAllowLessThanAvailableInsideOverdraftLimit()
    {
        $this->object->setOverdraftLimit(40);
        $this->assertTrue($this->object->setFunds(-20));
    }
}
