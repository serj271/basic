<?php
require_once '/usr/local/www/basic/vendor/mikey179/vfsstream/src/main/php/org/bovigo/vfs/vfsStreamWrapper.php';
use PHPUnit\Framework\TestCase;
require dirname(__FILE__).'/Example.php';

class Example1Test extends TestCase
{
    public function setUp()
    {
        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('exampleDir'));
    }

    public function testDirectoryIsCreated()
    {
        $example = new Example('id');
        $this->assertFalse(vfsStreamWrapper::getRoot()->hasChild('id'));

        $example->setDirectory(vfsStream::url('exampleDir'));
        $this->assertTrue(vfsStreamWrapper::getRoot()->hasChild('id'));
    }
}
?>