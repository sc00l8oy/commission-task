<?php

declare(strict_types=1);

function filePath()
{
  global $argv;
  $index = 1;

  if (!empty($argv[$index]) && file_exists($argv[$index]) && is_readable($argv[$index]))
    return $argv[$index];
  else
    throw new Exception("Argument number {$index} needs to be a real path to a readable file");
}