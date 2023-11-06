<?php

namespace api\modules\v1\modules\jeasyui\controllers;

use api\modules\v1\modules\jeasyui\models\JenisBiayaSppdSearch;

class JenisBiayaSppdController extends \api\modules\v1\controllers\JenisBiayaSppdController
{
    public $searchModelClass = JenisBiayaSppdSearch::class;
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'rows'
    ];
}
