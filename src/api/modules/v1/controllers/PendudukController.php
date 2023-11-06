<?php

namespace api\modules\v1\controllers;

use api\modules\v1\components\rest\ActiveController;
use api\modules\v1\models\PendudukSearch;
use api\modules\v1\models\UserExt;
use common\models\PendudukExt;

class PendudukController extends ActiveController
{
    public $modelClass = 'common\models\PendudukExt';
    public $searchModelClass = PendudukSearch::class;

    public function actionGenerateUser($id)
    {
        $model = PendudukExt::findOne($id);
        if ($model) {
            return $model->generateUser();
        }

        return ['success' => false, 'message' => 'Penduduk tidak ditemukan'];
    }
}
