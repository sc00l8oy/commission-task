<?php
/**
 * Round up any float number to
 * decimal places passed in precision argument
 * 
 * @param float $value
 * @param int $precision
 * @return float
 */
function roundUp($value, $precision) : float
{ 
  $pow = pow(10, $precision); 
  return (ceil($pow * $value) + ceil($pow * $value - ceil($pow * $value))) / $pow; 
} 