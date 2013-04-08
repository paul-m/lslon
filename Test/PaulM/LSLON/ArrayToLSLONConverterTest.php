<?php
namespace PaulM\LSLON;

use PaulM\LSLON\ArrayToLSLONConverter;

/**
 * @todo: test for good complex conversions.
 */

class ArrayToLSLONConverterTest extends \PHPUnit_Framework_TestCase {

  public function testConversion() {
    $converter = new ArrayToLSLONConverter(array());
    $this->assertEquals($converter->getLslon(), 'LSLON 1.0');
    $converter->setData(array('foo' => 'bar'));
    $this->assertEquals($converter->getLslon(), "LSLON 1.0\nfoo=bar");
  }
  
  public function badInputProvider() {
    return array(
      array(array(array())),
      array(array(new \stdClass())),
      array(array(NULL)),
    );
  }
  
  /**
   * @dataProvider badInputProvider
   * @expectedException \InvalidArgumentException
   */
  public function testBadInput(array $array) {
    $converter = new ArrayToLSLONConverter($array);
    $lslon = $converter->getLslon();
  }

}

