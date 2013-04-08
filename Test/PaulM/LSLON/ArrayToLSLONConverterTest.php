<?php
namespace PaulM\LSLON;

use PaulM\LSLON\ArrayToLSLONConverter;

/**
 * @todo: add more tests for complex conversions.
 */

class ArrayToLSLONConverterTest extends \PHPUnit_Framework_TestCase {

  public function goodInputProvider() {
    return array(
      array(
        array('name'=>'value'),
        FALSE,
        "LSLON 1.0\nname=value",
      ),
      array(
        array('name'=>'value'),
        TRUE,
        "LSLON 1.0\nname=TYPED|3|value",
      ),
    );
  }

  /**
   * @dataProvider goodInputProvider
   */
  public function testConversion(array $array, $typed, $expected) {
    $converter = new ArrayToLSLONConverter($array);
    $this->assertEquals($converter->getLslon($typed), $expected);
  }
  
  public function badInputProvider() {
    return array(
      array(array('name'=>array())),
      array(array('name'=>new \stdClass())),
      array(array('name'=>NULL)),
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

