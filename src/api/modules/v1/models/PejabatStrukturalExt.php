<?php

namespace api\modules\v1\models;


class PejabatStrukturalExt extends \common\models\PejabatStrukturalExt
{
    public function extraFields()
    {
        return ['jabatanStruktural', 'pegawai', 'produkHukum'];
    }
}
