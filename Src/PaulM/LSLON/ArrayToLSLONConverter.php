<?php
namespace PaulM\LSLON;

class ArrayToLSLONConverter {

  protected $data;
  protected $lslon;

  public function __construct(array $data) {
    $this->setData($data);
  }

  public function setData(array $data) {
    $this->data = $data;
    $this->lslon = '';
  }

  public function getLslon($typed = FALSE) {
    if (empty($this->lslon)) {
      $this->generateLslon($typed);
    }
    return $this->lslon;
  }

  public function __toString() {
    return $this->getLslon();
  }

/*
TYPE_INTEGER	1	integer
TYPE_FLOAT	2	float
TYPE_STRING	3	string
TYPE_KEY	4	key
TYPE_VECTOR	5	vector
TYPE_ROTATION	6	rotation
TYPE_INVALID	0	none
*/

  protected function generateLslon($typed = FALSE) {
    $lslonArray = ['LSLON 1.0'];
    if (!empty($this->data)) {
      $valueArray = array();
      // data should be an array due to type hinting.
      foreach($this->data as $name=>$value) {
        if ($typed) $valueArray[] = 'TYPED';
        switch (gettype($value)) {
          case 'boolean' :
            // http://wiki.secondlife.com/wiki/TRUE
            $value = $value ? 1 : 0;
            // Fall through to integer...
          case 'integer' :
            if ($typed) $valueArray[] = '1';
            $valueArray[] = $value;
            break;
          case 'double' :
            if ($typed) $valueArray[] = '2';
            $valueArray[] = $value;
            break;
          case 'string' :
            if ($typed) $valueArray[] = '3';
            $valueArray[] = urlencode($value);
            break;

          default:
            throw new \InvalidArgumentException('LSLON can only encode boolean, integer, double, and string types.');
        }
        $lslonArray[] = urlencode($name) . '=' . implode('|', $valueArray);
      }
    }

    $this->lslon = implode("\n", $lslonArray);
  }

}
