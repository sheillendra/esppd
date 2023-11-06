<?php

namespace api\modules\v1\modules\jeasyui\controllers;

use api\modules\v1\modules\jeasyui\models\ProdukHukumSearch;

class ProdukHukumController extends \api\modules\v1\controllers\ProdukHukumController
{
    public $searchModelClass = ProdukHukumSearch::class;
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'rows'
    ];
}
