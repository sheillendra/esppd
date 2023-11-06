<?php

namespace console\controllers;

use Yii;
use common\models\UserExt;
use common\models\AnggaranExt;
use common\models\SppdExt;
use common\models\PelaksanaTugasExt;

class FixController extends \yii\console\Controller {

    /**
     * After delete SPPD statusPalaksanaTugas not changed
     */
    public function actionStatusPelaksanaTugasAfterDeleteSppd() {
        $pelaksanaTugas = PelaksanaTugasExt::find()
                ->where(['status' => PelaksanaTugasExt::STATUS_SUDAH_SPPD])
                ->all();
        foreach ($pelaksanaTugas as $pelaksana) {
            if(!$pelaksana->sppd){
                $pelaksana->status = PelaksanaTugasExt::STATUS_BELUM_SPPD;
                $pelaksana->save();
            }
        }
    }

}
