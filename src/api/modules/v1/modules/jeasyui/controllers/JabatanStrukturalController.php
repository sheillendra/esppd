<?php

namespace api\modules\v1\modules\jeasyui\controllers;

use api\modules\v1\modules\jeasyui\models\JabatanStrukturalSearch;

class JabatanStrukturalController extends \api\modules\v1\controllers\JabatanStrukturalController
{
    public $searchModelClass = JabatanStrukturalSearch::class;
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'rows'
    ];
}
