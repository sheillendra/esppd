<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use Dompdf\Dompdf;
use common\models\SuratTugasExt;
use common\models\SppdExt;
use common\models\RincianBiayaSppdExt;
use Dompdf\Options;

/**
 * Feedback controller
 */
class PdfController extends Controller {

    public $layout = '//blank';

    /**
     * Displays PDF suratTugas.
     *
     * @return mixed
     */
    public function actionSuratTugas($id, $force = false, $raw = false) {
        $data = SuratTugasExt::pdfIdExtract($id);
        if (empty($data[0])) {
            return 'ID file salah';
        }

        $path0 = Yii::getAlias('@uploads') . DIRECTORY_SEPARATOR . 'surat-tugas';
        $path1 = $path0 . DIRECTORY_SEPARATOR . $data[0];
        $pdfFile = $path1 . DIRECTORY_SEPARATOR . $data[1];
        
        if ($force === false && is_file($pdfFile)) {
            return $this->display($pdfFile, $data[1]);
        }
        
        $model = SuratTugasExt::findOne(['id' => $data[0]]);
        if (!$model) {
            return 'Surat tugas tidak ditemukan';
        }

        $type = $data[2];

        $fileField = 'pdf_filename_' . $type;
        $modelFilename = $path1 . DIRECTORY_SEPARATOR . $model->{$fileField};
        if ($force || $model->{$fileField} === null || is_file($modelFilename) === false ) {
            if ($type === $model::PDF_TYPE_TTD) {
                return 'Surat tugas yang sudah ditandatangani belum diupload';
            }

            //prepare generate pdf
            if (!is_dir($path0)) {
                mkdir($path0);
            }

            if (!is_dir($path1)) {
                mkdir($path1);
            }
            $filename = time() . '_surat_tugas_' . $type . '.pdf';

            $params = [
                'model' => $model,
                'type' => $type,
                'path' => $path1,
                'force' => $force
            ];
            if ($raw) {
                return $this->render('surat-tugas', $params);
            }

            if ($this->generatePdf('surat-tugas', $params, $path1 . DIRECTORY_SEPARATOR . $filename)) {
                $model->{$fileField} = $filename;
                $model->save();
                $modelFilename = $path1 . DIRECTORY_SEPARATOR . $filename;
            }
        }
        return $this->display($modelFilename, $model->{$fileField});
    }

    /**
     * Displays feedback.
     *
     * @return mixed
     */
    public function actionSppd($id, $force = false, $raw = false) {
        $data = SppdExt::pdfIdExtract($id);
        if (empty($data[0])) {
            return 'ID file salah';
        }
        $model = SppdExt::findOne(['id' => $data[0]]);
        if (!$model) {
            return 'SPPD tidak ditemukan';
        }

        $doc = $data[1];
        $type = $data[2];
        $path1 = $model->getUploadPath();
        $fileField = 'pdf_filename_' . $doc . '_' . $type;
        $modelFilename = $path1 . DIRECTORY_SEPARATOR . $model->{$fileField};
        if ($force || !$model->{$fileField} || !is_file($modelFilename)) {
            if ($type === $model::PDF_TYPE_TTD) {
                return 'Surat tugas yang sudah ditandatangani belum diupload';
            }

            $filename = time() . '_' . $doc . '_' . $type . '.pdf';
            $params = [
                'model' => $model,
                'type' => $type,
                'path' => $path1,
                'force' => $force
            ];
            if ($raw) {
                return $this->render($doc, $params);
            }
            if ($this->generatePdf(
                            $doc
                            , $params
                            , $path1 . DIRECTORY_SEPARATOR . $filename)) {
                $model->{$fileField} = $filename;
                $model->save();
                $modelFilename = $path1 . DIRECTORY_SEPARATOR . $filename;
            }
        }

        return $this->display($modelFilename, $model->{$fileField});
    }

    public function actionSppdBukti($id) {
        $model = RincianBiayaSppdExt::findOne(['id' => $id]);
        if ($model) {
            return $this->display(Yii::getAlias('@uploads') . DIRECTORY_SEPARATOR .
                            'sppd' . DIRECTORY_SEPARATOR .
                            $model->sppd_id . DIRECTORY_SEPARATOR .
                            $model->pdf_bukti, $model->pdf_bukti
            );
        }
        return 'tidak ada';
    }

    protected function generatePdf($view, $params, $path) {
        try {
            $options = new Options();
            $options->set(['isRemoteEnabled' => true]);
            $pdf = new Dompdf($options);
            $pdf->loadHtml($this->renderPartial($view, $params));
            $pdf->render();
            file_put_contents($path, $pdf->output());
            return true;
        } catch (\Exception $ex) {
            Yii::error($ex->getMessage());
        }
        return false;
    }

    protected function display($path, $filename) {
        ob_end_clean();
//        header("Content-type: application/pdf");
//        header("Content-Disposition: inline; filename=" . $filename);
//        @readfile($path);

        $response = Yii::$app->getResponse();
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Length', filesize($path));
        $response->headers->set('Content-Disposition', 'inline; filename=' . $filename);
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'max-age=86400');
        $response->headers->set('Expires', gmdate('D, d M Y H:i:s \G\M\T', time() + 86400));
        $response->format = $response::FORMAT_RAW;

        if (!is_resource($response->stream = fopen($path, 'r'))) {
            throw new \yii\web\ServerErrorHttpException('file access failed: permission deny');
        }
        return $response->send();
    }

}
