<?php

declare(strict_types=1);

namespace App\CommissionTask\Tests\Helpers;

use PHPUnit\Framework\TestCase;

class MathTest extends TestCase
{
  public function testRoundUpNoDecimal()
  {
    $this->assertEquals(2, roundUp(2, 2));
  }

  public function testRoundUpDecimalDown()
  {
    $this->assertEquals(2.07, roundUp(2.062, 2));
  }

  public function testRoundUpDecimalMiddle()
  {
    $this->assertEquals(2.07, roundUp(2.065, 2));
  }

  public function testRoundUpDecimalUp()
  {
    $this->assertEquals(2.07, roundUp(2.068, 2));
  }

  public function testRoundUpLongDecimal()
  {
    $this->assertEquals(2.04, roundUp(2.0327854, 2));
  }
}
