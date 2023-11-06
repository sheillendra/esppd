<?php

namespace api\modules\v1\controllers;

use api\modules\v1\components\rest\ActiveController;
use common\models\InitialDataForm;
use Yii;
use yii\web\UploadedFile;

class UploadController extends ActiveController
{

    public $modelClass = InitialDataForm::class;

    public function actionInitialData()
    {
        $result = [
            'success' => false,
            'message' => '',
        ];

        $model = new InitialDataForm();
        $model->fileInit = UploadedFile::getInstanceByName('fileInit');
        if ($model->upload()) {
            $result['success'] = true;
        } else {
            $result['message'] = ['error' => implode($model->getFirstErrors())];
        }
        $result['message'] = $model->message();

        return $result;
    }
}
