<?php

namespace api\modules\v1\models;


class RekeningExt extends \common\models\RekeningExt
{
    public function extraFields()
    {
        return ['anggarans'];
    }

    
}
