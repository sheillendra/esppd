<?php

namespace api\modules\v1\modules\jeasyui\controllers;

use api\modules\v1\modules\jeasyui\models\RekeningSearch;

class RekeningController extends \api\modules\v1\controllers\RekeningController
{
    public $searchModelClass = RekeningSearch::class;
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'rows'
    ];
}
