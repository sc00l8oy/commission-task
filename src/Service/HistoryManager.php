<?php

declare(strict_types=1);

namespace App\CommissionTask\Service;

use App\CommissionTask\Models\Transaction;

class HistoryManager {

  private static $history = [];


  public static function Add(Transaction $transaction) : void
  {
    self::$history[] = $transaction;
  }

  public static function GetHistory() : array
  {
    return self::$history;
  }

  public static function Clear() : void
  {
    self::$history = [];
  }

  public static function GetUserWeeklyTransactionsByDate(string $userId, string $date, string $operation) : array
  {
    $transactionWeek = getWeek($date);
    return array_filter(self::$history, function (Transaction $transaction) use ($userId, $transactionWeek, $operation) {
      return $transaction->userId == $userId && 
             $transaction->operation == $operation &&
             $transaction->date >= $transactionWeek['monday'] &&
             $transaction->date <= $transactionWeek['sunday'];
    });
  }

}