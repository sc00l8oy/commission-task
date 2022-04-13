<?php

declare(strict_types=1);

namespace App\CommissionTask\Service;

class Rate {

  static $rates = ['base' => 'EUR', 'rates' => ['USD' => '1.1497', 'JPY' => '129.53']];

  public static function Sync() {
    if (is_null(self::$rates)) {
      self::$rates = require __DIR__ . '/../Config/rates.php';
    }
  }

  public static function Convert(string $from, string $to, int $amount)
  {
    self::Sync();
    $fromRate = ($from == self::$rates['base'] ? 1 : self::$rates['rates'][$from]);
    $toRate = ($to == self::$rates['base'] ? 1 : self::$rates['rates'][$to]);
    return 1/$fromRate*$toRate*$amount;
  }

}