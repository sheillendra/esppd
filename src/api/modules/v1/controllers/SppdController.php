<?php

namespace api\modules\v1\controllers;

use api\modules\v1\components\rest\ActiveController;
use api\modules\v1\models\SppdSearch;
use api\modules\v1\models\SppdExt;
use yii\web\NotFoundHttpException;

class SppdController extends ActiveController
{

    public $modelClass = SppdExt::class;
    public $searchModelClass = SppdSearch::class;

    public $createScenario = SppdExt::SCENARIO_CREATE;
    public $updateScenario = SppdExt::SCENARIO_UPDATE;

    public function verbs()
    {
        $verbs = parent::verbs();
        $verbs['change-status'] = ['POST'];
        return $verbs;
    }

    public function actionChangeStatus($id, $status)
    {
        $model = $this->findModel($id);

        if (
            $status == SppdExt::STATUS_SEDANG_PROSES &&
            $model->status > SppdExt::STATUS_SEDANG_PROSES
        ) {
            return $model->prosesKembali();
        }

        if ($status == SppdExt::STATUS_HITUNG_BIAYA) {
            if ($model->status < SppdExt::STATUS_HITUNG_BIAYA) {
                return $model->hitungBiaya();
            }
            return $model->hitungBiayaKembali();
        }

        if ($status == SppdExt::STATUS_PENGESAHAN) {
            return $model->siapDisahkan();
        }

        if ($status == SppdExt::STATUS_TERBIT) {
            return $model->terbitkan();
        }

        if ($status == SppdExt::STATUS_HITUNG_RAMPUNG) {
            return $model->hitungRampung();
        }

        throw new NotFoundHttpException('Tidak ada proses');
    }

    protected function findModel($id)
    {
        if (($model = SppdExt::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Data tidak ditemukan');
    }

    public function actionPrepareBiaya($id){
        $model = $this->findModel($id);
        return $model->prepareHitungBiaya();        
    }
}
