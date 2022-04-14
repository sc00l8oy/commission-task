<?php

declare(strict_types=1);

/**
 * Calculates the date argument's week
 * and provides dates of Monday and Sunday
 * 
 * @param string $date
 * @return array
 */
function getWeek(string $date) : array
{
  $weekDay = date('w', strtotime($date));
  $monday = ($weekDay == 1 ? $date : date('Y-m-d', strtotime("last Monday", strtotime($date))));
  $sunday = date('Y-m-d', strtotime("+6 day", strtotime($monday)));
  return ['monday' => $monday, 'sunday' => $sunday];
}