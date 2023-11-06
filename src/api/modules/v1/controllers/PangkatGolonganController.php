<?php

namespace api\modules\v1\controllers;

use api\modules\v1\components\rest\ActiveController;
use api\modules\v1\models\PangkatGolonganSearch;

class PangkatGolonganController extends ActiveController
{

    public $modelClass = 'common\models\PangkatGolonganExt';
    public $searchModelClass = PangkatGolonganSearch::class;
}
