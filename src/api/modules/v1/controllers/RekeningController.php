<?php

namespace api\modules\v1\controllers;

use api\modules\v1\components\rest\ActiveController;
use api\modules\v1\models\RekeningExt;
use api\modules\v1\models\RekeningSearch;

class RekeningController extends ActiveController {

    public $modelClass = RekeningExt::class;
    public $searchModelClass = RekeningSearch::class;

}
