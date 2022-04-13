<?php

function round_up ( $value, $precision ) { 
  $pow = pow ( 10, $precision ); 
  return ( ceil ( $pow * $value ) + ceil ( $pow * $value - ceil ( $pow * $value ) ) ) / $pow; 
} 