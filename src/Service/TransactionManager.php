<?php

declare(strict_types=1);

namespace App\CommissionTask\Service;

use App\CommissionTask\Models\Transaction;
use App\CommissionTask\Models\TransactionResult;

class TransactionManager {

  static $rules = null;
  static $history = [];

  public static function Sync() {
    if (is_null(self::$rules)) {
      self::$rules = require __DIR__ . '/../Config/rules.php';
    }
  }

  public static function Transact(Transaction $transaction)
  {
    self::Sync();
    if (self::$rules[$transaction->operation][$transaction->userType]['benefit'])
      $comission = self::CalculateBenefitCommission($transaction);
    else
      $comission = self::$rules[$transaction->operation][$transaction->userType]['commission'];

    $transactionResult = new TransactionResult();
    $transactionResult->fee = round_up($transaction->amount*$comission/100, 2);
    array_push(self::$history, $transaction);
    return $transactionResult;
  }

  private static function CalculateBenefitCommission($transaction)
  {
    
  }

}