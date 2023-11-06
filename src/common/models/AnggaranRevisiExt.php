<?php

namespace common\models;

use Yii;
use yii\caching\TagDependency;

/**
 * {@inheritdoc}
 * 
 * @property AnggaranExt $anggaran
 */
class AnggaranRevisiExt extends AnggaranRevisi {

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

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), [
            'revisi' => 'Jumlah Revisi',
            'created_at' => 'Dibuat pada tanggal',
            'createdBy.username' => 'Oleh',
            'updated_at' => 'Diubah terakhir pada',
            'updatedBy.username' => 'Oleh',
        ]);
    }

    public function attributeHints() {
        return [
            'revisi' => 'Nilai revisi bisa minus jika ingin mengurangi',
        ];
    }

    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->saldo_awal = AnggaranExt::find()
                ->select('saldo')
                ->where(['id' => $this->anggaran_id])
                ->scalar();
        $this->saldo_akhir = $this->saldo_awal + $this->revisi;
        return true;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            $this->anggaran->revisiSaldo($this->revisi);
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnggaran() {
        return $this->hasOne(AnggaranExt::class, ['id' => 'anggaran_id']);
    }

}
