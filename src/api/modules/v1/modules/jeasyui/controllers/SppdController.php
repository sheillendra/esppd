<?php

namespace api\modules\v1\modules\jeasyui\controllers;

use api\modules\v1\modules\jeasyui\models\SppdSearch;

class SppdController extends \api\modules\v1\controllers\SppdController
{
    public $searchModelClass = SppdSearch::class;
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'rows'
    ];
}
