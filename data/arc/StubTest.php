<?php
use PHPUnit\Framework\TestCase;
require dirname(__FILE__).'/SomeClass.php';

class StubTest extends TestCase
{
    public function testStub()
    {
        // Create a stub for the SomeClass class.
        $stub = $this->createMock(SomeClass::class);
		/* $stub = $this->getMockBuilder($originalClassName)
                     ->disableOriginalConstructor()
                     ->disableOriginalClone()
                     ->disableArgumentCloning()
                     ->disallowMockingUnknownTypes()
                     ->getMock(); */
        // Configure the stub.
        $stub->method('doSomething')
             ->willReturn('foo');
//will($this->returnValue($value))
//$stub->method('doSomething')
//             ->will($this->returnSelf());
        // Calling $stub->doSomething() will now return
        // 'foo'.
        $this->assertEquals('foo', $stub->doSomething());
    }
}
?>