<?php

namespace api\modules\v1\models;


class SatuanExt extends \common\models\SatuanExt
{
    public function extraFields()
    {
        return ['jenisBiayaSppds'];
    }
}
