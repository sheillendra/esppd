<?php

$params = array_merge(
        require __DIR__ . '/../../common/config/params.php'
        , require __DIR__ . '/../../common/config/params-local.php'
        , require __DIR__ . '/params.php'
        , require __DIR__ . '/params-local.php'
);

return [
    'id' => getenv('ID_BACKEND'),
    'name' => getenv('NAME_BACKEND'),
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'language' => 'id',
    'bootstrap' => ['log', 'configManager', 'devicedetect'],
    //'modules' => [
    //    'audit' => [
    //        'class' => 'bedezign\yii2\audit\Audit',
    //        'accessRoles' => ['superadmin'],
    //    ]
    //],
    'controllerMap' => [
       'alpino' => 'sheillendra\alpino\controllers\AlpinoController',
       'jeasyui' => 'sheillendra\jeasyui\controllers\JeasyuiController',
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-' . getenv('ID_BACKEND'),
        ],
        'user' => [
            'identityClass' => 'common\models\UserExt',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-sppdo', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
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
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => '@sheillendra/alpino/assets/template/assets',
                    'css' => [
                        'plugins/bootstrap/css/bootstrap.min.css'
                    ]
                ]
            ],
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
                '<controller>' => '<controller>/index',
            ],
        ],
        'urlManagerFrontend' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'baseUrl' => getenv('URL_FRONTEND'),
        ],
        'urlManagerApi' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'baseUrl' => getenv('URL_API'),
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => [
                        '@app/themes/jeasyui/views',
                        '@common/themes/jeasyui/views',
                        '@sheillendra/jeasyui/views',
                        '@app/themes/basic/views'
                    ],
                    '@app/modules' => [
                        '@app/themes/jeasyui/modules',
                        '@sheillendra/jeasyui/views',
                        '@app/themes/basic/modules',
                    ],
                    '@app/widgets' => [
                        '@app/themes/jeasyui/widgets',
                        '@sheillendra/jeasyui/views',
                        '@app/themes/basic/widgets',
                    ]
                ],
            ],
        ],
        'devicedetect' => [
            'class' => 'common\components\devicedetect\DeviceDetect'
        ],
    ],
    'params' => $params,
];
