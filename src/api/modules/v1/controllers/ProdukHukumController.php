<?php

namespace api\modules\v1\controllers;

use api\modules\v1\components\rest\ActiveController;
use api\modules\v1\models\ProdukHukumSearch;

class ProdukHukumController extends ActiveController {

    public $modelClass = 'common\models\ProdukHukumExt';
    public $searchModelClass = ProdukHukumSearch::class;

}
