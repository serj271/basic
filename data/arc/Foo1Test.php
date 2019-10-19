<?php
use PHPUnit\Framework\TestCase;
require dirname(__FILE__).'/Subject.php';

class Foo1Test extends TestCase
{
    public function testIdenticalObjectPassed()
    {
        $cloneArguments = true;

        $mock = $this->getMockBuilder(stdClass::class)
                     ->enableArgumentCloning()
                     ->getMock();

        // now your mock clones parameters so the identicalTo constraint
        // will fail.
    }
}
?>