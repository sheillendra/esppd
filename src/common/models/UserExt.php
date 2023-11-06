<?php

namespace common\models;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Yii;
use yii\web\IdentityInterface;
use yii\helpers\Html;
use yii\caching\TagDependency;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property PendudukExt $pendudukAsProfile
 * @property PegawaiExt $pegawaiAsProfile
 */
class UserExt extends User implements IdentityInterface
{

    const SCENARIO_RENEW_ACCESS_TOKEN = 'renewaccesstoken';

    /**
     * Status
     */
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;
    const STATUS_LABEL = [
        self::STATUS_DELETED => 'Deleted',
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_ACTIVE => 'Active',
    ];
    const ROLE_SUPERADMIN = 'superadmin';
    const ROLE_ADMIN = 'admin';
    const ROLE_ADMIN_OPD = 'adminopd';
    const ROLE_ASN = 'asn';
    const ROLE_PENDUDUK = 'penduduk';
    const ROLE_PEJABAT_DAERAH = 'pejabatdaerah';
    const ROLE_BENDAHARA_PENGELUARAN = 'bendaharapengeluaran';

    /**
     * 
     */
    const ROLE_LABEL = [
        self::ROLE_SUPERADMIN => 'Superadmin',
        self::ROLE_ADMIN_OPD => 'Admin OPD',
        self::ROLE_ASN => 'ASN',
        self::ROLE_PEJABAT_DAERAH => 'Pejabat Daerah',
        self::ROLE_PENDUDUK => 'Penduduk',
    ];

    /**
     * role level
     */
    const ROLE_SUPERADMIN_LEVEL = 1;
    const ROLE_ADMIN_LEVEL = 10;
    const ROLE_ADMIN_OPD_LEVEL = 20;
    const ROLE_BENDAHARA_PENGELUARAN_LEVEL = 30;
    const ROLE_ASN_LEVEL = 40;
    const ROLE_PEJABAT_DAERAH_LEVEL = 40;
    const ROLE_PENDUDUK_LEVEL = 40;

    /**
     * 
     */
    private $_allRoles;
    private $_nama;
    private $_namaLink;
    private $_opdName;
    private $_opdId;

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
    public function behaviors()
    {
        return [
            'yii\behaviors\TimestampBehavior',
            //'bedezign\yii2\audit\AuditTrailBehavior'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
        ];
    }

