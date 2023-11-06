<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => getenv('ID_FRONTEND'),
    'name' => getenv('NAME_FRONTEND'),
    'language' => 'id',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        //'audit' => [
        //    'class' => 'bedezign\yii2\audit\Audit',
        //    'accessRoles' => ['superadmin'],
        //]
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-' . getenv('ID_FRONTEND'),
        ],
        'user' => [
            'identityClass' => 'common\models\UserExt',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-sppdo', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'session-sppdo',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                'auth' => 'auth/index',
                'login' => 'site/login',
                'signup' => 'site/signup',
                'logout' => 'site/logout',
            ],
        ],
        'urlManagerFrontend' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'baseUrl' => getenv('URL_FRONTEND'),
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => [
                        //'@sheillendra/martfury/views',
                        '@app/themes/basic/views'
                    ],
                    '@app/modules' => [
                        //'@sheillendra/martfury/modules',
                        '@app/themes/basic/modules',
                    ],
                    '@app/widgets' => [
                        //'@sheillendra/martfury/widgets',
                        '@app/themes/basic/widgets',
                    ]
                ],
            ],
        ],
    ],
    'params' => $params,
];
