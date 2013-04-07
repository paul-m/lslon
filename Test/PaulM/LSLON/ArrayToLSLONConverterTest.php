<?php
namespace PaulM\LSLON;

use PaulM\LSLON\ArrayToLSLONConverter;

class ArrayToLSLONConverterTest extends \PHPUnit_Framework_TestCase {
  
  public function testArrayConversion() {
    $converter = new ArrayToLSLONConverter(array());
    $this->assertEquals($converter->getLslon(), 'LSLON 1.0');
    $converter->setData(array('foo' => 'bar'));
    $this->assertEquals($converter->getLslon(), "LSLON 1.0\nfoo=bar");
  }
  
}

