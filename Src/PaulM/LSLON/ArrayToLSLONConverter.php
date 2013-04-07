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

  protected function generateLslon($typed = FALSE) {
    $lslonArray = ['LSLON 1.0'];
    if (!empty($this->data)) {
      // data should be an array due to type hinting.
      foreach($this->data as $name=>$value) {
        

        $lslonArray[] = urlencode($name) . '=' . $value;
      }
    }
    
    $this->lslon = implode("\n", $lslonArray);
  }

}
