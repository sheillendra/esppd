<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;
use yii\caching\TagDependency;

/**
 * {@inheritdoc}
 * @property SppdExt $sppd
 */
class RincianBiayaSppdExt extends RincianBiayaSppd
{

    const SCENARIO_CREATE = 'scenario_create';
    const SCENARIO_UPLOAD_BUKTI = 'uploadbukti';
    const SCENARIO_UPDATE_TOTAL_BUKTI = 'updatetotalbukti';

    /**
     * @var UploadedFile
     */
    public $pdfBuktiFile;

    /**
     * 
     * @return type
     */
    public function behaviors()
    {
        return [
            'yii\behaviors\TimestampBehavior',
            'yii\behaviors\BlameableBehavior',
            //[
            //    'class' => //'bedezign\yii2\audit\AuditTrailBehavior',
            //    'ignored' => ['detail'],
            //],
        ];
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['pdfBuktiFile'], 'required', 'on' => self::SCENARIO_UPLOAD_BUKTI],
            [['pdfBuktiFile'], 'file', 'skipOnEmpty' => true, 'mimeTypes' => 'application/pdf', 'extensions' => ['pdf']],
            [['total_bukti'], 'required', 'on' => self::SCENARIO_UPDATE_TOTAL_BUKTI],
            ['harga', 'sediaAnggaran']
        ]);
    }

    public function scenarios()
    {
        return array_merge(parent::scenarios(), [
            self::SCENARIO_CREATE => [
                'sppd_id', 'jenis_biaya_id', 'kategori_biaya_id', 'detail', 'tanggal',
                'uraian', 'volume', 'satuan_id', 'harga', 'total'
            ],
            self::SCENARIO_UPDATE_TOTAL_BUKTI => ['total_bukti', 'detail']
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'satuan_id' => 'Satuan',
            'pdf_bukti' => 'Bukti PDF',
        ]);
    }

    public function beforeValidate()
    {
        if ($this->volume && $this->harga) {
            $this->total = $this->volume * $this->harga;
        }
        return parent::beforeValidate();
    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        if ($this->sppd->status != SppdExt::STATUS_HITUNG_BIAYA) {
            $this->addError('keterangan', 'Status SPPD harus SEDANG HITUNG BIAYA');
            return false;
        }
        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSppd()
    {
        return $this->hasOne(SppdExt::className(), ['id' => 'sppd_id']);
    }

    public static function findBiayaBySppd($sppdId)
    {
        $items = static::find()
            ->alias('t0')
            ->select(['t0.*', 't1.nama', 't2.nama nama_satuan'])
            ->leftJoin('{{%jenis_biaya_sppd}} t1', 't0.jenis_biaya_id = t1.id')
            ->leftJoin('{{%satuan}} t2', 't0.satuan_id=t2.id')
            ->where(['sppd_id' => $sppdId])
            ->orderBy('t0.created_at')
            ->asArray()
            ->all();

        return \yii\helpers\ArrayHelper::index($items, 'id', [
            function ($row) {
                return $row['kategori_biaya_id'];
            }, function () {
                return 'row';
            }
        ]);
    }

    public function upload()
    {
        if ($this->validate()) {
            $path = $this->sppd->getUploadPath();
            $filename = 'bukti_' . $this->id . '_' . time() . '.' .
                $this->pdfBuktiFile->extension;
            $this->pdf_bukti = $filename;
            $this->save();
            $this->pdfBuktiFile->saveAs($path . DIRECTORY_SEPARATOR . $filename);
            return true;
        } else {
            return false;
        }
    }

    public static function totalBukti($sppdId)
    {
        return static::find()
            ->where(['sppd_id' => $sppdId])
            ->sum('CASE WHEN riil =1 THEN total ELSE total_bukti END');
    }

    public function sediaAnggaran($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if ($this->sppd->anggaran->saldo < $this->sppd->totalBiaya + ($this->harga * $this->volume)) {
                $this->addError($attribute, 'Saldo anggaran tidak mencukupi.');
            }
        }
    }
}
