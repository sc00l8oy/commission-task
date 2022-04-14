<?php

return [
  'deposit' => [
    'private' => [
      'commission' => 0.03,
      'weeklyBenefit' => null
    ],
    'business' => [
      'commission' => 0.03,
      'weeklyBenefit' => null
    ]
  ],
  'withdraw' => [
    'private' => [
      'commission' => 0.3,
      'weeklyBenefit' => [
        'amount' => 1000,
        'currency' => 'EUR',
        'freeOperations' => 3
      ]
    ],
    'business' => [
      'commission' => 0.5,
      'weeklyBenefit' => null
    ]
  ]
];