<?php

namespace api\modules\v1\modules\jeasyui\models;

use sheillendra\jeasyui\components\helpers\DataFilterHelper;

class PejabatDaerahSearch extends \api\modules\v1\models\PejabatDaerahSearch {

    public function search($params)
    {
        return DataFilterHelper::prepareDataProvider(parent::search($params), $params);
    }
}