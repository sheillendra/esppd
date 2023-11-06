<?php

namespace common\models;

use Yii;
use yii\caching\TagDependency;

class WilayahExt extends Wilayah
{

    /**
     * 
     */
    const KATEGORI_INDUK = 0;
    const KATEGORI_DALAM_DAERAH = 1;
    const KATEGORI_LUAR_DAERAH_DALAM_PROVINSI = 2;
    const KATEGORI_LUAR_DAERAH_LUAR_PROVINSI = 3;
    const KATEGORI_LUAR_NEGERI = 4;


    /**
     * 
     */
    const LABEL_KATEGORI = [
        self::KATEGORI_INDUK => 'Induk',
        self::KATEGORI_DALAM_DAERAH => 'Dalam Daerah',
        self::KATEGORI_LUAR_DAERAH_DALAM_PROVINSI => 'Luar Daerah Dalam Provinsi',
        self::KATEGORI_LUAR_DAERAH_LUAR_PROVINSI => 'Luar Daerah Luar Provinsi',
        self::KATEGORI_LUAR_NEGERI => 'Luar Negeri',
    ];

    /**
     * 
     */
    const LEVEL_NEGARA = 5;
    const LEVEL_PROVINSI = 4;
    const LEVEL_KABUPATEN_KOTA = 3;
    const LEVEL_KECAMATAN = 2;
    const LEVEL_DESA_KELURAHAN = 1;
    const LABEL_LEVEL = [
        self::LEVEL_NEGARA => 'Negara',
        self::LEVEL_PROVINSI => 'Provinsi',
        self::LEVEL_KABUPATEN_KOTA => 'Kabupaten/Kota',
        self::LEVEL_KECAMATAN => 'Kecamatan',
        self::LEVEL_DESA_KELURAHAN => 'Desa/Kelurahan',
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

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'createdBy.username' => 'Dibuat Oleh',
            'updatedBy.username' => 'Diupdate Oleh',
        ]);
    }

    public static function dataList()
    {
        return static::find()
            ->select(['nama'])
            ->where(['>', 'kategori', 0])
            ->indexBy('kode')
            ->column();
    }

    public function getKategoriLabel()
    {
        return self::LABEL_KATEGORI[$this->kategori];
    }
}
