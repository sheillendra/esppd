<?php

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'session' => [
            'class' => 'yii\web\DbSession',
            'writeCallback' => function ($session) {
                return [
                    'user_id' => Yii::$app->user->id,
                    'last_write' => time(),
                ];
            },
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@common/runtime/cache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'cache',
        ],
        'formatter' => [
            'class' => 'common\components\i18n\Formatter',
            'locale' => 'id',
//            /'defaultTimeZone' => 'UTC',
            'timeZone' => 'Asia/Jayapura',
            'dateFormat' => 'php:d-m-Y',
            'datetimeFormat' => 'php:d-M-Y H:i:s',
            'decimalSeparator' => ',',
            'thousandSeparator' => '.',
            'currencyCode' => 'Rp. ',
            'nullDisplay' => '-',
            //'numberFormatterSymbols' => [
            //    NumberFormatter::CURRENCY_SYMBOL => 'IDR',
            //],
            'numberFormatterOptions' => [
                NumberFormatter::MIN_FRACTION_DIGITS => 2,
                NumberFormatter::MAX_FRACTION_DIGITS => 2,
            ],
        ],
        'configManager' => [
            'class' => 'yii2tech\config\Manager',
            'storage' => [
                'class' => 'yii2tech\config\StorageDb',
                'table' => '{{%config}}',
            ],
            'items' => [
                'appName' => [
                    'path' => 'name',
                    'label' => 'Application Name',
                    'rules' => [
                        ['required'],
                    ],
                ],
                'tahunAnggaran' => [
                    'path' => 'params.tahunAnggaran',
                    'label' => 'Tahun Anggaran',
                    'rules' => [
                        ['required'],
                        ['number', 'min' => 2019, 'max' => date('Y') + 1],
                    ],
                ],
            ],
        ],
    ],
];
