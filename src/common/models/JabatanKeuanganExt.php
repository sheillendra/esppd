<?php

namespace common\models;

use Yii;
use yii\caching\TagDependency;

class JabatanKeuanganExt extends JabatanKeuangan
{

    const JABATAN_PENGGUNA_ANGGARAN = 1;
    const JABATAN_PELAKSANA_TEKNIK = 4;
    const JABATAN_BENDAHARA_PENGELUARAN = 5;
    const JABATAN_PENATAUSAHAAN_KEUANGAN = 8;
    const JABATAN_ON_ROLE = [
        self::JABATAN_BENDAHARA_PENGELUARAN => UserExt::ROLE_BENDAHARA_PENGELUARAN
    ];

    /**
     * 
     * @return type
     */
    public function behaviors()
    {
        return [
            'yii\behaviors\TimestampBehavior',
            'yii\behaviors\BlameableBehavior',
            //'bedezign\yii2\audit\AuditTrailBehavior',
        ];
    }

    public static function dataList()
    {
        return static::find()
            ->select(['nama'])
            ->indexBy('id')
            ->column();
    }
}
