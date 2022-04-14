<?php

declare(strict_types=1);

namespace App\CommissionTask\Tests\Helpers;

use PHPUnit\Framework\TestCase;

class DateTest extends TestCase
{
  public function testGetWeekMonday()
  {
    $week = getWeek('2022-04-11');
    $this->assertEquals('2022-04-11', $week['monday']);
    $this->assertEquals('2022-04-17', $week['sunday']);
  }

  public function testGetWeekMiddle()
  {
    $week = getWeek('2022-04-13');
    $this->assertEquals('2022-04-11', $week['monday']);
    $this->assertEquals('2022-04-17', $week['sunday']);
  }

  public function testGetWeekSunday()
  {
    $week = getWeek('2022-04-17');
    $this->assertEquals('2022-04-11', $week['monday']);
    $this->assertEquals('2022-04-17', $week['sunday']);
  }

  public function testGetWeekCrossYear()
  {
    $week = getWeek('2021-12-30');
    $this->assertEquals('2021-12-27', $week['monday']);
    $this->assertEquals('2022-01-02', $week['sunday']);
  }
}
