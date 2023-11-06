<?php

namespace api\modules\v1\modules\jeasyui\controllers;

use api\modules\v1\modules\jeasyui\models\UserSearch;

class UserController extends \api\modules\v1\controllers\UserController {

    public $searchModelClass = UserSearch::class;
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'rows'
    ];

}
