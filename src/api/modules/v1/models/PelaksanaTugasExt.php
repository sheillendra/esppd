<?php

namespace api\modules\v1\models;

use Yii;

class PelaksanaTugasExt extends \common\models\PelaksanaTugasExt
{
    public $pribadi;
    public function extraFields()
    {
        return ['pegawai', 'penduduk', 'suratTugas'];
    }

    public function selfRecordQuery($query)
    {
        if (Yii::$app->user->identity->pegawaiAsProfile) {
            $query->andWhere(['t0.pegawai_id' => Yii::$app->user->identity->pegawaiAsProfile->id]);
        } else if (Yii::$app->user->identity->pendudukAsProfile) {
            $query->andWhere(['t0.penduduk_id' => Yii::$app->user->identity->pendudukAsProfile->id]);
        }
    }
}
