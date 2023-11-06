<?php

namespace api\modules\v1\modules\jeasyui\controllers;

use api\modules\v1\modules\jeasyui\models\AnggaranSearch;

class AnggaranController extends \api\modules\v1\controllers\AnggaranController
{
    public $searchModelClass = AnggaranSearch::class;
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'rows'
    ];
}
