<?php

namespace api\modules\v1\controllers;

use api\modules\v1\components\rest\ActiveController;
use api\modules\v1\models\PejabatDaerahExt;
use api\modules\v1\models\PejabatDaerahSearch;

class PejabatDaerahController extends ActiveController
{

    public $modelClass = PejabatDaerahExt::class;
    public $searchModelClass = PejabatDaerahSearch::class;
}
