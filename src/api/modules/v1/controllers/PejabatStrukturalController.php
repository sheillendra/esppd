<?php

namespace api\modules\v1\controllers;

use api\modules\v1\components\rest\ActiveController;
use api\modules\v1\models\PejabatStrukturalExt;
use api\modules\v1\models\PejabatStrukturalSearch;

class PejabatStrukturalController extends ActiveController {

    public $modelClass = PejabatStrukturalExt::class;
    public $searchModelClass = PejabatStrukturalSearch::class;
}
