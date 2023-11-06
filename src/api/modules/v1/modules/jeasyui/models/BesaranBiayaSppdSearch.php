<?php

namespace api\modules\v1\modules\jeasyui\models;

use sheillendra\jeasyui\components\helpers\DataFilterHelper;

class BesaranBiayaSppdSearch extends \api\modules\v1\models\BesaranBiayaSppdSearch {

    public function search($params)
    {
        return DataFilterHelper::prepareDataProvider(parent::search($params), $params);
    }
}