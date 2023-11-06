<?php

namespace common\models;

use Yii;
use yii\caching\TagDependency;

/**
 * 
 * @property PejabatStruktural[] $pejabatStrukturals
 * @property PejabatStruktural $pejabatStruktural
 * @property PejabatKeuanganExt[] $pejabatKeuangans
 * @property PejabatKeuanganExt $pejabatKeuangan
 * @property PelaksanaTugasExt[] $pelaksanaTugas
 * @property UserExt $user
 * @property bool $sppdActive
 * @property string $nama
 * 
 */
class PegawaiExt extends Pegawai
{

    const STATUS_ACTIVE = 1;

    /**
     * 
     * @return type
     */
    public function behaviors()
    {
        return [
            'yii\behaviors\TimestampBehavior',
            'yii\behaviors\BlameableBehavior',
            //'bedezign\yii2\audit\AuditTrailBehavior'
        ];
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            [['gelar_depan', 'gelar_belakang'], 'default', 'value' => null]
        ]);
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields['nama_lengkap'] = function () {
            return $this->namaLengkap;
        };
        return $fields;
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'Nama Pegawai',
            'pangkat_golongan_id' => 'Pangk./Gol.',
            'eselon_id' => 'Eselon',
            'opd_id' => 'OPD',
            'opd.nama' => 'OPD',
            'created_at' => 'Dibuat pada',
            'createdBy.username' => 'Dibuat oleh',
            'updated_at' => 'Diubah pada',
            'updatedBy.username' => 'Diubah oleh'
        ]);
    }

    public function getNamaLengkap()
    {
        return ($this->gelar_depan ? $this->gelar_depan . ' ' : '') .
            $this->nama_tanpa_gelar .
            ($this->gelar_belakang ? ', ' . $this->gelar_belakang : '');
    }

    public function getPangkatGolongan()
    {
        return $this->hasOne(PangkatGolonganExt::class, ['kode' => 'pangkat_golongan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPejabatStrukturals()
    {
        return $this->hasMany(PejabatStrukturalExt::class, ['pegawai_id' => 'id'])
            ->alias('t0')
            ->leftJoin('{{produk_hukum}} t1', 't0.produk_hukum_id = t1.id')
            ->where(['t1.status' => 1])
            ->orderBy('t0.created_at DESC');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPejabatStruktural()
    {
        return $this->hasOne(PejabatStrukturalExt::class, ['pegawai_id' => 'id'])
            ->alias('t0')
            ->leftJoin('{{produk_hukum}} t1', 't0.produk_hukum_id = t1.id')
            ->where(['t1.status' => 1])
            ->orderBy('t0.created_at DESC');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPejabatKeuangans()
    {
        return $this->hasMany(PejabatKeuanganExt::class, ['pegawai_id' => 'id'])
            ->alias('t0')
            ->leftJoin('{{produk_hukum}} t1', 't0.produk_hukum_id = t1.id')
            ->where(['t1.status' => 1])
            ->orderBy('t0.created_at DESC');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPejabatKeuangan()
    {
        return $this->hasOne(PejabatKeuanganExt::class, ['pegawai_id' => 'id'])
            ->alias('t0')
            ->leftJoin('{{produk_hukum}} t1', 't0.produk_hukum_id = t1.id')
            ->where(['t1.status' => 1])
            ->orderBy('t0.created_at DESC');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPelaksanaTugas()
    {
        return $this->hasMany(PelaksanaTugasExt::class, ['pegawai_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSppdActive()
    {
        return $this->hasMany(PelaksanaTugasExt::className(), ['pegawai_id' => 'id'])
            ->alias('t0')
            ->rightJoin('{{%sppd}} t1', 't1.pelaksana_tugas_id = t0.id')
            ->andWhere(['<', 't1.status', SppdExt::STATUS_HITUNG_RAMPUNG])
            ->count();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        //hasOne db nya tidak bisa ke cache
        //return $this->hasOne(UserExt::className(), ['id' => 'user_id']);
        return UserExt::findOne(['id' => $this->user_id]);
    }

    public function generateNewUser()
    {
        $result = [
            'success' => false,
            'message' => 'Mulai User Baru',
        ];

        $password = rand(111111, 999999);
        $user = new UserExt();
        $user->username = $this->nip;
        $user->email = $this->nip . getenv('EMAIL_DOMAIN');
        $user->setPassword($password);
        $user->status = UserExt::STATUS_ACTIVE;
        $user->created_at = time();
        $user->updated_at = time();
        $user->generateAuthKey();
        if ($user->save()) {
            $this->user_id = $user->id;
            $this->save();
            $user->assign($user::ROLE_ASN);
            $result['success'] = true;
            $result['message'] = 'Generate akun sukses <code>NIP</code> sebagai username dan password: <code>' . $password . '</code>';
        } else {
            $result['message'] = implode(', ', $user->getFirstErrors());
        }

        return $result;
    }

    /**
     * 
     * @param \common\models\UserExt $user
     */
    public function existingUser($user)
    {
        $result = ['success' => false, 'message' => 'Mulai user yang sudah ada'];
        $this->user_id = $user->id;
        if ($this->save()) {
            $user->assign($user::ROLE_ASN);
            $result['success'] = true;
            $result['message'] = 'Pegawai ini sebelumnya sudah mempunyai akun'
                . ' namun belum terhubung, sekarang akun dan pegawai sudah'
                . ' terhubung kembali.';
        } else {
            $result['message'] = implode(', ', $this->getFirstErrors());
            Yii::error($this->getFirstErrors());
        }
        return $result;
    }

    public static function getTotalPegawai()
    {
        $query = static::find();
        if (Yii::$app->user->identity->opdAdmin) {
            $query->where(['opd_id' => Yii::$app->user->identity->opdAdmin]);
        }
        return $query->count();
    }
}
