<?php
return [
    'query'=>[
        'dashboard'=>[
            'day-acq'=>['offset'=>7, 'tz'=>'Asia/Jakarta'],
            'voucher-trx-series'=>['offset'=>7, 'tz'=>'Asia/Jakarta']
        ],
    ],
    'input'=>[
        'dashboard'=>[

        ]
    ],
    'output'=>[
        'dashboard'=>[

        ],
        'wallet-transaction'=>[
            'transactionTimestamp'=>['offset'=>7, 'tz'=>'Asia/Jakarta'],
            'createdAt'=>['offset'=>7, 'tz'=>'Asia/Jakarta']
        ]
    ]
];
