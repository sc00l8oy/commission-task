<?php

declare(strict_types=1);

namespace App\CommissionTask\Tests\Config;

use App\CommissionTask\Config\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
  /**
   * Test if rates.php file is read correctly
   */
  public function testConfigRatesInstance()
  {
    $rates = Config::Rates();
    $this->assertIsArray($rates);
  }

  /**
   * Test if rules.php file is read correctly
   */
  public function testConfigRulesInstance()
  {
    $rules = Config::Rules();
    $this->assertIsArray($rules);
  }
}
