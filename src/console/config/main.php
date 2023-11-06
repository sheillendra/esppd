<?php

$params = array_merge(
        require __DIR__ . '/../../common/config/params.php'
        , require __DIR__ . '/../../common/config/params-local.php'
        , require __DIR__ . '/params.php'
        , require __DIR__ . '/params-local.php'
);

return [
    'id' => getenv('ID_CONSOLE'),
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
        ],
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationNamespaces' => [
                # Other migration namespaces
                //'bedezign\yii2\audit\migrations',
            ],
            'migrationPath' => [
                '@app/migrations',
                '@yii/rbac/migrations',
                '@yii/web/migrations',
            ]
        ],
    ],
    'modules' => [
        //'audit' => [
        //    'class' => 'bedezign\yii2\audit\Audit',
        //    'accessRoles' => ['superadmin'],
        //]
    ],
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'params' => $params,
];
