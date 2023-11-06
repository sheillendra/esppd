<?php

namespace api\modules\v1\models;


class PejabatDaerahExt extends \common\models\PejabatDaerahExt
{
    public function extraFields()
    {
        return ['jabatanDaerah', 'penduduk', 'produkHukum'];
    }
}
