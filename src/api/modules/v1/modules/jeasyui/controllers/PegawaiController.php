<?php

namespace api\modules\v1\modules\jeasyui\controllers;

use api\modules\v1\modules\jeasyui\models\PegawaiSearch;

class PegawaiController extends \api\modules\v1\controllers\PegawaiController
{
    public $searchModelClass = PegawaiSearch::class;
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'rows'
    ];
}
