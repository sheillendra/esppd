<?php

namespace api\modules\v1\modules\jeasyui\controllers;

use api\modules\v1\modules\jeasyui\models\PejabatDaerahSearch;

class PejabatDaerahController extends \api\modules\v1\controllers\PejabatDaerahController
{
    public $searchModelClass = PejabatDaerahSearch::class;
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'rows'
    ];
}
