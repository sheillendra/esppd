<?php

namespace common\models;

use Yii;
use yii\caching\TagDependency;

/**
 * @property PegawaiExt $pegawai
 */
class PejabatKeuanganExt extends PejabatKeuangan {

    const STATUS_ACTIVE = 1;

    /**
     * 
     * @return type
     */
    public function behaviors() {
        return [
            'yii\behaviors\TimestampBehavior',
            'yii\behaviors\BlameableBehavior',
            //'bedezign\yii2\audit\AuditTrailBehavior',
        ];
    }

    public function rules() {
        return array_merge(parent::rules(), [
            ['status', 'default', 'value' => self::STATUS_ACTIVE,],
        ]);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), [
            'opd_id' => 'OPD',
            'opd.nama' => 'OPD',
            'jabatan_keuangan_id' => 'Jabatan Keuangan',
            'jabatanKeuangan.nama' => 'Jabatan Keuangan',
            'pegawai_id' => 'Pegawai',
            'pegawai.nama' => 'Pegawai',
            'çreated_at' => 'Dibuat pada',
            'createdBy.username' => 'Dibuat Oleh',
            'updated_at' => 'Diupdate pada',
            'updatedBy.username' => 'Diupdate Oleh',
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountAsBendaharaPengeluaranInSppd() {
        return $this->hasMany(SppdExt::className(), ['bendahara_pengeluaran_id' => 'id'])->count();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountAsPptkInSppd() {
        return $this->hasMany(SppdExt::className(), ['pelaksana_teknik_kegiatan_id' => 'id'])->count();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsBendaharaPengeluaranInSppd() {
        return $this->hasMany(SppdExt::className(), ['bendahara_pengeluaran_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPegawai() {
        return $this->hasOne(PegawaiExt::className(), ['id' => 'pegawai_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsPptkInSppd() {
        return $this->hasMany(SppdExt::className(), ['pelaksana_teknik_kegiatan_id' => 'id']);
    }

}
