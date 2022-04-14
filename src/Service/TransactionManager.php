<?php

declare(strict_types=1);

namespace App\CommissionTask\Service;

use App\CommissionTask\Config\Config;
use App\CommissionTask\Models\Transaction;
use App\CommissionTask\Models\TransactionResult;

class TransactionManager {

  public static function Transact(Transaction $transaction) : TransactionResult
  {
    $commission = self::CalculateCommission($transaction);
    $fee = roundUp($transaction->amount*$commission/100, 2);
    HistoryManager::Add($transaction);
    return new TransactionResult($fee);
  }

  private static function CalculateCommission(Transaction $transaction) : float
  {
    $rules = Config::Rules();
    return $rules[$transaction->operation][$transaction->userType]['weeklyBenefit'] ? 
            self::CalculateWeeklyBenefitCommission($transaction, $rules[$transaction->operation][$transaction->userType]) :
            $rules[$transaction->operation][$transaction->userType]['commission'];
  }

  private static function CalculateWeeklyBenefitCommission(Transaction $transaction, $rule) : float
  {
    $weeklyTransactions = HistoryManager::GetUserWeeklyTransactionsByDate($transaction->userId, $transaction->date, $transaction->operation);

    if (count($weeklyTransactions) >= $rule['weeklyBenefit']['freeOperations'])
      return $rule['commission'];

    $weeklyTransactionSum = Rate::Convert($transaction->currency, $rule['weeklyBenefit']['currency'], $transaction->amount);
    foreach ($weeklyTransactions as $weeklyTransaction)
      $weeklyTransactionSum += Rate::Convert($weeklyTransaction->currency, $rule['weeklyBenefit']['currency'], $weeklyTransaction->amount);

    if ($weeklyTransactionSum <= $rule['weeklyBenefit']['amount'])
      return 0;

    return ($weeklyTransactionSum - $rule['weeklyBenefit']['amount'])*$rule['commission']/$transaction->amount;
  }

}