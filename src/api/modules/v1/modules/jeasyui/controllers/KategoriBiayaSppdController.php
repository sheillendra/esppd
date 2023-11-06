<?php

namespace api\modules\v1\modules\jeasyui\controllers;

use api\modules\v1\modules\jeasyui\models\KategoriBiayaSppdSearch;

class KategoriBiayaSppdController extends \api\modules\v1\controllers\KategoriBiayaSppdController
{
    public $searchModelClass = KategoriBiayaSppdSearch::class;
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'rows'
    ];
}
