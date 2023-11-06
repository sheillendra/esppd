<?php

namespace api\modules\v1\controllers;

use api\modules\v1\components\rest\ActiveController;
use api\modules\v1\models\AnggaranExt;
use api\modules\v1\models\AnggaranSearch;

class AnggaranController extends ActiveController {

    public $modelClass = AnggaranExt::class;
    public $searchModelClass = AnggaranSearch::class;

}
