<?php

namespace api\modules\v1\controllers;

use api\modules\v1\components\rest\ActiveController;
use api\modules\v1\models\JabatanStrukturalExt;
use api\modules\v1\models\JabatanStrukturalSearch;

class JabatanStrukturalController extends ActiveController {

    public $modelClass = JabatanStrukturalExt::class;
    public $searchModelClass = JabatanStrukturalSearch::class;
}
