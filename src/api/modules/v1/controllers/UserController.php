<?php

namespace api\modules\v1\controllers;

use Yii;
use api\modules\v1\components\rest\ActiveController;
use common\models\ProfileForm;
use api\modules\v1\models\UserExt;
use api\modules\v1\models\UserSearch;
use common\models\ChangePasswordForm;
use common\models\UserExt as ModelsUserExt;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;

class UserController extends ActiveController
{

    public $modelClass = UserExt::class;
    public $searchModelClass = UserSearch::class;

    protected function verbs()
    {
        return array_merge(parent::verbs(), [
            'upload-profile-photo' => ['post'],
            'reset-password' => ['post'],
            'assign' => ['post'],
        ]);
    }

    public function actionUploadProfilePhoto()
    {
        $model = new ProfileForm();
        return $model->upload();
    }

    public function actionResetPassword($id)
    {
        $result = [
            'message' => ''
        ];
        $model = $this->modelClass::findOne($id);
        $password = rand(111111, 999999);
        $model->setPassword($password);
        if ($model->save()) {
            $result['message'] = 'Reset password <kbd>' .
                $model->username . '</kbd> berhasil dengan password baru: <kbd>' .
                $password . '</kbd>';
        } else {
            throw new ServerErrorHttpException($model->getFirstErrors());
        }
        return $result;
    }

    public function actionChangePassword()
    {
        $result = [
            'success' => false,
            'message' => '',
        ];
        $model = new ChangePasswordForm();
        if ($model->load(Yii::$app->request->post(), '') && $model->change()) {
            Yii::$app->user->logout();
            $result['success'] = true;
        } else {
            $result['message'] = implode(', ',$model->getFirstErrors());
        }
        return $result;
    }

    public function actionAssign($id)
    {
        $result = [
            'success' => false,
            'message' => ''
        ];

        $model = $this->modelClass::findOne($id);
        if (!$model) {
            $result['message'] = 'User tidak ditemukan';
            return $result;
        }

        if (
            !Yii::$app->user->can(ModelsUserExt::ROLE_SUPERADMIN) &&
            $model->maxLevel <= Yii::$app->user->identity->maxLevel
        ) {
            $result['message'] = 'Anda tidak bisa mengatur user dengan level yang lebih tinggi';
            return $result;
        }

        $roleName = Yii::$app->request->post('role');
        if (empty($roleName)) {
            $result['message'] = 'Role tidak boleh kosong';
            return $result;
        }

        $auth = Yii::$app->authManager;
        $revoke = Yii::$app->request->post('revoke');
        if ($auth->getAssignment($roleName, $id)) {
            if (!$revoke) {
                $result['message'] = 'Role ini sudah dimiliki oleh user';
                return $result;
            }
        } else {
            if ($revoke) {
                $result['message'] = 'Role tidak dimiliki oleh user';
                return $result;
            }
        }

        $role = $auth->getRole($roleName);
        if ($role) {
            if ($revoke) {
                $auth->revoke($role, $model->id);
                $result['message'] = 'Revoke sukses';
            } else {
                $auth->assign($role, $model->id);
                $result['message'] = 'Assign sukses';
            }
            $result['success'] = true;
            $auth->invalidateCache();
        } else {
            $result['message'] = 'Role tidak ditemukan';
        }
        return $result;
    }

    public function actionAllRoles()
    {
        return Yii::$app->user->identity->allRolesWithLabel;
        //return Yii::$app->user->identity->allRolesWithLabel;
    }
}
