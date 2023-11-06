<?php

namespace common\models;

use Yii;
use yii\caching\TagDependency;


class TahunAnggaranExt extends TahunAnggaran {

    const STATUS_BERJALAN = 1;
    const STATUS_PERSIAPAN = 2;
    const STATUS_ARSIP = 3;
    const STATUS_LABEL = [
        self::STATUS_BERJALAN => 'Tahun Anggaran Berjalan',
        self::STATUS_PERSIAPAN => 'Persiapan Anggaran Tahun Depan',
        self::STATUS_ARSIP => 'Arsip anggaran tahun-tahun sebelumnya',
    ];

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
     * 
     * @return int
     */
    public static function getTahunBerjalan() {
        $ta = static::find()
                ->where(['status_anggaran' => self::STATUS_BERJALAN])
                ->one();
        if ($ta === null) {
            $ta = new static;
            $ta->tahun = date('Y');
            $ta->status_anggaran = self::STATUS_BERJALAN;
            $ta->save();
        }
        return $ta->id;
    }

    public static function dataList() {
        return static::find()
                        ->select(['tahun'])
                        ->indexBy('id')
                        ->orderBy('tahun DESC')
                        ->column();
    }

}
