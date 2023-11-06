<?php

namespace api\modules\v1\controllers;

use api\modules\v1\components\rest\ActiveController;
use api\modules\v1\models\WilayahSearch;
use sheillendra\jeasyui\components\helpers\TreeSerializer;

class WilayahController extends ActiveController {

    public $modelClass = 'common\models\WilayahExt';
    public $searchModelClass = WilayahSearch::class;

    public function actionTreeList(){
        $this->serializer = [
            'class' => TreeSerializer::class,
            'collectionEnvelope' => null
        ];

        // if ($this->checkAccess) {
        //     call_user_func($this->checkAccess, $this->id);
        // }

        return $this->prepareDataProvider();
    }
}
