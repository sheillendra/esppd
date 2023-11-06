<?php

namespace api\modules\v1\modules\jeasyui\controllers;

use api\modules\v1\modules\jeasyui\models\WilayahSearch;

class WilayahController extends \api\modules\v1\controllers\WilayahController
{
    public $searchModelClass = WilayahSearch::class;
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'rows'
    ];
}