    public function scenarios()
    {
        return array_merge(parent::scenarios(), [
            self::SCENARIO_RENEW_ACCESS_TOKEN => ['access_token']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $key = new Key(Yii::$app->params['jwtKey'], 'HS256');
        $data = JWT::decode($token, $key);
        if (!isset($data->id) && $data->id) {
            return null;
        }
        return static::findOne(['id' => $data->id, 'status' => self::STATUS_ACTIVE]);
        //return static::findOne(['access_token' => $token, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token)
    {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new password reset token
     */
    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }
        $this->status = self::STATUS_DELETED;
        $this->save();
        return false;
    }

    public function assign($roleName)
    {
        $result = [
            'success' => 1,
            'message' => 'Assign role is success'
        ];

        try {
            $auth = Yii::$app->authManager;
            $role = $auth->getRole($roleName);
            $auth->assign($role, $this->id);
        } catch (\Exception $ex) {
            $result['success'] = 0;
            $result['message'] = $ex->getMessage();
        }
        return $result;
    }

    public function revoke($roleName)
    {
        $result = [
            'success' => 1,
            'message' => 'Revoke role is success'
        ];

        try {
            $auth = Yii::$app->authManager;
            $role = $auth->getRole($roleName);
            $auth->revoke($role, $this->id);
        } catch (\Exception $ex) {
            $result['success'] = 0;
            $result['message'] = $ex->getMessage();
        }
        return $result;
    }

    /**
     * RBAC for specific user
     * 
     * @param string $roleName
     * @return boolean
     */
    public function can($roleName)
    {
        return Yii::$app->authManager->checkAccess($this->id, $roleName);
    }

    /**
     * 
     * @return integer
     */
    public function getMaxLevel()
    {
        return (int) $this->getDb()->createCommand(
            <<<SQL
            SELECT
                MIN(tt1.level) as max_level
            FROM {{%auth_assignment}} tt0
            LEFT JOIN {$this->authItemWithLevel} tt1 
                ON tt0.item_name = tt1.name
            WHERE tt0.user_id = :uid
            GROUP BY tt0.user_id
SQL,
            [':uid' => (string)$this->id]
        )->queryScalar();
    }

    /**
     * 
     * @return string
     */
    public function getAllRoles($id = null)
    {
        if ($id === null) {
            $id = $this->id;
        }

        if ($this->_allRoles === null) {
            $this->_allRoles = $this->getDb()->createCommand(
                <<<SQL
    SELECT
        STRING_AGG(tt0.item_name, ', ' ORDER BY tt1.level)
    FROM {{%auth_assignment}} tt0
    LEFT JOIN {$this->authItemWithLevel} tt1 
        ON tt0.item_name = tt1.name
    WHERE tt0.user_id = :uid
    GROUP BY tt0.user_id
SQL,
                [':uid' => (string)$this->id]
            )->queryScalar();
        }
        return $this->_allRoles;
    }

    public function getAllRolesWithLabel()
    {
        return strtr($this->allRoles, self::ROLE_LABEL);
    }

    /**
     *
     * @var string SQL 
     */
    public $authItemWithLevel = <<<SQL
        (
            SELECT 
                *,
                ENCODE(SUBSTRING(
                  "data",
                  position('s:5:"level";i:' in "data") + 14,
                  position(';' in SUBSTRING(
                  "data",
                  position('s:5:"level";i:' in "data") + 14, 4)) - 1
                ), 'escape')::int "level" 
            FROM
                {{%auth_item}}
            ORDER BY "level"
        )
SQL;

    /**
     *
     * @var type 
     */
    public function authAssigmentWithRoles()
    {
        return <<<SQL
        (
            SELECT
                tt0.user_id::int,
                STRING_AGG(tt0.item_name, ', ' ORDER BY tt1.level) roles,
                MIN(tt1.level) as max_level
            FROM {{%auth_assignment}} tt0
            LEFT JOIN {$this->authItemWithLevel} tt1 
                ON tt0.item_name = tt1.name
            GROUP BY tt0.user_id
        )
SQL;
    }

    public function getAuthItemCanManage()
    {
        if ($this->username === 'superadmin') {
            return $this->db->createCommand(
                <<<SQL
                SELECT t0.name, t0.description, t0.level FROM ($this->authItemWithLevel) t0
    SQL
            )->queryAll();
        }
        return $this->db->createCommand(
            <<<SQL
            SELECT t0.name, t0.description, t0.level FROM ($this->authItemWithLevel) t0
            WHERE t0.level > $this->maxLevel
SQL
        )->queryAll();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPendudukAsProfile()
    {
        return $this->hasOne(PendudukExt::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPegawaiAsProfile()
    {
        return $this->hasOne(PegawaiExt::className(), ['user_id' => 'id']);
    }

    public function getNama()
    {
        if ($this->_nama === null) {
            $this->_nama = $this->pegawaiAsProfile ?
                $this->pegawaiAsProfile->nama : ($this->pendudukAsProfile ?
                    $this->pendudukAsProfile->nama : $this->username
                );
        }
        return $this->_nama;
    }

    public function getNamaLink()
    {
        if ($this->_namaLink === null) {
            if ($this->pegawaiAsProfile) {
                $this->_namaLink = Html::a(
                    $this->pegawaiAsProfile->nama,
                    [
                        '/pegawai/view', 'id' => $this->pegawaiAsProfile->id
                    ]
                );
                $this->_opdName = $this->pegawaiAsProfile->opd->nama;
            } elseif ($this->pendudukAsProfile) {
                if ($this->pendudukAsProfile->pejabatDaerah) {
                    $this->_namaLink = Html::a(
                        $this->pendudukAsProfile->nama,
                        [
                            '/pejabat-daerah/view', 'id' => $this->pendudukAsProfile->pejabatDaerah->id
                        ]
                    );
                } else {
                    $this->_namaLink = Html::a(
                        $this->pendudukAsProfile->nama,
                        [
                            '/penduduk/view', 'id' => $this->pendudukAsProfile->id
                        ]
                    );
                }
            } else {
                $this->_namaLink = $this->username;
            }
        }
        return $this->_namaLink;
    }

    public function getOpd()
    {
        return $this->_opdName;
    }

    public function imageId($data)
    {
        return Yii::$app->security->hashData(
            implode('|', $data),
            Yii::$app->params['hashKeyImgUser']
        );
    }

    /**
     * 
     * @param type $id
     * @return Array
     */
    public static function imageIdExtract($id)
    {
        return explode('|', Yii::$app->security->validateData(
            $id,
            Yii::$app->params['hashKeyImgUser']
        ));
    }

    public function getUploadPath()
    {
        $path0 = Yii::getAlias('@uploads') . DIRECTORY_SEPARATOR . 'users';
        $path1 = $path0 . DIRECTORY_SEPARATOR . $this->id;
        if (!is_dir($path0)) {
            mkdir($path0);
        }

        if (!is_dir($path1)) {
            mkdir($path1);
        }

        return $path1;
    }

    public function getPhotoProfileUrl($size = 'main')
    {
        if (isset($this->profile['cropper']) && isset($this->profile['cropper'][$size])) {
            return $this->profile['cropper'][$size];
        }
        return '';
    }

    private $_opdAdmin;

    /**
     * Return OPD ID if this user have ADMINOPD role
     * @return integer|null
     */
    public function getOpdAdmin()
    {
        $auth = Yii::$app->authManager;
        //$roles = $auth->getRolesByUser(Yii::$app->user->id);
        $roles = $auth->getRolesByUser($this->id);

        if (isset($roles[self::ROLE_ADMIN_OPD])) {
            if ($this->_opdAdmin === null) {
                $this->_opdAdmin = $this->pegawaiAsProfile->opd_id;
            }
            return $this->_opdAdmin;
        }
        return null;
    }

    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQueryExt(get_called_class());
    }

    public function getToken()
    {
        //return JWT::encode($this->toArray(), Yii::$app->params['jwtKey']);
        return  JWT::encode(['id' => $this->id, 'createdTime' => time()], Yii::$app->params['jwtKey'], 'HS256');
    }
}
