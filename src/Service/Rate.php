<?php

declare(strict_types=1);

namespace App\CommissionTask\Service;

use App\CommissionTask\Config\Config;

class Rate {

  public static function Convert(string $from, string $to, float $amount) : float
  {
    $rates = Config::Rates();
    return 1 / $rates['rates'][$from] * $rates['rates'][$to] * $amount;
  }

}