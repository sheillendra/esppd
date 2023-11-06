<?php

namespace api\modules\v1\modules\jeasyui\models;

use sheillendra\jeasyui\components\helpers\DataFilterHelper;

class SppdSearch extends \api\modules\v1\models\SppdSearch
{

    public function search($params)
    {
        $provider = parent::search($params);
        $provider->query->alias('t0')->leftJoin('{{pelaksana_tugas}} t1', 't1.id = t0.pelaksana_tugas_id');
        return DataFilterHelper::prepareDataProvider($provider, $params);
    }
}
