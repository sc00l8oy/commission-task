<?php

declare(strict_types=1);

namespace App\CommissionTask\Models;

class TransactionResult {

  /**
   * @var float
   */
  public $fee;


  public function __construct(float $fee)
  {
    $this->fee = $fee;
  }

}