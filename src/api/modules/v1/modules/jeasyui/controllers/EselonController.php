<?php

namespace api\modules\v1\modules\jeasyui\controllers;

use api\modules\v1\modules\jeasyui\models\EselonSearch;

class EselonController extends \api\modules\v1\controllers\EselonController
{
    public $searchModelClass = EselonSearch::class;
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'rows'
    ];
}
