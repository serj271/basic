<?php
namespace tests\unit;
use PHPUnit\Framework\TestCase;

require  dirname(__FILE__) .'/CsvFileIterator.php';

class Data3Test extends TestCase
{
    /**
     * @dataProvider additionProvider
     */
    public function testAdd($a, $b, $expected)
    {
        $this->assertEquals($expected, $a + $b);
    }

    public function additionProvider()
    {
        return new CsvFileIterator('data.csv');
    }
}
?>