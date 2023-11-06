<?php

namespace api\modules\v1\models;


class SppdExt extends \common\models\SppdExt
{
    public function extraFields()
    {
        return ['pelaksanaTugas', 'anggaran'];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPelaksanaTugas()
    {
        return $this->hasOne(PelaksanaTugasExt::class, ['id' => 'pelaksana_tugas_id']);
    }
    
}
