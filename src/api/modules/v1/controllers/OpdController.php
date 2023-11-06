<?php

namespace api\modules\v1\controllers;

use api\modules\v1\components\rest\ActiveController;
use api\modules\v1\models\OpdExt;
use api\modules\v1\models\OpdSearch;

class OpdController extends ActiveController {

    public $modelClass = OpdExt::class;
    public $searchModelClass = OpdSearch::class;
}
