<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use Dompdf\Dompdf;
use common\models\SuratTugasExt;
use common\models\SppdExt;
use common\models\RincianBiayaSppdExt;

/**
 * Feedback controller
 */
class ImageController extends Controller
{

    public $layout = '//blank';

    /**
     * Displays feedback.
     *
     * @return mixed
     */
    public function actionUser($id)
    {
        $data = Yii::$app->user->identity->imageIdExtract($id);
        if (!count($data)) {
            return 'ID tidak benar';
        }

        if (!$data[2] && $data[0] != Yii::$app->user->id) {
            return 'Tidak dijinkan';
        }
        return $this->response(Yii::getAlias('@uploads/users') .
            DIRECTORY_SEPARATOR . $data[0] . DIRECTORY_SEPARATOR . $data[1]);
    }

    public function actionBarcodeSuratTugas($id)
    {
        return $this->response(Yii::getAlias('@uploads/surat-tugas/' . $id . '/qrcode.png'));
    }

    public function actionBarcodeSppd($id)
    {
        return $this->response(Yii::getAlias('@uploads/sppd/' . $id . '/sppd_qrcode.png'));
    }

    protected function response($imgFullPath)
    {
        $size = getimagesize($imgFullPath);
        $response = Yii::$app->getResponse();
        $response->headers->set('Content-Type', $size['mime']);
        $response->headers->set('Content-Length', filesize($imgFullPath));
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
