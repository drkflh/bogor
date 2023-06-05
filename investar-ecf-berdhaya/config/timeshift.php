<?php
return [
    'query'=>[
        'dashboard'=>[
            'day-acq'=>['offset'=>7, 'tz'=>'Asia/Jakarta'],
            'trx-chan'=>['offset'=>7, 'tz'=>'Asia/Jakarta'],
            'points'=>['offset'=>7, 'tz'=>'Asia/Jakarta'],
            'trx-voucher'=>['offset'=>7, 'tz'=>'Asia/Jakarta'],
            'trx-voucher-category'=>['offset'=>7, 'tz'=>'Asia/Jakarta'],
            'daily-eng'=>['offset'=>7, 'tz'=>'Asia/Jakarta'],
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
            'transactionTimestamp'=>['offset'=>7, 'tz'=>'Asia/Jakarta']
        ],
        'pay-transaction'=>[
            'transactionTimestamp'=>['offset'=>7, 'tz'=>'Asia/Jakarta'],
            'createdAt'=>['offset'=>7, 'tz'=>'Asia/Jakarta']
        ],
        'purchase-transaction'=>[
            'transactionTimestamp'=>['offset'=>7, 'tz'=>'Asia/Jakarta']
        ],
        'wallet-pointer'=>[
            'transactionTimestamp'=>['offset'=>7, 'tz'=>'Asia/Jakarta'],
            'createdAt'=>['offset'=>7, 'tz'=>'Asia/Jakarta'],
            'expiredDate'=>['offset'=>7, 'tz'=>'Asia/Jakarta']
        ],
        'voucher-transaction'=>[
            'transactionTimestamp'=>['offset'=>7, 'tz'=>'Asia/Jakarta']
        ],
        'member-card-list'=>[
            'enrollmentDate'=>['offset'=>7, 'tz'=>'Asia/Jakarta']
        ],
        'member-card-design'=>[
            'validFrom'=>['offset'=>7, 'tz'=>'Asia/Jakarta'],
            'validUntil'=>['offset'=>7, 'tz'=>'Asia/Jakarta']
        ],
        'member-list'=>[
            'enrollmentDate'=>['offset'=>7, 'tz'=>'Asia/Jakarta']
        ],
        'member-wallet'=>[
            'createdAt'=>['offset'=>7, 'tz'=>'Asia/Jakarta']
        ],
        'deploy-log'=>[
            'updated_at'=>['offset'=>7, 'tz'=>'Asia/Jakarta'],
            'created_at'=>['offset'=>7, 'tz'=>'Asia/Jakarta'],
        ],
        'deploy-queue'=>[
            'updated_at'=>['offset'=>7, 'tz'=>'Asia/Jakarta'],
            'created_at'=>['offset'=>7, 'tz'=>'Asia/Jakarta'],
        ],
        'deploy-queue'=>[
            'updated_at'=>['offset'=>7, 'tz'=>'Asia/Jakarta'],
            'created_at'=>['offset'=>7, 'tz'=>'Asia/Jakarta'],
        ],
        'node'=>[
            'updated_at'=>['offset'=>0, 'tz'=>'Asia/Jakarta'],
            'created_at'=>['offset'=>0, 'tz'=>'Asia/Jakarta'],
        ],
    ]
];
