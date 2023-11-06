<?php

namespace common\models;

use Yii;
use yii\db\Expression;
use yii\caching\TagDependency;

/**
 * @property OpdExt $opd
 * @property SppdExt[] $sppds
 * @property SppdExt $sppd Hanya ambil satu sppd
 */
class AnggaranExt extends Anggaran {

    const SCENARIO_INSERT = 'insert';
    const SCENARIO_STATUS_KETERANGAN = 'statket';
    const SCENARIO_KURANGI_SALDO = 'kurangisaldo';

    /**
     * 
     * @return type
     */
    public function behaviors() {
        return [
            'yii\behaviors\TimestampBehavior',
            'yii\behaviors\BlameableBehavior',
            // [
            //     'class' => //'bedezign\yii2\audit\AuditTrailBehavior',
            //     'ignored' => ['saldo'],
            // ]
        ];
    }

    public function rules() {
        if ($this->scenario === self::SCENARIO_KURANGI_SALDO) {
            return [
                [
                    ['saldo'],
                    function($attribute, $params, $validator) {
                        if (!$this->{$attribute} instanceof Expression) {
                            $this->addError($attribute, 'Saldo harus dalam bentuk expression');
                        }
                    },
                    'on' => self::SCENARIO_KURANGI_SALDO
                ],
            ];
        }
        return parent::rules();
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), [
            'anggaran_id' => 'Anggaran',
            'tahun_anggaran_id' => 'TA',
            'opd_id' => 'OPD',
            'created_at' => 'Dibuat pada tanggal',
            'createdBy.username' => 'Oleh',
            'updated_at' => 'Diubah terakhir pada',
            'updatedBy.username' => 'Oleh',
        ]);
    }

    public function scenarios() {
        return array_merge(parent::scenarios(), [
            self::SCENARIO_INSERT => [
                'opd_id', 'tahun_anggaran_id', 'kode_rekening', 'kegiatan',
                'keterangan', 'jumlah', 'status'
            ],
            self::SCENARIO_STATUS_KETERANGAN => [
                'kode_rekening', 'status', 'keterangan'
            ],
            self::SCENARIO_KURANGI_SALDO => ['saldo']
        ]);
    }

    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($insert) {
            $this->saldo = $this->jumlah;
        }
        return true;
    }

    public static function dataList() {
        $query = static::find()
                ->alias('t0')
                ->select(['[[t0]].[[kode_rekening]] || \' - \' || [[t0]].[[kegiatan]] AS "kode_rekening"'])
                ->leftJoin('{{%tahun_anggaran}} t1', 't0.tahun_anggaran_id = t1.id')
                ->indexBy('id')
                ->where(['t1.status_anggaran' => TahunAnggaranExt::STATUS_BERJALAN])
        ;
        $opdAdmin = Yii::$app->user->identity->getOpdAdmin();
        if ($opdAdmin) {
            $query->andWhere(['opd_id' => $opdAdmin]);
        }
        return $query->column();
    }

    private $_nama;

    /**
     */
    public function getNama() {
        if ($this->_nama === null) {
            $this->_nama = $this->kode_rekening . ' - ' . $this->kegiatan;
        }
        return $this->_nama;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpd() {
        return $this->hasOne(OpdExt::className(), ['id' => 'opd_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSppds() {
        return $this->hasMany(SppdExt::className(), ['anggaran_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSppd() {
        return $this->hasOne(SppdExt::className(), ['anggaran_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTahunAnggaran() {
        return $this->hasOne(TahunAnggaranExt::className(), ['id' => 'tahun_anggaran_id']);
    }

    public function canEdit() {
        if ($this->sppd) {
            $this->scenario = self::SCENARIO_STATUS_KETERANGAN;
            return false;
        }
        return true;
    }

    /**
     * 
     * @param type $jumlah
     */
    public function revisiSaldo($jumlah) {
        $this->scenario = self::SCENARIO_KURANGI_SALDO;
        $this->saldo = new Expression('"saldo" + :rev', [':rev' => $jumlah]);
        if ($this->save()) {
            $this->refresh();
        } else {
            Yii::error($this->getFirstErrors());
        }
    }

    public function catatanSaldo($jumlah, $keterangan) {
        $revisi = new AnggaranRevisiExt();
        $revisi->anggaran_id = $this->id;
        $revisi->uraian = $keterangan;
        $revisi->saldo_awal = $this->saldo;
        $revisi->revisi = $jumlah;
        $revisi->saldo_akhir = $revisi->saldo_awal + $revisi->revisi;
        if (!$revisi->save()) {
            Yii::error($revisi->getFirstErrors());
        }
    }

}
