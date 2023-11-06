<?php

namespace api\modules\v1\controllers;

use api\modules\v1\components\rest\ActiveController;
use api\modules\v1\models\EselonSearch;

class EselonController extends ActiveController
{

    public $modelClass = 'common\models\EselonExt';
    public $searchModelClass = EselonSearch::class;
}
