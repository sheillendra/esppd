<?php

namespace api\modules\v1\models;


class KategoriBiayaSppdExt extends \common\models\KategoriBiayaSppdExt
{
    public function extraFields()
    {
        return ['jenisBiayaSppds'];
    }
}
