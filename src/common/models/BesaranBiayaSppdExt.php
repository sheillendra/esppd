<?php

namespace common\models;

use Yii;

class BesaranBiayaSppdExt extends BesaranBiayaSppd {

    const STATUS_NOT_ACTIVE = 0;
    const STATUS_ACTIVE = 1;
    
    /**
     * 
     * @return type
     */
    public function behaviors() {
        return [
            'yii\behaviors\TimestampBehavior',
            'yii\behaviors\BlameableBehavior',
            //'bedezign\yii2\audit\AuditTrailBehavior'
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return array_merge(parent::rules(), [
            [['pangkat_golongan_id', 'eselon_id'], 'default', 'value' => null],
        ]);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), [
            'eselon_id' => 'Eselon',
            'pangkat_golongan_id' => 'Golongan',
            'jabatan_daerah_id' => 'Jabatan Daerah',
            'jabatan_struktural_id' => 'Jabatan Struktural',
            'jenis_biaya_sppd_id' => 'Jenis Biaya',
        ]);
    }
    
}
