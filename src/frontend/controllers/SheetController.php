<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\SppdExt;

/**
 * Feedback controller
 */
class SheetController extends Controller {

    public $layout = '//blank';

    /**
     * Displays feedback.
     *
     * @return mixed
     */
    public function actionRegisterSppd($id) {
        $unhas = SppdExt::sheetIdExtract($id);
        if (empty($unhas[0])) {
            return 'ID file salah';
        }

        $path = Yii::getAlias('@uploads') . DIRECTORY_SEPARATOR . 'sppd' . DIRECTORY_SEPARATOR . 'register';
        return $this->response($path . DIRECTORY_SEPARATOR . $unhas[1], $unhas[1]);
    }

    protected function response($imgFullPath, $filename) {
        $response = Yii::$app->getResponse();
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Length', filesize($imgFullPath));
        $response->headers->set('Content-Disposition', 'inline; filename=' . $filename);
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'max-age=86400');
        $response->headers->set('Expires', gmdate('D, d M Y H:i:s \G\M\T', time() + 86400));
        $response->format = $response::FORMAT_RAW;

        if (!is_resource($response->stream = fopen($imgFullPath, 'r'))) {
            throw new \yii\web\ServerErrorHttpException('file access failed: permission deny');
        }
        return $response->send();
    }

}
