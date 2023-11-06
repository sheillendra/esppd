<?php

namespace api\modules\v1\models;


class AnggaranExt extends \common\models\AnggaranExt
{
    public function extraFields()
    {
        return ['sppds'];
    }

    
}
