<?php

namespace api\modules\v1\controllers;

use api\modules\v1\components\rest\ActiveController;
use api\modules\v1\models\RincianBiayaSppdExt;
use api\modules\v1\models\RincianBiayaSppdSearch;

class RincianBiayaSppdController extends ActiveController {

    public $modelClass = RincianBiayaSppdExt::class;
    public $searchModelClass = RincianBiayaSppdSearch::class;
}
