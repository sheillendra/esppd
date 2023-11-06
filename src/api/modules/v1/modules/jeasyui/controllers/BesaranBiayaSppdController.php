<?php

namespace api\modules\v1\modules\jeasyui\controllers;

use api\modules\v1\modules\jeasyui\models\BesaranBiayaSppdSearch;

class BesaranBiayaSppdController extends \api\modules\v1\controllers\BesaranBiayaSppdController
{
    public $searchModelClass = BesaranBiayaSppdSearch::class;
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'rows'
    ];
}
