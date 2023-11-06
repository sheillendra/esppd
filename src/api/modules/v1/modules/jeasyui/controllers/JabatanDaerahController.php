<?php

namespace api\modules\v1\modules\jeasyui\controllers;

use api\modules\v1\modules\jeasyui\models\JabatanDaerahSearch;

class JabatanDaerahController extends \api\modules\v1\controllers\JabatanDaerahController
{
    public $searchModelClass = JabatanDaerahSearch::class;
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'rows'
    ];
}
