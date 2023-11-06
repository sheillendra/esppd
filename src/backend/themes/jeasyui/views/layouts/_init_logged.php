<?php

use yii\helpers\Url;
use yii\web\JsExpression;

$this->title = 'Admin - ' . $this->title;

//required params
$this->params['favico'] = Yii::getAlias('@web') . '/favicon.png';
$usernameText = [];
if (Yii::$app->user->identity->pegawaiAsProfile) {
    $usernameText[] = Yii::$app->user->identity->pegawaiAsProfile->namaLengkap;
} else if (Yii::$app->user->identity->pendudukAsProfile) {
    $usernameText[] = Yii::$app->user->identity->pendudukAsProfile->namaLengkap;
} else {
    $usernameText[] = Yii::$app->user->identity->username;
}

$usernameText[] = Yii::$app->user->identity->allRoles;

$this->params['userName'] = implode(', ', $usernameText);
$this->params['homeUrl'] = Url::to(['/pegawai']);
$this->params['logoutUrl'] = Url::to(['/jeasyui/logout']);
$this->params['getReferenceUrl'] = Url::to(['/jeasyui/reference']);
$this->params['westTitle'] = 'Menu Utama';
$this->params['westIcon'] = 'icon-compass';
$this->params['sidebarPlugin'] = 'accordion'; //tree or accordion

$this->render('@app/views/layouts/_init_north-user-menu');

$this->registerJs(
    <<<JS
    yii.easyui.t.tryAgain = 'Ulangi';
    yii.easyui.t.close = 'Tutup';
JS
);
