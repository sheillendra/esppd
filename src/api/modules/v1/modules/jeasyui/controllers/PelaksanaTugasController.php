<?php

namespace api\modules\v1\modules\jeasyui\controllers;

use api\modules\v1\modules\jeasyui\models\PelaksanaTugasSearch;

class PelaksanaTugasController extends \api\modules\v1\controllers\PelaksanaTugasController
{
    public $searchModelClass = PelaksanaTugasSearch::class;
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'rows'
    ];
}
