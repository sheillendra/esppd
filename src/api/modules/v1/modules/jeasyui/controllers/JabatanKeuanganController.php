<?php

namespace api\modules\v1\modules\jeasyui\controllers;

use api\modules\v1\modules\jeasyui\models\JabatanKeuanganSearch;

class JabatanKeuanganController extends \api\modules\v1\controllers\JabatanKeuanganController
{
    public $searchModelClass = JabatanKeuanganSearch::class;
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'rows'
    ];
}
