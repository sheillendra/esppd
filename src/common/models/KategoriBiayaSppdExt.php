<?php

namespace common\models;

use Yii;
use yii\helpers\Inflector;

class KategoriBiayaSppdExt extends KategoriBiayaSppd
{

    /**
     * 
     */
    const KATEGORI_TRANSPORTASI = 1;
    const KATEGORI_UANG_HARIAN = 2;
    const KATEGORI_HOTEL_PENGINAPAN = 3;
    const KATEGORI_NON_PENGINAPAN = 4;
    const KATEGORI_TIKET_PESAWAT = 5;
    const KATEGORI_REPRESENTASE = 6;
    const KATEGORI_LAIN_LAIN = 7;
    const JENIS_RUTE_BERANGKAT = 1;
    const JENIS_RUTE_KEMBALI = 2;

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

    public function getDetailColumn()
    {
        $columns = [];
        foreach ($this->detail_column as $column) {
            if (empty($column)) {
                continue;
            }
            $columns[] = $column;
        }
        return $columns;
    }

    public function getDetailColumnWord()
    {
        $columns = [];
        if ($this->detail_column) {
            foreach ($this->detail_column as $column) {
                if (empty($column)) {
                    continue;
                }
                $columns[] = Inflector::camel2words(Inflector::id2camel($column, '_'));
            }
        }
        return implode(', ', $columns);
    }
}
