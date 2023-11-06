<?php

namespace api\modules\v1\models;

use Yii;
use yii\web\ForbiddenHttpException;

class PegawaiExt extends \common\models\PegawaiExt
{
    /**
     * Alasan penempatan di sini:
     * 1. Agar tidak tereplace jika model search di generate gii
     * 2. 
     */
    public function beforeValidate()
    {
        $get = Yii::$app->request->get();
        if(isset($get['q'])){
            $this->nama_tanpa_gelar = $get['q'];
        }

        if (Yii::$app->user->can(UserExt::ROLE_ADMIN)) {
        } else {
            if (Yii::$app->user->can(UserExt::ROLE_ADMIN_OPD)) {
                $this->opd_id = Yii::$app->user->identity->pegawaiAsProfile->opd_id;
            } else  if (Yii::$app->user->can(UserExt::ROLE_ASN)) {
                $this->id = Yii::$app->user->id;
            }else{
                throw new ForbiddenHttpException('Anda tidak diijinkan melihat data ini');
            }
        }
        return parent::beforeValidate();
    }
}
