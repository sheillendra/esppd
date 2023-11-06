<?php

namespace api\modules\v1\modules\jeasyui\controllers;

use api\modules\v1\modules\jeasyui\models\PendudukSearch;

class PendudukController extends \api\modules\v1\controllers\PendudukController
{
    public $searchModelClass = PendudukSearch::class;
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'rows'
    ];
}
