<?php

// lslon.inc
// by Paul Mitchum

/**
 * @file
 * Functions to support LSLON.
 */

function parseString2LSLON ($lslon_string) {
  $result = array();
  // split it up into lines....
  $lines = explode('\n', $lslon_string);
  if (strtoupper(trim($lines[0])) != 'LSLON 1.0') {
    return $result;
  }
  // OK, we know we're dealing with lslon
  // so get rid of the marker line
  unset($lines[0]);
  // iterate through the lines
  foreach($lines as $line) {
    $keyvalue = explode('=', $line);
    $key = urldecode($keyvalue[0]);
    $value = explode('|', $keyvalue[1]);
    if ($value[0] == 'TYPED') { // add this later.....
      unset($value[0]);
    }
    $result->$key = $value;
  }
  return $result;
}
