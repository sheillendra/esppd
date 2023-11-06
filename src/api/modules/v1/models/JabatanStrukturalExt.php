<?php

namespace api\modules\v1\models;

use Yii;
use yii\web\ForbiddenHttpException;

class JabatanStrukturalExt extends \common\models\JabatanStrukturalExt
{
    public function extraFields()
    {
        return ['opd'];
    }

    public function beforeValidate()
    {
        $get = Yii::$app->request->get();
        if(isset($get['q'])){
            $this->nama = $get['q'];
            $this->nama_2 = $get['q'];
            $this->singkatan = $get['q'];
        }

        if (Yii::$app->user->can(UserExt::ROLE_ADMIN)) {
        } else {
            if (Yii::$app->user->can(UserExt::ROLE_ADMIN_OPD)) {
                $this->opd_id = Yii::$app->user->identity->pegawaiAsProfile->opd_id;
            } else  if (Yii::$app->user->can(UserExt::ROLE_ASN)) {
                $this->opd_id = Yii::$app->user->identity->pegawaiAsProfile->opd_id;
            }else{
                throw new ForbiddenHttpException('Anda tidak diijinkan melihat data ini');
            }
        }
        return parent::beforeValidate();
    }
}
