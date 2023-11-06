<?php

namespace api\modules\v1\controllers;

use api\modules\v1\components\rest\ActiveController;
use api\modules\v1\models\KategoriBiayaSppdExt;
use api\modules\v1\models\KategoriBiayaSppdSearch;

class KategoriBiayaSppdController extends ActiveController {

    public $modelClass = KategoriBiayaSppdExt::class;
    public $searchModelClass = KategoriBiayaSppdSearch::class;

}
