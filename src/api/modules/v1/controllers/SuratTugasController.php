<?php

namespace api\modules\v1\controllers;

use api\modules\v1\components\rest\ActiveController;
use api\modules\v1\models\SuratTugasSearch;
use api\modules\v1\models\SuratTugasExt;
use yii\web\NotFoundHttpException;

class SuratTugasController extends ActiveController
{

    public $modelClass = SuratTugasExt::class;
    public $searchModelClass = SuratTugasSearch::class;

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
            $status == SuratTugasExt::STATUS_SEDANG_PROSES &&
            $model->status > SuratTugasExt::STATUS_SEDANG_PROSES
        ) {
            return $model->prosesKembali();
        }

        if ($status == SuratTugasExt::STATUS_PENGESAHAN) {
            return $model->siapDisahkan();
        }

        if ($status == SuratTugasExt::STATUS_TERBIT) {
            return $model->terbitkan();
        }

        throw new NotFoundHttpException('Tidak ada proses');
    }

    protected function findModel($id)
    {
        if (($model = SuratTugasExt::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Data tidak ditemukan');
    }
}
