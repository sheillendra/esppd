<?php

namespace api\modules\v1\modules\jeasyui\controllers;

use api\modules\v1\modules\jeasyui\models\PangkatGolonganSearch;

class PangkatGolonganController extends \api\modules\v1\controllers\PangkatGolonganController
{
    public $searchModelClass = PangkatGolonganSearch::class;
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'rows'
    ];
}
