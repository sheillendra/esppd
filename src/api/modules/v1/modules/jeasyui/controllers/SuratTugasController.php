<?php

namespace api\modules\v1\modules\jeasyui\controllers;

use api\modules\v1\modules\jeasyui\models\SuratTugasSearch;

class SuratTugasController extends \api\modules\v1\controllers\SuratTugasController
{
    public $searchModelClass = SuratTugasSearch::class;
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'rows'
    ];
}
