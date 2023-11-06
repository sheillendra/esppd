<?php

namespace api\modules\v1\modules\jeasyui\controllers;

use api\modules\v1\modules\jeasyui\models\PejabatStrukturalSearch;

class PejabatStrukturalController extends \api\modules\v1\controllers\PejabatStrukturalController
{
    public $searchModelClass = PejabatStrukturalSearch::class;
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'rows'
    ];
}
