<?php

use common\models\UserExt;

/* @var $this yii\web\View */
/* @var $model common\models\UserExt */

$items = [];
if (Yii::$app->user->id === 1) {
    $items = [
        [
            'label' => 'Jadikan Superadmin',
            'url' => ['assign', 'id' => $model->id],
            'linkOptions' => [
                'data' => [
                    'confirm' => 'Yakin akan menjadikan user ini superadmin?',
                    'method' => 'post',
                    'params' => [
                        'role' => 'superadmin'
                    ]
                ],
            ]
        ]
    ];
}
if (Yii::$app->user->can(UserExt::ROLE_SUPERADMIN)) {
    $items[] = [
        'label' => 'Jadikan Admin OPD',
        'url' => ['assign', 'id' => $model->id],
        'linkOptions' => [
            'data' => [
                'confirm' => 'Yakin akan menjadikan user ini Admin OPD?',
                'method' => 'post',
                'params' => [
                    'role' => UserExt::ROLE_ADMIN_OPD
                ]
            ],
        ]
    ];
}

$items[] = [
    'label' => 'Reset Username/NIP/NIK',
    'url' => ['reset-username', 'id' => $model->id],
    'linkOptions' => [
        'data' => [
            'confirm' => 'Yakin akan mereset username user ini??',
            'method' => 'post',
        ],
    ]
];

$items[] = [
    'label' => 'Reset Password',
    'url' => ['reset-password', 'id' => $model->id],
    'linkOptions' => [
        'data' => [
            'confirm' => 'Yakin akan mereset password user ini??',
            'method' => 'post',
        ],
    ]
];

$items[] = ['label' => 'Update', 'url' => ['update', 'id' => $model->id]];
$items[] = [
    'label' => 'Hapus',
    'url' => ['delete', 'id' => $model->id],
    'linkOptions' => [
        'data' => [
            'confirm' => 'Yakin akan menghapus data ini??',
            'method' => 'post',
        ],
    ]
];

echo $this->render('@app/views/_partials/title_menu', ['items' => $items]);
