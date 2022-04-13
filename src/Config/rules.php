<?php

return [
  'deposit' => [
    'private' => [
      'commission' => '0.03',
      'benefit' => null
    ],
    'business' => [
      'commission' => '0.03',
      'benefit' => null
    ]
  ],
  'withdraw' => [
    'private' => [
      'commission' => '0.3',
      'benefit' => [
        'amount' => 1000,
        'currency' => 'EUR',
        'span' => 'weekly'
      ]
    ],
    'business' => [
      'commission' => '0.5',
      'benefit' => null
    ]
  ]
];