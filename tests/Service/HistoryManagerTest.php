<?php

declare(strict_types=1);

namespace App\CommissionTask\Tests\Service;

use App\CommissionTask\Models\Transaction;
use App\CommissionTask\Service\HistoryManager;
use PHPUnit\Framework\TestCase;

class HistoryManagerTest extends TestCase
{
  protected function tearDown() : void
  {
    HistoryManager::clear();
  }

  public function testeEmptyHistory()
  {
    $transactions = HistoryManager::GetUserWeeklyTransactionsByDate('1', '2022-03-01', 'deposit');
    $this->assertIsArray($transactions);
    $this->assertEmpty($transactions);
  }

  /**
   * @dataProvider dataProviderForAddTesting
   */
  public function testAdd($transaction)
  {
    HistoryManager::Add($transaction);
    $history = HistoryManager::GetHistory();
    $this->assertEquals(1, count($history));
  }

  /**
   * @return array
   */
  public function dataProviderForAddTesting() : array
  {
    return [
      'Test adding one transaction to history' => [new Transaction('2022-03-01', '1', 'private', 'deposit', '100', 'EUR')]
    ];
  }

  /**
   * @dataProvider dataProviderForMultipleAddTesting
   */
  public function testMultipleAdd($transactions)
  {
    foreach ($transactions as $transaction)
      HistoryManager::Add($transaction);

    $history = HistoryManager::GetHistory();
    $this->assertEquals(count($transactions), count($history));
  }

  /**
   * @return array
   */
  public function dataProviderForMultipleAddTesting() : array
  {
    return [
      'Test adding multiple transactions' => [
        [
          new Transaction('2022-03-01', '1', 'private', 'deposit', '100', 'EUR'),
          new Transaction('2022-03-02', '2', 'business', 'deposit', '200', 'EUR'),
          new Transaction('2022-03-03', '3', 'private', 'withdraw', '90', 'JPY')
        ]
      ]
    ];
  }

  public function testWeeklyTransactionsEmpty()
  {
    $transactions = HistoryManager::GetUserWeeklyTransactionsByDate('1', '2022-03-01', 'deposit');
    $this->assertEmpty($transactions);
  }

  /**
   * @dataProvider dataProviderForAddTesting
   */
  public function testWeeklyTransactionsForSingle($transaction)
  {
    HistoryManager::Add($transaction);
    $transactions = HistoryManager::GetUserWeeklyTransactionsByDate('1', '2022-03-01', 'deposit');
    $this->assertEquals(1, count($transactions));
    $transactions = HistoryManager::GetUserWeeklyTransactionsByDate('1', '2022-03-05', 'deposit');
    $this->assertEquals(1, count($transactions));
    $transactions = HistoryManager::GetUserWeeklyTransactionsByDate('1', '2022-03-05', 'withdraw');
    $this->assertEquals(0, count($transactions));
    $transactions = HistoryManager::GetUserWeeklyTransactionsByDate('1', '2022-03-07', 'deposit');
    $this->assertEquals(0, count($transactions));
  }

  /**
   * @dataProvider dataProviderForMultipleTesting
   */
  public function testWeeklyTransactionsForMultiple($transactions)
  {
    foreach ($transactions as $transaction)
      HistoryManager::Add($transaction);

    $transactions = HistoryManager::GetUserWeeklyTransactionsByDate('4', '2015-01-01', 'withdraw');
    $this->assertEquals(2, count($transactions));
    $transactions = HistoryManager::GetUserWeeklyTransactionsByDate('4', '2015-01-01', 'deposit');
    $this->assertEquals(0, count($transactions));
    $transactions = HistoryManager::GetUserWeeklyTransactionsByDate('4', '2015-01-07', 'withdraw');
    $this->assertEquals(0, count($transactions));
    $transactions = HistoryManager::GetUserWeeklyTransactionsByDate('4', '2016-01-05', 'withdraw');
    $this->assertEquals(1, count($transactions));
    $transactions = HistoryManager::GetUserWeeklyTransactionsByDate('1', '2016-01-06', 'deposit');
    $this->assertEquals(1, count($transactions));
    $transactions = HistoryManager::GetUserWeeklyTransactionsByDate('1', '2016-01-05', 'withdraw');
    $this->assertEquals(2, count($transactions));
    $transactions = HistoryManager::GetUserWeeklyTransactionsByDate('2', '2016-01-06', 'withdraw');
    $this->assertEquals(1, count($transactions));
  }

  /**
   * @return array
   */
  public function dataProviderForMultipleTesting() : array
  {
    return [
      'Test multiple weekly transactions' => [
        [
          new Transaction('2014-12-31', '4', 'private', 'withdraw', '1200.00', 'EUR'),
          new Transaction('2015-01-01', '4', 'private', 'withdraw', '1000.00', 'EUR'),
          new Transaction('2016-01-05', '4', 'private', 'withdraw', '1000.00', 'EUR'),
          new Transaction('2016-01-05', '1', 'private', 'deposit', '200.00', 'EUR'),
          new Transaction('2016-01-06', '2', 'business', 'withdraw', '300.00', 'EUR'),
          new Transaction('2016-01-06', '1', 'private', 'withdraw', '30000', 'JPY'),
          new Transaction('2016-01-07', '1', 'private', 'withdraw', '1000.00', 'EUR'),
        ]
      ]
    ];
  }
}
