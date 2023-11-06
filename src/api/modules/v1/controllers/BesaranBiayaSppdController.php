<?php

namespace api\modules\v1\controllers;

use api\modules\v1\components\rest\ActiveController;
use api\modules\v1\models\BesaranBiayaSppdExt;
use api\modules\v1\models\BesaranBiayaSppdSearch;

class BesaranBiayaSppdController extends ActiveController {

    public $modelClass = BesaranBiayaSppdExt::class;
    public $searchModelClass = BesaranBiayaSppdSearch::class;

}
