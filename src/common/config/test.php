<?php
return [
    'id' => 'app-common-tests',
    'basePath' => dirname(__DIR__),
    'modules' => [
        'audit' => [
            'class' => 'bedezign\yii2\audit\Audit',
            'accessRoles' => ['superadmin'],
        ]
    ],
    'components' => [
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'common\models\User',
        ],
        'urlManagerFrontend' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'baseUrl' => getenv('URL_FRONTEND'),
        ],
        'urlManagerAdmin' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'baseUrl' => getenv('URL_ADMIN'),
        ],
        'urlManagerAsn' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'baseUrl' => getenv('URL_ASN'),
        ],
        'urlManagerApi' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'baseUrl' => getenv('URL_API'),
        ],
        'urlManagerPejabat' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'baseUrl' => getenv('URL_PEJABAT'),
        ],
        'urlManagerPenduduk' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'baseUrl' => getenv('URL_PENDUDUK'),
        ],
    ],
];
