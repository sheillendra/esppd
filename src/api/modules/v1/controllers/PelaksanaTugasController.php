<?php

namespace api\modules\v1\controllers;

use api\modules\v1\components\rest\ActiveController;
use api\modules\v1\models\PelaksanaTugasExt;
use api\modules\v1\models\PelaksanaTugasSearch;
use api\modules\v1\models\SppdExt;

class PelaksanaTugasController extends ActiveController
{

    public $modelClass = PelaksanaTugasExt::class;
    public $searchModelClass = PelaksanaTugasSearch::class;

    /**
     * @param int $id
     */
    public function actionGenerateSppd($id)
    {
        $sppd = new SppdExt();
        return $sppd->generateSppd($id);
    }

}
