<?php

namespace api\modules\v1\controllers;

use api\modules\v1\components\rest\ActiveController;
use api\modules\v1\models\JabatanDaerahSearch;

class JabatanDaerahController extends ActiveController {

    public $modelClass = 'common\models\JabatanDaerahExt';
    public $searchModelClass = JabatanDaerahSearch::class;

}
