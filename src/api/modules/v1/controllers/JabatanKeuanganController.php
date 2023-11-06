<?php

namespace api\modules\v1\controllers;

use api\modules\v1\components\rest\ActiveController;
use api\modules\v1\models\JabatanKeuanganSearch;

class JabatanKeuanganController extends ActiveController {

    public $modelClass = 'common\models\JabatanKeuanganExt';
    public $searchModelClass = JabatanKeuanganSearch::class;
}
