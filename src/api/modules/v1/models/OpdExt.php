<?php

namespace api\modules\v1\models;

use Yii;
use yii\web\ForbiddenHttpException;

class OpdExt extends \common\models\OpdExt
{
    /**
     * Alasan penempatan di sini:
     * 1. Agar tidak tereplace jika model search di generate gii
     * 2. 
     */
    public function beforeValidate()
    {
        if (Yii::$app->user->can(UserExt::ROLE_ADMIN)) {
        } else {
            if (Yii::$app->user->can(UserExt::ROLE_ADMIN_OPD)) {
                $this->id = Yii::$app->user->identity->pegawaiAsProfile->opd_id;
            } else  if (Yii::$app->user->can(UserExt::ROLE_ASN)) {
                $this->id = Yii::$app->user->identity->pegawaiAsProfile->opd_id;
            }else{
                throw new ForbiddenHttpException('Anda tidak diijinkan melihat data ini');
            }
        }
        return parent::beforeValidate();
    }
}
