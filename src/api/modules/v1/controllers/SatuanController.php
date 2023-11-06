<?php

namespace api\modules\v1\controllers;

use api\modules\v1\components\rest\ActiveController;
use api\modules\v1\models\SatuanExt;
use api\modules\v1\models\SatuanSearch;

class SatuanController extends ActiveController {

    public $modelClass = SatuanExt::class;
    public $searchModelClass = SatuanSearch::class;

}
