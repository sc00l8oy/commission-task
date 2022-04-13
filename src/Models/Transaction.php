<?php

declare(strict_types=1);

namespace App\CommissionTask\Models;

class Transaction {

  /**
   * @var string
   */
  public $date;
  /**
   * @var string
   */
  public $userId;
  /**
   * @var string
   */
  public $userType;
  /**
   * @var string
   */
  public $operation;
  /**
   * @var string
   */
  public $amount;
  /**
   * @var string
   */
  public $currency;

  public function __construct(string $date, string $userId, string $userType, string $operation, string $amount, string $currency)
  {
    $this->date = $date;
    $this->userId = $userId;
    $this->userType = $userType;
    $this->operation = $operation;
    $this->amount = $amount;
    $this->currency = $currency;
  }

}