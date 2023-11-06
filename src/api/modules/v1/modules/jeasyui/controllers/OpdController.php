<?php

namespace api\modules\v1\modules\jeasyui\controllers;

use api\modules\v1\modules\jeasyui\models\OpdSearch;

class OpdController extends \api\modules\v1\controllers\OpdController
{
    public $searchModelClass = OpdSearch::class;
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'rows'
    ];
}
