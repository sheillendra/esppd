<?php

namespace common\models;

use Yii;
use yii\caching\TagDependency;

/**
 * @property PendudukExt $penduduk
 */
class PejabatDaerahExt extends PejabatDaerah {

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

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), [
            'jabatan_daerah_id' => 'Jabatan Daerah',
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPenduduk() {
        return $this->hasOne(PendudukExt::className(), ['id' => 'penduduk_id']);
    }

    public function generateUser() {
        $result = [
            'success' => true,
            'message' => 'Pejabat ini sudah mempunyai user akun'
        ];
        if ($this->penduduk->user_id && !$this->penduduk->user->can(UserExt::ROLE_PEJABAT_DAERAH)) {
            $this->penduduk->user->assign(UserExt::ROLE_PEJABAT_DAERAH);
            $result['message'] = 'Role PEJABAT sudah diberikan ke pada user ini';
        } else {
            $result = $this->penduduk->generateNewUser(UserExt::ROLE_PEJABAT_DAERAH);
            $result['user']->assign(UserExt::ROLE_PEJABAT_DAERAH);
        }
        return $result;
    }

}
