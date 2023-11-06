<?php

namespace api\modules\v1\controllers;

use api\modules\v1\components\rest\ActiveController;
use api\modules\v1\models\JenisBiayaSppdExt;
use api\modules\v1\models\JenisBiayaSppdSearch;

class JenisBiayaSppdController extends ActiveController {

    public $modelClass = JenisBiayaSppdExt::class;
    public $searchModelClass = JenisBiayaSppdSearch::class;

}
