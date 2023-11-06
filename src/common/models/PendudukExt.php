<?php

namespace common\models;

use Yii;
use yii\caching\TagDependency;

/**
 * @property PejabatDaerahExt[] $pejabatDaerahs Jabatan yang dijabat oleh penduduk dalam bentuk array object
 * @property PejabatDaerahExt $pejabatDaerah Jabatan yang dijabat oleh penduduk dalam bentuk object
 * @property UserExt $user
 * @property string $nama
 */
class PendudukExt extends Penduduk
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
            //'bedezign\yii2\audit\AuditTrailBehavior',
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields['nama_lengkap'] = function () {
            return $this->namaLengkap;
        };
        return $fields;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            [['gelar_depan', 'gelar_belakang'], 'default', 'value' => null]
        ]);
    }

    public function getNamaLengkap()
    {
        return ($this->gelar_depan ? $this->gelar_depan . ' ' : '') .
            $this->nama_tanpa_gelar .
            ($this->gelar_belakang ? ', ' . $this->gelar_belakang : '');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPejabatDaerahs()
    {
        return $this->hasMany(PejabatDaerahExt::className(), ['penduduk_id' => 'id'])
            ->alias('t0')
            ->leftJoin('{{produk_hukum}} t1', 't0.produk_hukum_id = t1.id')
            ->where(['t1.status' => 1])
            ->orderBy('t0.created_at DESC');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPejabatDaerah()
    {
        return $this->hasOne(PejabatDaerahExt::className(), ['penduduk_id' => 'id'])
            ->alias('t0')
            ->leftJoin('{{produk_hukum}} t1', 't0.produk_hukum_id = t1.id')
            ->where(['t1.status' => 1])
            ->orderBy('t0.created_at DESC');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(UserExt::className(), ['id' => 'user_id']);
    }

    public function generateUser()
    {
        $result = [
            'success' => false,
            'message' => 'Penduduk ini sudah ada user account',
        ];
        if ($this->user_id) {
            if (!$this->user->can(UserExt::ROLE_PENDUDUK)) {
                $this->user->assign(UserExt::ROLE_PENDUDUK);
                $result['message'] = 'Role PENDUDUK sudah diberikan ke pada user ini';
            }
        } else {
            $result = $this->generateNewUser(UserExt::ROLE_PENDUDUK);
            $result['user']->assign(UserExt::ROLE_PENDUDUK);
        }
        return $result;
    }

    /**
     * 
     * @return UserExt[user] Description
     */
    public function generateNewUser()
    {
        $result = ['success' => false, 'message' => ''];
        $password = rand(111111, 999999);
        $user = new UserExt();
        $user->username = $this->nik;
        $user->email = $this->nik . '@haltim.go.id';
        $user->setPassword($password);
        $user->status = UserExt::STATUS_ACTIVE;
        $user->created_at = time();
        $user->updated_at = time();
        $user->generateAuthKey();
        if ($user->save()) {
            $this->user_id = $user->id;
            if ($this->save()) {
                $result['success'] = true;
                $result['user'] = $user;
                $result['message'] = 'Sukses generate user untuk <kbd>' . $this->nama .
                    '</kbd> username <kbd>' . $this->nik .
                    '</kbd> password: <kbd>' . $password . '</kbd>';
            } else {
                $result['message'] = $this->getFirstErrors();
            }
        } else {
            $result['message'] = $user->getFirstErrors();
        }
        return $result;
    }
}
