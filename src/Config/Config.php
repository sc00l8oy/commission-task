<?php

declare(strict_types=1);

namespace App\CommissionTask\Config;

class Config
{
  /**
   * @var array|null
   */
  private static $rates = null;
  /**
   * @var array|null
   */
  private static $rules = null;

  private static function Sync() : void
  {
    if (is_null(self::$rates))
      self::$rates = require __DIR__ . '/../Config/rates.php';
    if (is_null(self::$rules))
      self::$rules = require __DIR__ . '/../Config/rules.php';
  }

  public static function Rates() : array
  {
    self::Sync();
    return self::$rates;
  }

  public static function Rules() : array
  {
    self::Sync();
    return self::$rules;
  }

}
