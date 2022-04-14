<?php

declare(strict_types=1);

namespace App\CommissionTask\Tests\Service;

use App\CommissionTask\Config\Config;
use App\CommissionTask\Models\Transaction;
use App\CommissionTask\Service\HistoryManager;
use App\CommissionTask\Service\TransactionManager;
use PHPUnit\Framework\TestCase;

class TransactionManagerTest extends TestCase
{
  protected function tearDown() : void
  {
    HistoryManager::clear();
  }

  /**
   * @dataProvider dataProviderForDeposit
   */
  public function testCommissionFeeForDeposit($transactions)
  {
    foreach ($transactions as $transaction)
      HistoryManager::Add($transaction);

    $rules = Config::Rules();

    $transaction = new Transaction('2015-01-02', '1', 'private', 'deposit', '100', 'EUR');
    $transactionResult = TransactionManager::Transact($transaction);
    $expected = roundUp($transaction->amount*$rules[$transaction->operation][$transaction->userType]['commission']/100, 2);
    $this->assertEquals($expected, $transactionResult->fee);
  }

  /**
   * @dataProvider dataProviderForWithdraw
   */
  public function testCommissionFeeForWithdraw($transactions)
  {
    foreach ($transactions as $transaction)
      HistoryManager::Add($transaction);

    $rules = Config::Rules();

    $transaction = new Transaction('2015-01-02', '1', 'private', 'withdraw', '100', 'EUR');
    $transactionResult = TransactionManager::Transact($transaction);
    $rule = $rules[$transaction->operation][$transaction->userType];
    $expected = roundUp((2200+$transaction->amount-$rule['weeklyBenefit']['amount'])*$rule['commission']/100, 2);
    $this->assertEquals($expected, $transactionResult->fee);
  }

  /**
   * @return array
   */
  public function dataProviderForDeposit() : array
  {
    return [
      'Test multiple weekly transactions' => [
        [
          new Transaction('2014-12-31', '1', 'private', 'deposit', '1200.00', 'EUR'),
          new Transaction('2015-01-01', '1', 'private', 'deposit', '1000.00', 'EUR'),
          new Transaction('2016-01-05', '1', 'private', 'deposit', '1000.00', 'EUR'),
          new Transaction('2016-01-05', '1', 'private', 'deposit', '200.00', 'EUR'),
          new Transaction('2016-01-06', '1', 'business', 'deposit', '300.00', 'EUR'),
          new Transaction('2016-01-06', '1', 'private', 'deposit', '30000', 'JPY'),
          new Transaction('2016-01-07', '1', 'private', 'deposit', '1000.00', 'EUR'),
        ]
      ]
    ];
  }

  /**
   * @return array
   */
  public function dataProviderForWithdraw() : array
  {
    return [
      'Test multiple weekly transactions' => [
        [
          new Transaction('2014-12-31', '1', 'private', 'withdraw', '1200.00', 'EUR'),
          new Transaction('2015-01-01', '1', 'private', 'withdraw', '1000.00', 'EUR'),
          new Transaction('2016-01-05', '1', 'private', 'withdraw', '1000.00', 'EUR'),
          new Transaction('2016-01-05', '1', 'private', 'withdraw', '200.00', 'EUR'),
          new Transaction('2016-01-06', '1', 'business', 'withdraw', '300.00', 'EUR'),
          new Transaction('2016-01-06', '1', 'private', 'withdraw', '30000', 'JPY'),
          new Transaction('2016-01-07', '1', 'private', 'withdraw', '1000.00', 'EUR'),
        ]
      ]
    ];
  }

  /**
   * @return array
   */
  public function dataProviderForMixed() : array
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
