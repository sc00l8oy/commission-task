<?php

require 'vendor/autoload.php';

use App\CommissionTask\Models\Transaction;
use App\CommissionTask\Service\TransactionManager;

try {
  $file = fopen($argv[1], 'r');
  while (($data = fgetcsv($file)) !== false) {
    $transaction = new Transaction($data[0], $data[1], $data[2], $data[3], $data['4'], $data[5]);
    $transactionResult = TransactionManager::Transact($transaction);
    echo $transactionResult->fee . "\n";
  }
  fclose($file);
} catch (Exception $e) {
  echo $e->getMessage();
} catch (Throwable $e) {
  echo $e->getMessage();
}
