<?php

namespace api\modules\v1\models;

use Yii;
use yii\web\ForbiddenHttpException;

class ProdukHukumExt extends \common\models\ProdukHukumExt
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
            $this->nama = $get['q'];
        }

        return parent::beforeValidate();
    }
}
