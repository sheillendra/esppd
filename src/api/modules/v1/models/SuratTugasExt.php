<?php

namespace api\modules\v1\models;


class SuratTugasExt extends \common\models\SuratTugasExt
{
    public function extraFields()
    {
        return ['pejabatStruktural', 'pejabatDaerah'];
    }

    /**
     * Gets query for [[PejabatDaerah]].
     *
     * @return \yii\db\ActiveQuery|PejabatDaerahQuery
     */
    public function getPejabatDaerah()
    {
        return $this->hasOne(PejabatDaerahExt::class, ['id' => 'pejabat_daerah_id']);
    }

    /**
     * Gets query for [[PejabatStruktural]].
     *
     * @return \yii\db\ActiveQuery|PejabatStrukturalQuery
     */
    public function getPejabatStruktural()
    {
        return $this->hasOne(PejabatStrukturalExt::class, ['id' => 'pejabat_struktural_id']);
    }
}
