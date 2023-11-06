<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $verification_token
 * @property string|null $access_token
 * @property string|null $profile
 *
 * @property Anggaran[] $anggarans
 * @property Anggaran[] $anggarans0
 * @property AnggaranRevisi[] $anggaranRevisis
 * @property AnggaranRevisi[] $anggaranRevisis0
 * @property Auth[] $auths
 * @property BesaranBiayaSppd[] $besaranBiayaSppds
 * @property BesaranBiayaSppd[] $besaranBiayaSppds0
 * @property Eselon[] $eselons
 * @property Eselon[] $eselons0
 * @property JabatanDaerah[] $jabatanDaerahs
 * @property JabatanDaerah[] $jabatanDaerahs0
 * @property JabatanKeuangan[] $jabatanKeuangans
 * @property JabatanKeuangan[] $jabatanKeuangans0
 * @property JabatanStruktural[] $jabatanStrukturals
 * @property JabatanStruktural[] $jabatanStrukturals0
 * @property JenisBiayaSppd[] $jenisBiayaSppds
 * @property JenisBiayaSppd[] $jenisBiayaSppds0
 * @property KategoriBiayaSppd[] $kategoriBiayaSppds
 * @property KategoriBiayaSppd[] $kategoriBiayaSppds0
 * @property Opd[] $opds
 * @property Opd[] $opds0
 * @property PangkatGolongan[] $pangkatGolongans
 * @property PangkatGolongan[] $pangkatGolongans0
 * @property Pegawai[] $pegawais
 * @property Pegawai[] $pegawais0
 * @property Pegawai[] $pegawais1
 * @property PejabatDaerah[] $pejabatDaerahs
 * @property PejabatDaerah[] $pejabatDaerahs0
 * @property PejabatKeuangan[] $pejabatKeuangans
 * @property PejabatKeuangan[] $pejabatKeuangans0
 * @property PejabatStruktural[] $pejabatStrukturals
 * @property PejabatStruktural[] $pejabatStrukturals0
 * @property PelaksanaTugas[] $pelaksanaTugas
 * @property PelaksanaTugas[] $pelaksanaTugas0
 * @property Penduduk[] $penduduks
 * @property Penduduk[] $penduduks0
 * @property Penduduk[] $penduduks1
 * @property ProdukHukum[] $produkHukums
 * @property ProdukHukum[] $produkHukums0
 * @property RincianBiayaSppd[] $rincianBiayaSppds
 * @property RincianBiayaSppd[] $rincianBiayaSppds0
 * @property Satuan[] $satuans
 * @property Satuan[] $satuans0
 * @property Sppd[] $sppds
 * @property Sppd[] $sppds0
 * @property SuratTugas[] $suratTugas
 * @property SuratTugas[] $suratTugas0
 * @property TahunAnggaran[] $tahunAnggarans
 * @property TahunAnggaran[] $tahunAnggarans0
 * @property Wilayah[] $wilayahs
 * @property Wilayah[] $wilayahs0
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['profile'], 'safe'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'verification_token', 'access_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'verification_token' => 'Verification Token',
            'access_token' => 'Access Token',
            'profile' => 'Profile',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnggarans()
    {
        return $this->hasMany(Anggaran::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnggarans0()
    {
        return $this->hasMany(Anggaran::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnggaranRevisis()
    {
        return $this->hasMany(AnggaranRevisi::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnggaranRevisis0()
    {
        return $this->hasMany(AnggaranRevisi::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuths()
    {
        return $this->hasMany(Auth::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBesaranBiayaSppds()
    {
        return $this->hasMany(BesaranBiayaSppd::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBesaranBiayaSppds0()
    {
        return $this->hasMany(BesaranBiayaSppd::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEselons()
    {
        return $this->hasMany(Eselon::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEselons0()
    {
        return $this->hasMany(Eselon::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJabatanDaerahs()
    {
        return $this->hasMany(JabatanDaerah::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJabatanDaerahs0()
    {
        return $this->hasMany(JabatanDaerah::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJabatanKeuangans()
    {
        return $this->hasMany(JabatanKeuangan::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJabatanKeuangans0()
    {
        return $this->hasMany(JabatanKeuangan::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJabatanStrukturals()
    {
        return $this->hasMany(JabatanStruktural::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJabatanStrukturals0()
    {
        return $this->hasMany(JabatanStruktural::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJenisBiayaSppds()
    {
        return $this->hasMany(JenisBiayaSppd::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJenisBiayaSppds0()
    {
        return $this->hasMany(JenisBiayaSppd::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKategoriBiayaSppds()
    {
        return $this->hasMany(KategoriBiayaSppd::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKategoriBiayaSppds0()
    {
        return $this->hasMany(KategoriBiayaSppd::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpds()
    {
        return $this->hasMany(Opd::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpds0()
    {
        return $this->hasMany(Opd::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPangkatGolongans()
    {
        return $this->hasMany(PangkatGolongan::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPangkatGolongans0()
    {
        return $this->hasMany(PangkatGolongan::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPegawais()
    {
        return $this->hasMany(Pegawai::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPegawais0()
    {
        return $this->hasMany(Pegawai::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPegawais1()
    {
        return $this->hasMany(Pegawai::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPejabatDaerahs()
    {
        return $this->hasMany(PejabatDaerah::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPejabatDaerahs0()
    {
        return $this->hasMany(PejabatDaerah::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPejabatKeuangans()
    {
        return $this->hasMany(PejabatKeuangan::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPejabatKeuangans0()
    {
        return $this->hasMany(PejabatKeuangan::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPejabatStrukturals()
    {
        return $this->hasMany(PejabatStruktural::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPejabatStrukturals0()
    {
        return $this->hasMany(PejabatStruktural::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPelaksanaTugas()
    {
        return $this->hasMany(PelaksanaTugas::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPelaksanaTugas0()
    {
        return $this->hasMany(PelaksanaTugas::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPenduduks()
    {
        return $this->hasMany(Penduduk::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPenduduks0()
    {
        return $this->hasMany(Penduduk::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPenduduks1()
    {
        return $this->hasMany(Penduduk::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProdukHukums()
    {
        return $this->hasMany(ProdukHukum::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProdukHukums0()
    {
        return $this->hasMany(ProdukHukum::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRincianBiayaSppds()
    {
        return $this->hasMany(RincianBiayaSppd::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRincianBiayaSppds0()
    {
        return $this->hasMany(RincianBiayaSppd::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSatuans()
    {
        return $this->hasMany(Satuan::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSatuans0()
    {
        return $this->hasMany(Satuan::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSppds()
    {
        return $this->hasMany(Sppd::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSppds0()
    {
        return $this->hasMany(Sppd::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSuratTugas()
    {
        return $this->hasMany(SuratTugas::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSuratTugas0()
    {
        return $this->hasMany(SuratTugas::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTahunAnggarans()
    {
        return $this->hasMany(TahunAnggaran::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTahunAnggarans0()
    {
        return $this->hasMany(TahunAnggaran::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWilayahs()
    {
        return $this->hasMany(Wilayah::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWilayahs0()
    {
        return $this->hasMany(Wilayah::className(), ['updated_by' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }
}
