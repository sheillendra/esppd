<?php

namespace console\controllers;

use Yii;
use common\models\UserExt;
use common\models\AnggaranExt;
use common\models\SppdExt;

class TestController extends \yii\console\Controller {

    public function actionSql() {
        $user = UserExt::findOne(['id' => 1]);
        echo 'id 1 sebagai superadmin = ', $user->can($user::ROLE_SUPERADMIN), "\n";
        echo 'id 1 sebagai asn = ', $user->can($user::ROLE_ASN), "\n";


//        $query = UserExt::find()
//                ->alias('t0')
//                ->leftJoin()
//        ;
        //print_r(Yii::$app->db->createCommand($user->authItemWithLevel)->queryAll());
        //exit;
        //$all = Yii::$app->db->createCommand($user->authAssigmentWithRoles())->queryAll();
        //print_r($all);

        echo $user->getMaxLevel(), "\n";
        echo $user->getAllRoles(), "\n";
    }

    public function actionInsert() {
        
    }

    public function actionRbac() {
        $user = UserExt::findOne(['id' => 1]);
        $auth = Yii::$app->authManager;

        echo $auth->checkAccess($user->id, UserExt::ROLE_ASN);
    }

    public function actionKurangiSaldo($id, $jumlah) {
        $anggaran = AnggaranExt::findOne(['id' => $id]);
        $anggaran->kurangiSaldo($jumlah);
    }
    
    public function actionModelRel(){
        $model = SppdExt::findOne(['id' => 1]);
        echo $model->anggaran->opd->pelaksanaTeknik->nama;
        echo $model->anggaran->opd->bendaharaPengeluaran->nama;
        echo $model->anggaran->opd->bendaharaPengeluaran->nip;
        echo $model->anggaran->opd->pelaksanaTeknik->nip;
    }

}
