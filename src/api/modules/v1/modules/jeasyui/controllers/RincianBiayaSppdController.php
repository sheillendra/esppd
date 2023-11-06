<?php

namespace api\modules\v1\modules\jeasyui\controllers;

use api\modules\v1\modules\jeasyui\models\RincianBiayaSppdSearch;

class RincianBiayaSppdController extends \api\modules\v1\controllers\RincianBiayaSppdController
{
    public $searchModelClass = RincianBiayaSppdSearch::class;
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'rows'
    ];
}
