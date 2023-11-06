<?php

namespace api\modules\v1\modules\jeasyui\models;

use sheillendra\jeasyui\components\helpers\DataFilterHelper;

class KategoriBiayaSppdSearch extends \api\modules\v1\models\KategoriBiayaSppdSearch {

    public function search($params)
    {
        return DataFilterHelper::prepareDataProvider(parent::search($params), $params);
    }
}