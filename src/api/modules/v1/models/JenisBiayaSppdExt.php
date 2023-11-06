<?php

namespace api\modules\v1\models;


class JenisBiayaSppdExt extends \common\models\JenisBiayaSppdExt
{
    public function extraFields()
    {
        return ['kategoriBiayaSppd'];
    }
}
