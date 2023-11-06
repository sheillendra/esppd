<?php

namespace api\modules\v1\models;

use Yii;
use yii\web\ForbiddenHttpException;

class PendudukExt extends \common\models\PendudukExt
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
                //PENDING
                //lihat jabatan daerah, ada opd id
            } else  if (Yii::$app->user->can(UserExt::ROLE_PENDUDUK)) {
                $this->id = Yii::$app->user->id;
            }else{
                throw new ForbiddenHttpException('Anda tidak diijinkan melihat data ini');
            }
        }
        return parent::beforeValidate();
    }
}
