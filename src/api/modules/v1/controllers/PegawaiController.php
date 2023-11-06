<?php

namespace api\modules\v1\controllers;

use api\modules\v1\components\rest\ActiveController;
use api\modules\v1\models\PegawaiSearch;
use common\models\PegawaiExt;
use common\models\UserExt;

class PegawaiController extends ActiveController
{

    public $modelClass = 'common\models\PegawaiExt';
    public $searchModelClass = PegawaiSearch::class;

    public function actionGenerateUser($id)
    {
        $result = ['success' => false, 'message' => 'Pegawai ini sudah mempunyai akun user.'];
        $model = PegawaiExt::findOne($id);
        if ($model->user) {
            if (!$model->user->can(UserExt::ROLE_ASN)) {
                $model->user->assign(UserExt::ROLE_ASN);
                return ['success' => true, 'message' => 'Pegawai ini sudah mempunyai akun user.'];
            }
        } else {
            $user = UserExt::findOne(['username' => $model->nip]);
            if ($user) {
                return $model->existingUser($user);
            } else {
                return $model->generateNewUser();
            }
        }
        return $result;
    }
}
