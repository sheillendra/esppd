<?php

namespace api\modules\v1\models;


class BesaranBiayaSppdExt extends \common\models\BesaranBiayaSppdExt
{
    public function extraFields()
    {
        return ['jenisBiayaSppd'];
    }
}
