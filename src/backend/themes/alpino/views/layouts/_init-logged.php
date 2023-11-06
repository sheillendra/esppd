<?php

use yii\helpers\Html;
use common\models\UserExt;

$this->params['favicon'] = Yii::getAlias('@web') . '/images/favicon.png';
$this->params['loader'] = Yii::getAlias('@web') . '/images/logo-putih.png';
$this->params['loaderText'] = 'Tunggu sebentar...';
$this->params['brandLabel'] = Html::img(Yii::getAlias('@web') . '/images/logo-putih.png', ['alt' => 'BPKAD Haltim']);
$this->params['brandUrl'] = ['/'];
$this->params['leftSidebarItems'] = [
    [
        'label' => '<i class="zmdi zmdi-swap"></i>',
        'url' => 'javascript:void(0);',
        'options' => ['class' => 'menu-sm'],
        'encode' => false
    ],
    [
        'label' => '<i class="zmdi zmdi-fullscreen"></i>',
        'url' => 'javascript:void(0);',
        'template' => '<a href="{url}" class="fullscreen" title="Fullscreen" data-provide="fullscreen">{label}</a>',
        'encode' => false
    ],
    [
        'label' => '<i class="zmdi zmdi-collection-item-1"></i>',
        'url' => Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/']),
        'options' => ['title' => 'Ke Halaman Portal'],
        'encode' => false
    ],
    [
        'label' => '<i class="zmdi zmdi-collection-item-2"></i>',
        'url' => Yii::$app->urlManagerPenduduk->createAbsoluteUrl(['/']),
        'options' => ['title' => 'Ke halaman Penduduk'],
        'encode' => false,
        'visible' => Yii::$app->user->can(UserExt::ROLE_PENDUDUK)
    ],
    [
        'label' => '<i class="zmdi zmdi-collection-item-3"></i>',
        'url' => Yii::$app->urlManagerAsn->createAbsoluteUrl(['/']),
        'options' => ['title' => 'Ke halaman ASN'],
        'encode' => false,
        'visible' => Yii::$app->user->can(UserExt::ROLE_ASN)
    ],
    [
        'label' => '<i class="zmdi zmdi-collection-item-4"></i>',
        'url' => Yii::$app->urlManagerPejabat->createAbsoluteUrl(['/']),
        'options' => ['title' => 'Ke halaman Pejabat'],
        'encode' => false,
        'visible' => Yii::$app->user->can(UserExt::ROLE_PEJABAT_DAERAH)
    ],
];

$accountMenuTemplate = '<a href="{url}" title="Manjemen User">{label}</a>';
if (Yii::$app->user->can(UserExt::ROLE_SUPERADMIN)) {
    $accountMenuTemplate .= Html::a('<i class="zmdi zmdi-settings zmdi-hc-spin"></i>', ['/setting'], ['class' => 'mega-menu']);
}
$accountMenuTemplate .= Html::a('<i class="zmdi zmdi-power"></i>', ['/logout'], ['class' => 'mega-menu', 'data' => ['method' => 'post']]);

$this->params['leftSidebarItems'][] = [
    'label' => '<i class="zmdi zmdi-account"></i>',
    'url' => ['/user'],
    'options' => ['class' => 'power'],
    'template' => $accountMenuTemplate,
    'encode' => false
];
